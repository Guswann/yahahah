<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return response()->json([
            'data' => $category,
            'message' => 'Success fetch data'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'validation error',
                'data' => $validate->errors(),
            ], 403);
        }

        $category = Category::create($request->all());
        return response()->json([
            'message' => 'store data success',
            'data' => $category
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json([
            'data' => $category
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'validation error',
                'data' => $validate->errors()
            ], 403);
        }

        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'no categories found'
            ]);
        }

        $category->update($request->all());
        if ($category->save()) {
            return response()->json([
                'message' => 'success update data',
                'data' => $category
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category not found',
            ], 200);
        }

        Category::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'category deleted succesfully'
        ], 200);
    }
}
