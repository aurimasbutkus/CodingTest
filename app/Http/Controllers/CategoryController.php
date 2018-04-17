<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Category;

class CategoryController extends Controller
{
    public function index()
    {
    	$allCategories = \App\Category::all();
    	$rootCategories = \App\Category::root()->get();
    	$string = "";
    	foreach($rootCategories as $category)
    	{
    		$string = $this->print($category, $string, 0);
    	}
    	return view('main', compact("allCategories", "rootCategories", "string"));
    }

    public function create(Request $request)
    {
    	\App\Category::create([
    		'name' => $request->name,
    		'parent_id' => $request->parent_id
    	]);

    	return $this->index();
    }

    public function print(Category $category, String $string, $tier)
    {
    	$string = $string . str_repeat('&nbsp', $tier) . $category->name . '<br/>';
    	$tier++;
    	foreach($category->subCategories as $subCategory)
    	{
    		$string = $this->print($subCategory, $string, $tier);
    	}
    	return $string;
    }
}
