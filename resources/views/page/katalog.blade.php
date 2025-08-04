@extends('welcome')
{{-- @dd($products) --}}
@section('content')
<div class="page-content-wrapper">
    <div class="top-products-area py-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
        <button id="start-transaction" class="btn btn-sm btn-success px-2 py-1 filter-btn">Bill Baru</button>

        @php
            $kategoriList = collect($products)->pluck('kategori')->unique();
        @endphp

        <div class="d-flex gap-1 flex-wrap">
            @foreach($kategoriList as $kategori)
                <a class="btn btn-sm btn-light px-2 py-1 filter-btn" href="#" data-filter="{{ $kategori }}">
                    {{ ucfirst($kategori) }}
                </a>
            @endforeach
            <a class="btn btn-sm btn-secondary px-2 py-1 filter-btn" href="#" data-filter="all">Semua</a>
        </div>
        </div>

        <div class="row g-2">

            @foreach($products as $product)
                <div class="col-6 col-md-4 mb-4 product-item"
                    data-id="{{ $product['id'] }}"
                    data-type="{{ $product['type'] }}"
                    data-kategori="{{ $product['kategori'] }}"
                    data-nama="{{ $product['nama'] }}"
                    data-harga="{{ $product['harga'] }}"
                    data-gambar="{{ $product['gambar'] ?? asset('img/product/5.png') }}"
                >
                    <div class="card product-card h-100">
                        <div class="card-body text-center">
                            <!-- Gambar Produk -->
                            <a class="product-thumbnail d-block mb-2" href="#">
                                <img src="{{ $product['gambar'] ?? asset('img/product/5.png') }}" alt="{{ $product['nama'] }}">
                            </a>

                            <!-- Nama Produk -->
                            <a class="product-title fw-bold d-block mb-1 text-dark" href="#">
                                {{ $product['nama'] }}
                            </a>

                            <!-- Harga -->
                            <p class="mb-1 text-dark">
                                Rp{{ number_format($product['harga'], 0, ',', '.') }}
                            </p>

                            <!-- Badge Kategori -->
                            <span class="badge
                                @if($product['kategori'] === 'dingin') bg-primary
                                @elseif($product['kategori'] === 'panas') bg-danger
                                @else bg-success
                                @endif">
                                {{ ucfirst($product['kategori']) }}
                            </span>

                            <!-- Tombol -->
                            <div class="mt-2">
                                <a class="btn btn-primary btn-sm tambah-btn"
                                    href="#"
                                    data-id="{{ $product['id'] }}"
                                    data-type="{{ $product['type'] }}"
                                    data-nama="{{ $product['nama'] }}"
                                    data-harga="{{ $product['harga'] }}"
                                    data-kategori="{{ $product['kategori'] }}"
                                    data-gambar="{{ $product['gambar'] ?? 'img/product/5.png' }}">
                                    <i class="ti ti-plus"></i>
                                </a>
                                <div class="mt-1 small text-muted jumlah-display" id="jumlah-{{ $product['id'] }}">
                                    <!-- jumlah akan ditampilkan di sini -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    // ====== Generate ID Transaksi (6 karakter alfanumerik) ======
    function generateTransactionId(length = 6) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        for (let i = 0; i < length; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    // ====== Filter kategori produk ======
$('.filter-btn').on('click', function (e) {
    e.preventDefault();
    const filter = $(this).data('filter');

    $('[data-kategori]').each(function () {
        const kategori = $(this).data('kategori');
        $(this).toggle(filter === 'all' || kategori === filter);
    });
});


    // ====== Klik tombol "Mulai Transaksi" ======
    $('#start-transaction').on('click', function () {
        let transactionId = localStorage.getItem('transaction_id');

        if (!transactionId) {
            transactionId = generateTransactionId();
            localStorage.setItem('transaction_id', transactionId);
            localStorage.setItem('transactions', JSON.stringify({ [transactionId]: { menu: {}, mitra: {} } }));

            $('#cart-icon').addClass('bg-danger text-white rounded px-2');
            $('.tambah-btn').show();
            window.location.reload();
        }

        $(this).text('#' + transactionId);
    });

    // ====== Klik tombol tambah produk ======
$('.tambah-btn').on('click', function (e) {
    e.preventDefault();

    const transactionId = localStorage.getItem('transaction_id');

    if (!transactionId) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: "Klik 'Mulai Transaksi' terlebih dahulu.",
            confirmButtonText: 'OK'
        });
        return;
    }

    // Ambil semua data dari tombol
    const id = $(this).data('id');
    const type = $(this).data('type'); // menu atau mitra
    const kategori = $(this).data('kategori');
    const nama = $(this).data('nama');
    const harga = parseInt($(this).data('harga'));
    const gambar = $(this).data('gambar');

    // Ambil transaksi dari localStorage
    let transactions = JSON.parse(localStorage.getItem('transactions')) || {};
    if (!transactions[transactionId]) {
        transactions[transactionId] = {};
    }
    if (!transactions[transactionId][type]) {
        transactions[transactionId][type] = {};
    }

    const currentType = transactions[transactionId][type];

    // Jika sudah ada, tambahkan jumlahnya
    if (currentType[id]) {
        currentType[id]['jumlah'] += 1;
    } else {
        currentType[id] = {
            nama: nama,
            harga: harga,
            kategori: kategori,
            gambar: gambar,
            jumlah: 1
        };
    }

    // Simpan kembali
    localStorage.setItem('transactions', JSON.stringify(transactions));

    // Tampilkan jumlah di UI
    $('#jumlah-' + id).text('Jumlah: ' + currentType[id].jumlah);
});
});

</script>
@endsection