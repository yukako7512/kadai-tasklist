<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Tasklist;

class TasklistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $tasklist = [];
          if (\Auth::check()) {
              
            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);

            $tasklist = [
                'user' => $user,
                'tasklists' => $tasklists,
            ];
           
            return view('tasklists.index', $tasklist);
          }else {
            return view('welcome');
        }
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::check()) {
        $tasklist = new Tasklist;

        return view('tasklists.create', [
            'tasklist' => $tasklist,
        ]);
        
        }    
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

        'content' => 'required|max:10',
         'status' => 'required|max:10',
        ]);
        $tasklist = new Tasklist;
        $tasklist->content = $request->content;
        $tasklist->status = $request->status;
        $tasklist->user_id = \Auth::user()->id;
        $tasklist->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
           if (\Auth::check()) {
            $user = \Auth::user();
            $tasklist = Tasklist::find($id);
            
            if ($tasklist->user_id == $user->id) {
                 $tasklist = Tasklist::find($id);
                
                
                return view('tasklists.show', [
                    'tasklist' => $tasklist,
                ]);
                
            } else {
                // 一覧ページへリダイレクト
                return redirect('/');
            }
        } else {
            
            //  welcome ページへリダイレクト
            return view('welcome');
    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    $tasklist = Tasklist::find($id);
        
        if (\Auth::check()) {
        
        if (\Auth::user()->id === $tasklist->user_id) {
            return view('tasklists.edit', [
            'tasklist' => $tasklist,]);
        } }
        return redirect('/');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          $this->validate($request, [
             
            'content' => 'required|max:10',
            'status' => 'required|max:10',
        ]);

        $tasklist = Tasklist::find($id);
        $tasklist->content = $request->content;
        $tasklist->status = $request->status;
        $tasklist->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasklist = Tasklist::find($id);
        
        if (\Auth::user()->id === $tasklist->user_id) {
        $tasklist->delete();
        }
        return redirect('/');
    }
}
