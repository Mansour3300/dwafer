<?php

namespace App\Models;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at'];

    public function developer(){
        return $this->belongsToMany(Provider::class,'sub_category_provider');
    }
}
