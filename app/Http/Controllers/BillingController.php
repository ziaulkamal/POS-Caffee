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

    public function bayar(Request $request, $kode_trx)
    {
        $billing = Billing::where('kode_trx', $kode_trx)->firstOrFail();

        if ($billing->status === 'sudah_bayar') {
            return redirect()->back()->with('info', 'Transaksi sudah dibayar.');
        }

        $validated = $request->validate([
            'metode_bayar' => 'required|in:tunai,qris,bon',
        ]);

        $billing->update([
            'status' => 'sudah_bayar',
            'metode_bayar' => $validated['metode_bayar'],
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil disimpan.');
    }
}
