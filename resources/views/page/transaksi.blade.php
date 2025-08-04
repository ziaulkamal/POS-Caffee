@extends('welcome')

@section('content')
<div class="page-content-wrapper">
    <div class="py-3 container">
        <h5 class="mb-3">{{ $title }}</h5>

        @forelse($transaksiList as $trx)
        <div class="card mb-2 p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-3">

                    <strong>{{ $trx->nama_pelanggan ?? 'Tanpa Nama' }}</strong>
                    <div class="text-muted small">#{{ $trx->kode_trx }} <span class="badge {{ $trx->status === 'belum_bayar' ? 'bg-warning text-dark' : 'bg-success' }}">
                        {{ ucfirst(str_replace('_', ' ', $trx->status)) }}
                        @if ($trx->status !== 'belum_bayar')
                            - [{{ strtoupper($trx->metode_bayar) }}]

                        @endif

                    </span>
                    </span></div>
                </div>
                <div class="me-3 text-end">
                    <div>Total: <strong>Rp{{ number_format($trx->total_bayar, 0, ',', '.') }}</strong></div>

                </div>
                <div class="d-flex gap-2 mt-2 mt-sm-0">
                    @if($trx->status === 'belum_bayar')
                        <a href="{{ route('billing.edit', $trx->kode_trx) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <button type="button" class="btn btn-sm btn-primary btn-bayar" data-kode="{{ $trx->kode_trx }}">
                            Bayar
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">Belum ada transaksi.</p>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-bayar').forEach(function(button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const kodeTrx = this.dataset.kode;

            Swal.fire({
                title: 'Pilih Metode Pembayaran',
                input: 'select',
                inputOptions: {
                    'tunai': 'Tunai',
                    'qris': 'QRIS',
                    'bon': 'Bon'
                },
                inputPlaceholder: 'Pilih metode',
                showCancelButton: true,
                confirmButtonText: 'Bayar Sekarang',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value) {
                            resolve();
                        } else {
                            resolve('Pilih salah satu metode pembayaran');
                        }
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('billing.bayar', ':kode') }}`.replace(':kode', kodeTrx);

                    const csrf = document.querySelector('meta[name="csrf-token"]').content;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="${csrf}">
                        <input type="hidden" name="metode_bayar" value="${result.value}">
                    `;

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

