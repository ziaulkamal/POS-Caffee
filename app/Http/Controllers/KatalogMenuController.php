<?php

namespace App\Http\Controllers;

use App\Models\KatalogMenu;
use Illuminate\Http\Request;

class KatalogMenuController extends Controller
{
    public function index()
    {
        return response()->json(KatalogMenu::all());
    }

    public function store(Request $request)
    {
        $menu = KatalogMenu::create($request->all());
        return response()->json($menu, 201);
    }

    public function show($id)
    {
        return response()->json(KatalogMenu::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $menu = KatalogMenu::findOrFail($id);
        $menu->update($request->all());
        return response()->json($menu);
    }

    public function destroy($id)
    {
        KatalogMenu::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
