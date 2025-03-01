<?php

namespace App\Http\Controllers;
use App\Models\TodoInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;

class TodoController extends Controller
{
    public function index(Request $request){
        // Get Todo counter by status
        $statusCounter = TodoInfo::select('status', DB::raw('count(id) as counter'))
            ->groupBy('status')
            ->orderBy('status', 'asc')
            ->get();

        // Get Todo counter by priority
        $priorityCounter = TodoInfo::select('priority', DB::raw('count(id) as counter'))
            ->groupBy('priority')
            ->orderBy('priority', 'asc')
            ->get();

        $searchValue = $request->input('searchBy');

        $todoInfos = TodoInfo::query()
            // Only append the condition when the corresponding query parameter exists
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->when($request->filled('priority'), function ($query) use ($request) {
                $query->where('priority', $request->input('priority'));
            })
            ->when($request->filled('searchBy'), function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->input('searchBy') . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(5);

        return view(
            'todo/index', compact('todoInfos', 'statusCounter', 'priorityCounter', 'searchValue')
        );
    }

    public function create(){
        $pageName = 'Add new Todo';
        $targetRoute = route('todo.store');
        return view('todo/todoForm', compact('pageName', 'targetRoute'));
    }

    public function store(TodoRequest $request){
        try {
            // use mass assignment to create a new record
            // only the fillable fields in the model will be saved
            // validated() is safer than all() because it only returns validated fields (optional)
            TodoInfo::create($request->validated());

            return redirect()
                ->route('todo.index')
                ->with('message', 'Add Success!');
        } catch (\Exception $e) {
            return redirect()
                ->route('todo.index')
                ->with('message', 'Add Failed: ' . $e->getMessage());
        }
    }

    public function edit($id){
        // Redirect to the 404 page if no valid record is found.
        $todoInfo = TodoInfo::findOrFail($id);
        $pageName = 'Edit Todo';
        $targetRoute = route('todo.update', ['id' => $id]);
        $method = 'PUT';
        return view('todo/todoForm', compact('todoInfo', 'pageName', 'targetRoute', 'method'));
    }

    public function update(TodoRequest $request, $id){
        try {
            $todoInfo = TodoInfo::findOrFail($id);
            // validated() is safer than all() because it only returns validated fields (optional)
            $todoInfo->update($request->validated());
            return redirect()
                ->route('todo.index')
                ->with('message', 'Update Success!');
        } catch (\Exception $e) {
            return redirect()
                ->route('todo.index')
                ->with('message', 'Update Failed: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $todoInfo = TodoInfo::findOrFail($id);
            $todoInfo->delete();
            return redirect()
                ->route('todo.index')
                ->with('message', 'Delete Success!');
        } catch (\Exception $e) {
            return redirect()
                ->route('todo.index')
                ->with('message', 'Delete Failed: ' . $e->getMessage());
        }
    }
}