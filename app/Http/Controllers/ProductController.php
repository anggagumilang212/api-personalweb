<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();
        return ProductResource::collection($product)->additional(['message' => 'Data products successfully']);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'price' => 'required',
        ]);

        $product = Product::create($request->all());
        return (new ProductResource($product))->additional(['message' => 'Data created successfully']);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $project = Product::find($id);

        $project->update([
            'title' => $request->title,
            'price' => $request->price,

        ]);
        return (new ProductResource($project))->additional(['message' => 'Data updated successfully']);

    }
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return (new ProductResource($product))->additional(['message' => 'Data deleted successfully']);
    }
}
