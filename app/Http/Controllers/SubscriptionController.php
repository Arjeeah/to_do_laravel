<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function join($code){
        $server=Server::where("code",$code)->firstOrFail();
        if(auth('api')->user()->subscriptions()->where("code", $code)->exists()){
            return response()->json([
                "error"=> "you are already joined the server "
                ]);
        }
        $server->subscribers()->attach(auth('api')->id());
        return response()->json([
            'data' => 'joined successfully'
            ]);
    }
    public function index( ){

        $info=auth()->user()->subscriptions()->get();
        return response()->json([
            "subscriptions server"=> $info
            ]);
    }
    public function server_subscribers(Request $request,$code){
        $users=  auth()->user()->subscriptions()->where("code",$code)->firstOrFail()->subscribers()->get();
        $server=Server::where('code',$code)->firstOrFail();

        // if ($request->has('name')){
        //     $search=$server->subscribers()->where('name','like','%'.$request->name.'%')->Get();
        //     return response()->json([
        //         'data'=> $search
        //         ]);
        // }

        // if ($request->has('email')){
        //     $search=$server->subscribers()->where('email','like','%'.$request->email.'%')->Get();
        //     return response()->json([
        //         'data'=> $search
        //         ]);
        //     }

        if ($request->has('search')){
            $search=$server->subscribers()->where('email','like','%'.$request->search.'%')->orWhere('name','like','%'.$request->search.'%')->get() ;
            return response()->json([
                'data'=> $search
                ]);
            }
        return response()->json([
            "data"=> $users
            ]);
    }

    public function destroy($code){
      $server=  auth()->user()->subscriptions()->where("code",$code)->firstOrFail();
      $server->subscribers()->detach(auth("")->id());
      return response()->json([
        "data"=> "leave done"
        ]);

    }
}
