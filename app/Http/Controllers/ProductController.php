<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::with('category')->get();
        return response()->json([
            'message' => 'fetch product success',
            'data' => $product
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
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required|exists:categories,id'  // Pastikan category_id ada di tabel categories
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'validation error',
                'data' => $validate->errors()
            ], 403);
        }

        $product = Product::create($request->all());
        return response()->json([
            'message' => 'Product Created',
            'data' => $product
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (is_null($product)) {
            return response()->json([
                'message' => 'no product found',
            ]);
        } else {
            return response()->json([
                'message' => 'weh',
                'data' => [
                    'product' => $product
                ]
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'data' => $validate->errors()
            ], 403);
        }

        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'no products found'
            ]);
        }

        $product->update($request->all());
        if ($product->save()) {
            return response()->json([
                'message' => 'success update data',
                'data' => $product
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json([
                'message' => 'no product found',
            ]);
        }

        Product::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'product deleted succesfully'
        ], 200);
    }
}
