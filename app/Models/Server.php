<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = ['name','code'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function subscribers(){
        return $this->belongsToMany(User::class,'users_servers');
    }
    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
