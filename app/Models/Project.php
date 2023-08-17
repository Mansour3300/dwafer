<?php

namespace App\Models;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at'];

    
}
