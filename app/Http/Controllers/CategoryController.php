<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Category;

class CategoryController extends Controller
{
    public function index()
    {
    	$categoriesByParent = \App\Category::orderBy('parent_id')->get();
    	$string = $this->print($categoriesByParent);
    	return view('main', compact("categoriesByParent", "string"));
    }

    public function create(Request $request)
    {
    	\App\Category::create([
    		'name' => $request->name,
    		'parent_id' => $request->parent_id
    	]);

    	return $this->index();
    }

    public function buildTierStack($categoryStack)
    {
    	$tierStack;
    	for($i = 0; $i < count($categoryStack); $i++)
    	{
    		$category = $categoryStack[$i];
    		if($category->parent_id == 0)
    		{
    			$tierStack[$category->id] = 0;
    		}
    		else
    		{
    			$tierStack[$category->id] = $tierStack[$category->parent_id] + 1;
    		}
    		array_slice($categoryStack, $i, 1);
    	}
    	return $tierStack;
    }

    public function sort($categoryStack)
    {
    	for ($i = 0; $i < count($categoryStack); $i++) {
    		for ($j = $i + 1; $j < count($categoryStack); $j++) {
    			if($categoryStack[$i]->id == $categoryStack[$j]->parent_id
    				&& $i + 1 != $j)
    			{
    				$category = $categoryStack[$j];
    				array_splice($categoryStack, $j, 1);
    				array_splice($categoryStack, $i + 1, 0, [$i => $category]);
    			}
    		}
    	}
    	return $categoryStack;
    }

    public function print($categoriesByParent)
    {
    	$string = "";
    	$categoriesByParent = $categoriesByParent->all();

    	$tierStack = $this->buildTierStack($categoriesByParent);
    	$categoriesByParent = $this->sort($categoriesByParent);

    	foreach($categoriesByParent as $category)
    	{
    		$string = $string .
    					str_repeat('&nbsp', $tierStack[$category->id]) .
    					$category->name .
    					'<br/>';
    	}
    	return $string;
    }
}
