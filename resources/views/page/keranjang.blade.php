@extends('welcome')
<style>
   .nama-item-prod {
        font-weight: bold; /* Membuat teks tebal */
        margin-left: -10px; /* Menggeser teks ke kiri (sesuaikan nilai sesuai kebutuhan) */
    }
</style>
@section('content')
<div class="page-content-wrapper">
    <div class="container">
        <div class="cart-wrapper-area py-3">
            <div class="cart-table card mb-3">
                <div class="table-responsive card-body">

                    <!-- Tempat untuk [Menu] -->
                    <div id="menu-section" class="mb-4" style="display: none;">
                        <h5 class="mb-3">Pesanan Minuman</h5>
                        <table class="table mb-4" id="menu-table"></table>
                    </div>

                    <!-- Tempat untuk [Mitra] -->
                    <div id="mitra-section" style="display: none;">
                        <h5 class="mb-3">Pesanan Makanan</h5>
                        <table class="table mb-0" id="mitra-table"></table>
                    </div>

                </div>
            </div>
            <div class="card coupon-card mb-3">
                <div class="card-body">
                    <div class="apply-coupon">
                        <div class="coupon-form d-flex flex-column flex-sm-row align-items-start gap-2">
                            <input class="form-control" type="text" name="billing" id="billing-input" placeholder="Meja / Nama" required>
                            <div>
                            <button class="btn btn-primary" type="button" id="apply-billing">Terapkan</button>
                            <button class="btn btn-secondary d-none" type="button" id="edit-billing">Ganti</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card cart-amount-area">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h5 class="total-price mb-0">Rp<span id="total-price">0</span></h5>
                    <a class="btn btn-primary" href="#" id="checkout-btn">Proses</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('scripts')
<script>
    $(document).ready(function () {
        const transactionId = localStorage.getItem('transaction_id');
        const transactions = JSON.parse(localStorage.getItem('transactions')) || {};
        const current = transactions[transactionId] || {};
        const menuTable = $('#menu-table');
        const mitraTable = $('#mitra-table');
        let totalHarga = 0;

        function formatRupiah(angka) {
            return angka.toLocaleString('id-ID');
        }

        function generateBadge(kategori) {
            const badgeClass = kategori === 'panas' ? 'badge-danger' : 'badge-primary';
            return `<span class="badge ${badgeClass} px-1">${kategori}</span>`;
        }

        function updateCartDisplay() {
            totalHarga = 0;
            menuTable.empty();
            mitraTable.empty();
            $('#menu-section, #mitra-section').hide();

            if (current.menu) renderRows(current.menu, menuTable, 'menu');
            if (current.mitra) renderRows(current.mitra, mitraTable, 'mitra');

            $('#total-price').text(formatRupiah(totalHarga));
        }

        function renderRows(items, targetTable, type) {
            let hasData = false;

            Object.entries(items)
                .sort((a, b) => {
                    const kategoriA = a[1].kategori || '';
                    const kategoriB = b[1].kategori || '';
                    return kategoriA.localeCompare(kategoriB);
                })
                .forEach(([id, item]) => {
                    hasData = true;
                    const subtotal = item.harga * item.jumlah;
                    totalHarga += subtotal;

                    targetTable.append(`
                        <tr>
                            <td>
                                <div class="nama-item-prod">
                                    ${item.nama} ${item.kategori ? generateBadge(item.kategori) : ''}
                                </div>
                                Rp${formatRupiah(item.harga)} x ${item.jumlah}
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm text-center qty-input"
                                       value="${item.jumlah}" min="1" max="99"
                                       data-id="${id}" data-type="${type}">
                            </td>
                            <td>
                                <a href="#" class="text-danger remove-item" data-id="${id}" data-type="${type}">
                                    <i class="ti ti-x"></i>
                                </a>
                            </td>
                        </tr>
                    `);
                });

            if (hasData) {
                $(`#${type}-section`).show();
            }
        }

        updateCartDisplay();

        $(document).on('change', '.qty-input', function () {
            const id = $(this).data('id');
            const type = $(this).data('type');
            const qty = parseInt($(this).val());

            if (qty < 1) return;

            current[type][id].jumlah = qty;
            transactions[transactionId] = current;
            localStorage.setItem('transactions', JSON.stringify(transactions));
            updateCartDisplay();
        });

        $(document).on('click', '.remove-item', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            const type = $(this).data('type');

            delete current[type][id];

            if (Object.keys(current[type]).length === 0) {
                delete current[type];
            }

            transactions[transactionId] = current;
            localStorage.setItem('transactions', JSON.stringify(transactions));
            updateCartDisplay();
        });

        // Billing logic
        const billingInput = $('#billing-input');
        const billingApplyBtn = $('#apply-billing');
        const billingEditBtn = $('#edit-billing');

        if (current.billing) {
            billingInput.val(current.billing).prop('readonly', true);
            billingApplyBtn.hide();
            billingEditBtn.removeClass('d-none');
        }

        billingApplyBtn.on('click', function () {
            const billingName = billingInput.val().trim();
            if (billingName !== '') {
                current.billing = billingName;
                transactions[transactionId] = current;
                localStorage.setItem('transactions', JSON.stringify(transactions));

                billingInput.prop('readonly', true);
                billingApplyBtn.hide();
                billingEditBtn.removeClass('d-none');
            }
        });

        billingEditBtn.on('click', function () {
            billingInput.prop('readonly', false).focus();
            billingApplyBtn.show();
            billingEditBtn.addClass('d-none');
        });

        // Checkout button with validation and payload filtering
        $('#checkout-btn').on('click', function (e) {
            e.preventDefault();

            if (!current.billing || current.billing.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nama/Meja Kosong',
                    text: 'Silakan masukkan nama atau meja terlebih dahulu.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const menuItems = current.menu ? Object.keys(current.menu).length : 0;
            const mitraItems = current.mitra ? Object.keys(current.mitra).length : 0;

            if (menuItems === 0 && mitraItems === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Keranjang Kosong',
                    text: 'Silakan tambahkan item terlebih dahulu.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Checkout',
                text: `Pastikan data sudah benar atas nama: ${current.billing}. Lanjut checkout?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Checkout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (!result.isConfirmed) return;

                const payload = [];
                let isValid = true;

                ['menu', 'mitra'].forEach(type => {
                    if (current[type]) {
                        Object.entries(current[type]).forEach(([produkId, item]) => {
                            const harga = parseFloat(item.harga);
                            const jumlah = parseInt(item.jumlah);

                            if (!harga || harga <= 0 || !jumlah || jumlah <= 0) {
                                Swal.fire({
                                    title: 'Data Tidak Valid',
                                    text: `Produk "${item.nama}" memiliki harga atau jumlah tidak valid.`,
                                    icon: 'warning',
                                });
                                isValid = false;
                                return;
                            }

                            payload.push({
                                kode_trx: transactionId,
                                type: type,
                                produk_id: produkId,
                                harga: harga,
                                kuantitas: jumlah
                            });
                        });
                    }
                });

                if (!isValid) return;

                const namaPelanggan = current.billing;

                $.ajax({
                    url: '{{ route("checkout.proses") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        nama_pelanggan: namaPelanggan,
                        data: payload
                    },
                    success: function (response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Checkout berhasil disimpan!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            localStorage.removeItem('transactions');
                            localStorage.removeItem('transaction_id');
                            window.location.href = '{{ route("katalog") }}';
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: 'Gagal',
                            text: 'Gagal menyimpan transaksi. Silakan coba lagi.',
                            icon: 'error'
                        });
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    });
</script>
@endsection


