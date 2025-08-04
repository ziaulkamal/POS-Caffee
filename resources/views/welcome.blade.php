<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#625AFA">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags -->
    <!-- Title -->
    <title>Lampoh Kupi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="img/icons/icon-72x72.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/tabler-icons.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="style.css">

  </head>
  <body>
    @include('components.header')
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @yield('content')
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Footer Nav-->
    @include('components.menu')
    <!-- All JavaScript Files-->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.passwordstrength.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/theme-switching.js"></script>
    <script src="js/no-internet.js"></script>
    <script src="js/active.js"></script>
    <script src="js/pwa.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
    <script>
        $(document).ready(function () {
            const transactionId = localStorage.getItem('transaction_id');
            if (transactionId) {
            $('#start-transaction').text('#' + transactionId);
            $('#cart-icon').addClass('bg-danger text-white rounded px-2');
                $('.tambah-btn').show();
            } else {
                $('.tambah-btn').hide();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartLink = document.getElementById('cart-icon');

            cartLink.addEventListener('click', function (e) {
            const transaksi = localStorage.getItem('transactions');
            const transaksiId = localStorage.getItem('transaction_id');

            if (!transaksi || !transaksiId) {
                e.preventDefault(); // Cegah redirect
                Swal.fire({
                icon: 'info',
                title: 'Keranjang Kosong',
                text: 'Buat "Bill Baru" di "Menu Katalog" untuk memulai.',
                });
            }
            });
        });
    </script>
    <script>
  document.addEventListener('DOMContentLoaded', function () {
    const resetMenu = document.getElementById('reset-keranjang');
    const btnReset = document.getElementById('btn-reset-keranjang');

    const transaksi = localStorage.getItem('transactions');
    const transaksiId = localStorage.getItem('transaction_id');

    // Tampilkan tombol jika ada data
    if (transaksi && transaksiId) {
      resetMenu.style.display = 'block';
    }

    // Aksi reset saat diklik
    btnReset.addEventListener('click', function (e) {
      e.preventDefault();

      Swal.fire({
        title: 'Reset Keranjang?',
        text: 'Semua item dalam keranjang akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, reset',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          localStorage.removeItem('transactions');
          localStorage.removeItem('transaction_id');
          Swal.fire({
            icon: 'success',
            title: 'Keranjang dikosongkan',
            showConfirmButton: false,
            timer: 1200
          }).then(() => {
            window.location.href = "{{ route('katalog') }}";
          });
        }
      });
    });
  });
</script>

  </body>
</html>