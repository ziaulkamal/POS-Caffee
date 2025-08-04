<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\KatalogMenu;
use App\Models\MitraProduct;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PageController extends Controller
{
    function katalog()
    {
        $menus = KatalogMenu::select('id', 'nama_menu as nama', 'harga', 'kategori')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => 'menu',
                    'nama' => $item->nama,
                    'harga' => $item->harga,
                    'gambar' => $item->gambar,
                    'kategori' => $item->kategori,
                ];
            });

        $makanan = MitraProduct::where('kategori', 'makanan')
            ->select('id', 'nama_produk as nama', 'harga')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => 'mitra',
                    'nama' => $item->nama,
                    'gambar' => $item->gambar, // Assuming a default image if not set
                    'harga' => $item->harga,
                    'kategori' => 'makanan',
                ];
            });
        $data = [
            'title' => 'Katalog',
            'products' => $menus->merge($makanan)->values()->all(),
        ];

        return view('page.katalog', $data);
    }

    function keranjang() {
        $data = [
            'title' => 'Keranjang',
            // 'data'       => 'page.katalog',
        ];

        return view('page.keranjang', $data);
    }

    public function transaksi()
    {
        $billingList = Billing::orderByRaw("
            CASE status
                WHEN 'belum_bayar' THEN 0
                WHEN 'sudah_bayar' THEN 1
                ELSE 2
            END
        ")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('page.transaksi', [
            'title' => 'Daftar Transaksi',
            'transaksiList' => $billingList
        ]);
    }

    public function edit($kode_trx)
    {
        $billing = Billing::where('kode_trx', $kode_trx)->firstOrFail();
        $transaksiItems = Transaksi::where('kode_trx', $kode_trx)->get();

        $rebuild = [
            'billing' => $billing->nama_pelanggan,
            'menu'    => [],
            'mitra'   => [],
        ];

        foreach ($transaksiItems as $item) {
            $produk = null;
            $nama   = 'Produk';

            if ($item->type === 'menu') {
                $produk = KatalogMenu::find($item->produk_id);
                if ($produk) {
                    $nama = $produk->nama_menu;
                }
            } elseif ($item->type === 'mitra') {
                $produk = MitraProduct::find($item->produk_id);
                if ($produk) {
                    $nama = $produk->nama_produk;
                }
            }

            if ($produk && $item->produk_id) {
                $rebuild[$item->type][(string) $item->produk_id] = [
                    'nama'     => $nama,
                    'harga'    => $item->harga,
                    'jumlah'   => $item->kuantitas,
                    'kategori' => $produk->kategori ?? null,
                    'gambar'   => $produk->gambar ?? null,
                ];
            }
        }

        $jsonData = json_encode([$kode_trx => $rebuild]);

        return view('page.edit-transaksi', [
            'title'     => 'Edit Transaksi #' . $kode_trx,
            'kode_trx'  => $kode_trx,
            'data_json' => $jsonData,
        ]);
    }

    public function bayar(Request $request, $kode_trx)
    {
        $billing = Billing::where('kode_trx', $kode_trx)->firstOrFail();

        if ($billing->status === 'sudah_bayar') {
            return redirect()->back()->with('info', 'Transaksi sudah lunas.');
        }

        $request->validate([
            'metode_bayar' => 'required|in:tunai,qris,bon'
        ]);

        $billing->update([
            'status' => 'sudah_bayar',
            'metode_bayar' => $request->metode_bayar
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil disimpan.');
    }
}
