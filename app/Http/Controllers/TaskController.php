<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //get tasks order by id
        $tasks = Task::where('user_id',Auth::user()->id)->with('client')->orderBy('id','DESC');

        //filter client
        if(!empty($request->client_id)){
            $tasks = $tasks->where('client_id', $request->client_id);
        }

        //filter status
        if(!empty($request->status)){
            $tasks = $tasks->where('status', $request->status);
        }

        //filter price
        if(!empty($request->price)){
            $tasks = $tasks->where('price', '<=' ,$request->price);
        }

        //filter fromData
        if(!empty($request->fromDate)){
            $tasks = $tasks->where('created_at', '>=' ,$request->fromDate);
        }

        //filter endData
        if(!empty($request->endDate)){
            $tasks = $tasks->where('created_at', '<=' ,$request->endDate);
        }

        //task with pagination
        $tasks = $tasks->paginate(10)->withQueryString();
        //SELECT * form clients

        //return view
        return view('task.index')->with([
            'clients' => Client::where('user_id',Auth::user()->id)->get(),
            'tasks'=>$tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create')->with([
            'clients'=> Client::where('user_id',Auth::user()->id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $this->taskValidate($request);
        try {
            //task store in database
            Task::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'description' =>$request->description,
                'client_id' =>$request->client_id,
                'user_id' => Auth::user()->id,
            ]);
            //return response
            return redirect()->route('task.index')->with('success','Task Created');
        }catch (\Throwable $th){
            //throw $th;
            return redirect()->route('task.index')->with('error',$th);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //task search by slug
        $task = Task::where('slug',$slug)->get()->first();
        //return response
        return view('task.show')->with('task', $task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('task.edit')->with([
            'task' => $task,
            'clients'=> Client::all(),
        ]);
    }
    public function taskValidate(Request $request)
    {
        return  $request->validate([
            'name' => ['required','max:255','string'],
            'price'=>['required','integer'],
            'client_id'=>['required','max:255','not_in:none'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //validation
        $this->taskValidate($request);
        try {
           //update data
            $task->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'description' =>$request->description,
                'user_id' => Auth::user()->id,
                'client_id' =>$request->client_id,
            ]);
            //return response
            return redirect()->route('task.index')->with('success','Task Updated');
        }catch (\Throwable $th){
            //throw $th;
            return redirect()->route('task.index')->with('error',$th);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return redirect()->route('task.index')->with('success','Task Deleted');
        }catch (\Throwable $th){
            //throw $th;
            return redirect()->route('task.index')->with('error',$th);
        }

    }
    public function markAsComplete(Task $task)
    {
        try {
            $task->update([
                'status'=>'complete',
            ]);
            return redirect()->back()->with('success','Task Complete');
        }catch (\Throwable $th){
            //throw $th;
            return redirect()->back()->with('error',$th);
        }

    }
}
