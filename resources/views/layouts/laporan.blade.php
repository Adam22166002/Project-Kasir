<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Laporan Kasir</title>
    <link
      href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css"
      rel="stylesheet"
    />
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <script
      data-search-pseudo-elements
      defer
      src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"
      crossorigin="anonymous"
    ></script>
    <style>
        .product-image {
                width: 100%;  
                height: 200px; 
                object-fit: cover;
            }

            .card-body {
                padding: 1rem; 
            }

            .card-title {
                font-size: 1.1rem;
                margin-bottom: 0.5rem; 
            }

            .card-text {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }

            .d-flex {
                margin-top: 0.75rem;
            }

    </style>
  </head>
  <body>
         <!-- Konten Utama -->
            <div class="col-md-12">
                @yield('content')
            </div>


    <script>
        document.getElementById('btn-reset-kasir').addEventListener('click', function() {
        Swal.fire({
            title: 'Reset Kasir?',
            text: "PERHATIAN! Semua data produk dan transaksi akan dihapus. Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Reset Semua Data!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika konfirmasi, submit form
                document.getElementById('reset-kasir-form').submit();
            }
        });
    });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Menambahkan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('scripts')
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="js/scripts.js"></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="../js/datatables/datatables-simple-demo.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"
      crossorigin="anonymous"
    ></script>
    <script src="../js/litepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>
