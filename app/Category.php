<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

	protected $fillable = [
        'name', 'parent_id',
    ];

    public function subCategories()
    {
    	return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
    	return $this->belongsTo(Category::class);
    }

    public function scopeRoot($query)
    {
    	return $query->where('parent_id', '=', '0');
    }
}