<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserTaskController extends Controller
{
    public function store(Request $request){
        $request->validate([    
            'user_id'=>['required','exists:users,id'],
            'task_id'=>['required','exists:tasks,id'],
        ]);
        $task=auth()->user()->server()->firstOrFail()->tasks()->findOrFail($request->task_id);
        auth()->user()->server()->firstOrFail()->subscribers()->findOrFail($request->user_id)
        ->tasks()->attach($task);               
        return response()->json([
            'status'=> 'success',
            'message'=> 'done'
            ]);
        
    }
    public function destroy(Request $request){
        $request->validate([    
            'user_id'=>['required','exists:users,id'],
            'task_id'=>['required','exists:tasks,id'],
        ]);
        auth()->user()->server()->firstOrFail()->tasks()->findOrFail($request->task_id)
        ->users()->findOrFail($request->user_id)->tasks()->detach($request->task_id);

        return response()->json([
            'status'=> 'success',
            'message'=> 'done'
            ]);
    }
    public function update(Request $request, $id){
        $input= $request->validate([
               'name'=> ['string'],
               'status'=> ['string','in:Not-Started,In-Progress,Completed,Cancelled','nullable']
               ]);
               auth('')->user()->tasks()->findOrFail( $id )->update($input);
               return response()->json([
                   'status'=> 'success',
                   'message'=>   auth('')->user()->tasks()->findOrFail( $id )
                   ]);
               }
    



}
