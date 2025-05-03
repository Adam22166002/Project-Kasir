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
    <title>Login Kasir</title>
    <link
      href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css"
      rel="stylesheet"
    />
    <link href="css/styles.css" rel="stylesheet" />
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
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                @yield('content')
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="footer-admin footer-dark">
                <div class="container-xl">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; Kasir System {{ date('Y') }}</div>
                        <div class="col-md-6 text-md-end small">
                            <a href="#!">Privacy Policy</a>
                            &middot;
                            <a href="#!">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
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
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="js/datatables/datatables-simple-demo.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"
      crossorigin="anonymous"
    ></script>
    <script src="js/litepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
