<?php

namespace App\Http\Controllers;
use App\Models\Picture;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PictureRequest;

class PictureController extends Controller
{
    public function index(){
        $pictureList = Picture::all();

        return view(
            'picture/index',
            compact('pictureList')
        );
    }

    public function create(){
        $pageTitle = 'Picture - Add';
        $pageName = 'Add new Picture';
        $targetRoute = route('picture.store');

        return view('picture/pictureForm', compact('pageName', 'targetRoute', 'pageTitle'));
    }

    public function store(PictureRequest $request){
        try {
            // Store the picture in the storage/app/public/images folder
            $pictureFolder = 'public/' . config("picture.image_folder");
            $imgName = sprintf('%s_%s.%s', $request['name'], now()->format('ymdHis'), $request['file']->extension());
            $storageResult = $request['file']->storeAs($pictureFolder, $imgName);
            if (!$storageResult) {
                throw new \Exception('Failed to store the picture');
            }

            // Save the picture path to the database
            $picturePath = sprintf('%s/%s', config("picture.image_folder"), $imgName);
            Picture::create([
                'name' => $request['name'],
                'picture_url' => $picturePath
            ]);

            return redirect()
                ->route('picture.index')
                ->with('message', 'Add Success!');
        } catch (\Exception $e) {
            return redirect()
                ->route('picture.index')
                ->with('message', 'Add Failed: ' . $e->getMessage());
        }
    }

    public function edit($id){
        // Redirect to the 404 page if no valid record is found.
        $pictureInfo = Picture::findOrFail($id);
        $pageName = 'Edit Picture';
        $pageTitle = 'Picture - Edit';
        $targetRoute = route('picture.update', ['id' => $id]);
        $method = 'PUT';

        return view('picture/pictureForm', compact('pictureInfo', 'pageName', 'targetRoute', 'method', 'pageTitle'));
    }

    public function update(PictureRequest $request, $id){
        try {
            $pictureInfo = Picture::findOrFail($id);
            $newPictureUrl = $pictureInfo->picture_url;

            if ($request->hasFile('file')) {
                // Delete the old file in the storage
                Storage::delete($pictureInfo->picture_url);

                // Store the new file in the storage
                $imageFullPath = 'public/' . config("picture.image_folder");
                $imgName = explode('/', $pictureInfo->picture_url)[1]; // Just update file
                if ($request['name'] != $pictureInfo->name) { // Update both file name and file
                    $imgName = sprintf('%s_%s.%s', $request['name'], now()->format('ymdHis'), $request['file']->extension());
                    $newPictureUrl = sprintf('%s/%s', config("picture.image_folder"), $imgName);
                }
                $request['file']->storeAs($imageFullPath, $imgName);
            } else if ($request['name'] != $pictureInfo->name) { // Just update filename
                // Get the new picture URL
                $newPictureUrl = str_replace(
                    '/' . $pictureInfo->name,
                    '/' . $request['name'],
                    $pictureInfo->picture_url
                );
                // Rename the file in the storage
                if (Storage::exists('public/' . $pictureInfo->picture_url)) {
                    Storage::move(
                        'public/' . $pictureInfo->picture_url,
                        'public/' . $newPictureUrl
                    );
                }
            }

            // Update the image info to the database
            $pictureInfo->update([
                'name' => $request['name'],
                'picture_url' => $newPictureUrl
            ]);

            return redirect()
                ->route('picture.index')
                ->with('message', 'Update Success!');
        } catch (\Exception $e) {
            return redirect()
                ->route('picture.index')
                ->with('message', 'Update Failed: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $pictureInfo = Picture::findOrFail($id);

            // Delete picture from file storage
            $pictureFullPath = sprintf('%s/%s', 'public/', $pictureInfo->picture_url);
            // Storage::disk(config('filesystems.default'))->delete($pictureFullPath);
            if (Storage::exists($pictureFullPath)) {
                Storage::delete($pictureFullPath);
            }

            // Delete picture path from the database
            $pictureInfo->delete();

            return redirect()
                ->route('picture.index')
                ->with('message', 'Delete Success!');
        } catch (\Exception $e) {
            return redirect()
                ->route('picture.index')
                ->with('message', 'Delete Failed: ' . $e->getMessage());
        }
    }
}
