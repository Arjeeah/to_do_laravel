<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['user_id','server_id', 'name', 'description', 'before_date', 'priority', 'status'];
    public function server(){
        return $this->belongsTo(Server::class);
    }
    public function users(){
        return $this->belongsToMany(User::class,"user_tasks");
    }
}

