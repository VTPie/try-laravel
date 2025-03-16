<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index(){
        $usersInfo = User::all();

        return view(
            'user/index', compact('usersInfo')
        );
    }

    public function create(){
        $pageTitle = 'User - Add';
        $pageName = 'Add new User';
        $targetRoute = route('user.store');
        return view('user/userForm', compact('pageName', 'targetRoute', 'pageTitle'));
    }

    public function store(UserRequest $request){
        try {
            User::create([
                'username' => $request['username'],
                'password' => md5($request['password'])
            ]);

            return redirect()
                ->route('user.index')
                ->with('message', 'Add Success!');
        } catch (\Exception $e) {
            return redirect()
                ->route('user.index')
                ->with('message', 'Add Failed: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $userInfo = User::findOrFail($id);
            $userInfo->delete();
            return redirect()
                ->route('user.index')
                ->with('message', 'Delete Success!');
        } catch (\Exception $e) {
            return redirect()
                ->route('user.index')
                ->with('message', 'Delete Failed: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $pageTitle = 'User - Edit';
        // Redirect to the 404 page if no valid record is found.
        $userInfo = User::findOrFail($id);
        $pageName = 'Edit User';
        $targetRoute = route('user.update', ['id' => $id]);
        $method = 'PUT';
        return view('user/userForm', compact('userInfo', 'pageName', 'targetRoute', 'method', 'pageTitle'));
    }

    public function update(UserRequest $request, $id){
        try {
            $userInfo = User::findOrFail($id);

            if ($request->filled('password')) {
                if (md5($request['current_password']) != $userInfo->password) {
                    return redirect()
                    ->route('user.edit', ['id' => $id])
                    ->with('message', 'The current password is incorrect!');
                }
                $userInfo->update([
                    'username' => $request->validated()['username'],
                    'password' => $request->validated()['password'] ? md5($request->validated()['password']) : $userInfo->password
                ]);
            } else {
                $userInfo->update([
                    'username' => $request->validated()['username'],
                ]);
            }

            return redirect()
                ->route('user.index')
                ->with('message', 'Update Success!');
        } catch (\Exception $e) {
            return redirect()
                ->route('user.index')
                ->with('message', 'Update Failed: ' . $e->getMessage());
        }
    }
}
