<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::all();
        return response()->json([
            'Categories'=>$categories

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category=Category::create([
            'name'=>$request->name
        ]);
        return response()->json([
            'message'=>'Category Created Successfully',
            'category'=>$category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $decuments=$category->documents()->get(['name','image']);
        return response()->json([
            'category'=>$category,
            'decuments'=>$decuments]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->update([
            'name'=>$request->name
        ]);
        return response()->json([
            'message'=>'Category Updated Successfully',
            'category'=>$category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message'=>'Category Deleted Successfully'
        ]);
    }
}
