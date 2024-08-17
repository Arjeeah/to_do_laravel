<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserServer extends Model
{
    protected $fillable = ['user_id','server_id'];
    
}
