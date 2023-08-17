<?php

namespace App\Models;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at'];

    public function subCategory(){
        return $this->hasmany(SubCategory::class);
    }
}
