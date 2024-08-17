<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Str;

class ServerController extends Controller
{
    public function store(Request $request){
        $request->validate( [
            'name'=>['required','string']
        ]);
        if (auth()->user()->server()->exists()){
            return response()->json([
                'error'=> 'alredy have server'
                ]);

        }
        $server = auth()->user()->server()->create([
            'name'=>$request->name,
            'code'=>$this->gent()
            ]);
            $server->subscribers()->attach(auth('api')->id());
            return response()->json([
                'status'=> 'success',
                'code'=> $server->code,
            ]); 

    }


    public function gent():string{
        $code=Str::random(6);
        if (Server  ::where("code",$code)->exists()){   
            $this->gent();
        }
            return $code;
    }
    public function update(Request $request){
        $request->validate( [
            "name"=>["required","string"]
            ]);
            auth()->user()->server()->firstOrFail()->update( $request->all() );
            return response()->json([
                "status"=> "success",
            ]);
        }
        public function destroy(){
            auth()->user()->server()->firstOrFail()->delete();
            return response()->json([
                "status"=> "success"
                ]);
            }

            public function show(){
                $info=auth()->user()->server()->firstOrFail();
                return response()->json([
                    "server"=> $info
                    ]);
            }
          


}
