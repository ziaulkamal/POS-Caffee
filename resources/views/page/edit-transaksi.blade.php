@extends('welcome')

@section('content')
<div class="page-content-wrapper">
    <div class="container">
        <div class="alert alert-info mt-3">
            Memuat ulang transaksi untuk <strong>#{{ $kode_trx }}</strong>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('katalog') }}" class="btn btn-primary">Kembali ke Keranjang</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const restoredData = {!! $data_json !!};
        const transactionId = '{{ $kode_trx }}';

        // Perbaikan jika 'mitra' atau 'menu' kebetulan dalam bentuk array (bukan object)
        const data = restoredData[transactionId];

        ['menu', 'mitra'].forEach(type => {
            if (Array.isArray(data[type])) {
                const fixed = {};
                data[type].forEach((item, index) => {
                    if (item && item.nama) {
                        fixed[index] = item;
                    }
                });
                data[type] = fixed;
            }
        });

        // Simpan kembali ke localStorage
        localStorage.setItem('transaction_id', transactionId);
        localStorage.setItem('transactions', JSON.stringify({ [transactionId]: data }));

        // Redirect ke katalog
        window.location.href = "{{ route('katalog') }}";
    });
</script>
@endsection
