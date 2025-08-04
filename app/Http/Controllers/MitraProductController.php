<?php

namespace App\Http\Controllers;

use App\Models\MitraProduct;
use Illuminate\Http\Request;

class MitraProductController extends Controller
{
    public function index()
    {
        return response()->json(MitraProduct::all());
    }

    public function store(Request $request)
    {
        $product = MitraProduct::create($request->all());
        return response()->json($product, 201);
    }

    public function show($id)
    {
        return response()->json(MitraProduct::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $product = MitraProduct::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        MitraProduct::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
