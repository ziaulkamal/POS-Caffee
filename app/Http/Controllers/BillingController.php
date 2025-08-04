<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        return response()->json(Billing::all());
    }

    public function store(Request $request)
    {
        $billing = Billing::create($request->all());
        return response()->json($billing, 201);
    }

    public function show($id)
    {
        return response()->json(Billing::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $billing = Billing::findOrFail($id);
        $billing->update($request->all());
        return response()->json($billing);
    }

    public function destroy($id)
    {
        Billing::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }


}
