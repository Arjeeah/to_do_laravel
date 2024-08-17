<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploaderController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'img'=>['required','mimes:jpg,png','max:1024'],
        ]);
        $img= $request->file('img')->store('/avatar','public');
        return response()->json([
            'data'=>$img
            ]);
            
        
    }
}
