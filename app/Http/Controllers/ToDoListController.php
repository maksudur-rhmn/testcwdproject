<?php

namespace App\Http\Controllers;

use App\ToDoList;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ToDoListController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $todolists = ToDoList::all();
       // $done = ToDoList::selectRaw('count(*) as done')->groupBy('done')->where('done', 1)->get();
       $done = ToDoList::where('done', 0)->exists();
       // $done = ToDoList::select('done')->where('done', 1)->get();
       return view('todolist.index', compact('todolists', 'done'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
         'what_to_do' => 'required',
         'when_to_do' => 'required',
       ]);

       $what = $request->what_to_do;

       if(preg_match('~[0-9]+~', $what))
       {
         return back()->withErrors('To Do list cannot contain any number');
       }
       else
       {
         ToDoList::create([
           'what_to_do'    =>$request->what_to_do,
           'when_to_do'    =>$request->when_to_do,
           'created_at'    =>Carbon::now(),
         ]);
         return back()->withSuccess('To Do List Added');
       }



       // END
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function show(ToDoList $toDoList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function edit(ToDoList $toDoList, $id)
    {
        $toDoList->findOrFail($id)->update([
          'done' => 1
        ]);
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDoList $toDoList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDoList $toDoList)
    {
        //
    }
    public function alldone()
    {

      ToDoList::where('done', 0)->update(['done' => 1]);
      return back();
    }
    public function alldelete()
    {
      ToDoList::truncate();
      return back();
    }
}
