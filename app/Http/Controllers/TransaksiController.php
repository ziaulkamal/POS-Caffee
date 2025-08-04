<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return response()->json(Transaksi::all());
    }

    public function store(Request $request)
    {
        $items = $request->input('data');

        if (!$items || count($items) === 0) {
            return response()->json(['message' => 'Data kosong.'], 400);
        }

        $kodeTrx = $items[0]['kode_trx'];
        $totalBayar = 0;

        foreach ($items as $item) {
            Transaksi::create([
                'kode_trx'  => $item['kode_trx'],
                'type'      => $item['type'],
                'produk_id' => $item['produk_id'],
                'harga'     => $item['harga'],
                'kuantitas' => $item['kuantitas'],
            ]);

            $totalBayar += $item['harga'] * $item['kuantitas'];
        }

        // Simpan ke billing
        Billing::updateOrCreate(
            ['kode_trx' => $kodeTrx],
            [
                'nama_pelanggan' => $request->input('nama_pelanggan'),
                'total_bayar'    => $totalBayar,
                'status'         => 'belum_bayar',
                'metode_bayar'   => 'tunai', // default
            ]
        );

        return response()->json(['message' => 'Transaksi dan billing disimpan.']);
    }

    public function show($id)
    {
        return response()->json(Transaksi::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $trx = Transaksi::findOrFail($id);
        $trx->update($request->all());
        return response()->json($trx);
    }

    public function destroy($id)
    {
        Transaksi::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
