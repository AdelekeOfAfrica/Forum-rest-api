<?php

namespace App\Models;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded =[];

    protected static function boot() {
        parent::boot();
        static::deleting(function ($category){
            $category->sub_categories()->delete();
        });
    }

    public function sub_categories(){
        return $this->hasMany(SubCategory::class);
    }
    
}
