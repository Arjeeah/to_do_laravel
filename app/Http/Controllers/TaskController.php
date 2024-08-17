<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name'=> ['required','string'],
            'priority'=> ['required','min:1','max:5'],
            'status'=> ['string','in:Not-Started,In-Progress,Completed,Cancelled','nullable'],
            'before_date'=>['date'],
        ]);
        $task=auth('api')->user()->server()->firstOrFail()->tasks()->create([
            'name'=> $request->name,
            'user_id'=>auth()->id() ,
            'priority'=>$request->priority,
            'status'=> $request['status'] ?? null,
            'before_date'=> $request->before_date,
            'description'=> $request->description,
        ]); 
    return response()->json([
        'status'=> 'success',
        'message'=> $task
        ]);

    }
    public function update(Request $request, $id){
     $input= $request->validate([
            'name'=> ['string'],
            'status'=> ['string','in:Not-Started,In-Progress,Completed,Cancelled','nullable']
            ]);
            auth('')->user()->server()->firstOrFail()->tasks()->findOrFail( $id )->update($input);
            return response()->json([
                'status'=> 'success',
                'message'=>    auth('')->user()->server()->firstOrFail()->tasks()->findOrFail( $id )
                ]);
            }
            public function destroy($id){
                auth('')->user()->server()->firstOrFail()->tasks()->findOrFail($id)->delete();
                return response()->json([
                    'status'=> 'deleted'
                    ]);
                }
                public function index($code){
                    $tasks=auth()->user()->subscriptions()->where('code', $code)->firstOrFail()->tasks()->get();
                    return response()->json([
                        'status'=> 'success',
                        'date'=> $tasks
                        ]);


                }
                public function show( $id){

                    $task=auth()->user()->server()->firstOrFail()->tasks()->findOrFail( $id );
                    return response()->json([
                        'status'=> 'success',
                        'date'=> $task
                        ]);

                }



}
