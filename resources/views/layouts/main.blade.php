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
    <title>App Kasir</title>
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
  <body>
            <!-- Konten Utama -->
            <div class="col-md-12">
                @yield('content')
            </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
                window.completeSetupWithConfirmation = function() {
                    Swal.fire({
                        title: 'Selesai Setup?',
                        text: "Anda akan menyelesaikan setup dan masuk ke aplikasi kasir utama.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Selesai',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            finishSetup();
                        }
                    });
                };
                //finish setup
                window.finishSetup = function() {

                    document.getElementById('kasir-setup').style.display = 'none';

                    document.getElementById('kasir-active').style.display = 'block';

                    fetch('{{ route("kasir.complete-setup") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Setup Berhasil!',
                                text: 'Aplikasi kasir siap digunakan.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: data.message || 'Gagal menyelesaikan setup.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menyelesaikan setup. Silakan coba lagi.'
                        });
                    });
                };
                //setup completed
                window.showSetupWithConfirmation = function() {
                    Swal.fire({
                        title: 'Kembali ke Setup?',
                        text: "Anda akan kembali ke pengaturan kasir.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Kembali',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('step2') }}";
                        }
                    });
                };
              
                // Function to confirm reset kasir
                window.confirmResetKasir = function() {
                    Swal.fire({
                        title: 'Reset Aplikasi Kasir?',
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
                            var form = document.getElementById('resetKasirForm');
                            if (form) {
                                form.submit();
                            } else {
                                console.error("Form reset tidak ditemukan!");
                            }
                        }
                    });
                };
                // Mengisi form edit saat modal dibuka
                document.querySelectorAll('.edit-product').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.dataset.id;
                        const name = this.dataset.name;
                        const price = this.dataset.price;
                        const stock = this.dataset.stock;
                        const image = this.dataset.image_path;
                        
                        document.getElementById('edit_name').value = name;
                        document.getElementById('edit_price').value = price;
                        document.getElementById('edit_stock').value = stock;
                        if (image) {
                            document.getElementById('edit_image_preview').src = `/storage/${image}`;
                        } else {
                            document.getElementById('edit_image_preview').src = 'https://via.placeholder.com/150';
                        }

                        document.getElementById('editProdukForm').action = `/produk/${id}`;
                    });
                });
                
                // Konfirmasi hapus produk
                // document.querySelectorAll('.delete-product').forEach(button => {
                //     button.addEventListener('click', function() {
                //         const id = this.dataset.id;
                //         const name = this.dataset.name;
                        
                //         if (confirm(`Apakah Anda yakin ingin menghapus produk "${name}"?`)) {
                //             // Buat form submit hapus
                //             const form = document.createElement('form');
                //             form.method = 'POST';
                //             form.action = `/produk/${id}`;
                            
                //             const methodInput = document.createElement('input');
                //             methodInput.type = 'hidden';
                //             methodInput.name = '_method';
                //             methodInput.value = 'DELETE';
                            
                //             const csrfInput = document.createElement('input');
                //             csrfInput.type = 'hidden';
                //             csrfInput.name = '_token';
                //             csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                            
                //             form.appendChild(methodInput);
                //             form.appendChild(csrfInput);
                //             document.body.appendChild(form);
                //             form.submit();
                //         }
                //     });
                // });

            // Event listeners for deleting product in setup
            document.querySelectorAll('.delete-product').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    
                    Swal.fire({
                        title: 'Hapus Produk?',
                        text: `Apakah Anda yakin ingin menghapus produk "${name}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create delete form
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/produk/${id}`;
                            
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                            
                            form.appendChild(methodInput);
                            form.appendChild(csrfInput);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Handle price form submissions with improved UX
            document.querySelectorAll('.price-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const url = this.getAttribute('action');
                    const productId = url.split('/').pop();
                    const statusBadge = document.querySelector(`.price-status-${productId}`);
                    
                    // Update status to indicate saving
                    if (statusBadge) {
                        statusBadge.className = `price-status-${productId} badge bg-info`;
                        statusBadge.textContent = 'Menyimpan...';
                    }
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update status badge
                            if (statusBadge) {
                                statusBadge.className = `price-status-${productId} badge bg-success`;
                                statusBadge.textContent = 'Tersimpan';
                                
                                // Reset badge after 3 seconds
                                setTimeout(() => {
                                    statusBadge.className = `price-status-${productId} badge bg-success`;
                                    statusBadge.textContent = 'Harga Tersimpan';
                                }, 3000);
                            }
                        } else {
                            // Show error
                            if (statusBadge) {
                                statusBadge.className = `price-status-${productId} badge bg-danger`;
                                statusBadge.textContent = 'Gagal simpan';
                            }
                            
                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Simpan Harga',
                                text: data.message || 'Terjadi kesalahan saat menyimpan harga.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        // Update status badge to show error
                        if (statusBadge) {
                            statusBadge.className = `price-status-${productId} badge bg-danger`;
                            statusBadge.textContent = 'Gagal simpan';
                        }
                        
                        // Show error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Simpan Harga',
                            text: 'Terjadi kesalahan saat menyimpan. Silakan coba lagi.'
                        });
                    });
                });
            });

            // Handle stock form submissions with improved UX
            document.querySelectorAll('.stock-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const url = this.getAttribute('action');
                    const productId = url.split('/').pop();
                    const statusBadge = document.querySelector(`.stock-status-${productId}`);
                    
                    // Update status to indicate saving
                    if (statusBadge) {
                        statusBadge.className = `stock-status-${productId} badge bg-info`;
                        statusBadge.textContent = 'Menyimpan...';
                    }
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update status badge
                            if (statusBadge) {
                                statusBadge.className = `stock-status-${productId} badge bg-success`;
                                statusBadge.textContent = 'Tersimpan';
                                
                                // Reset badge after 3 seconds
                                setTimeout(() => {
                                    statusBadge.className = `stock-status-${productId} badge bg-success`;
                                    statusBadge.textContent = 'Stok Tersimpan';
                                }, 3000);
                            }
                        } else {
                            // Show error
                            if (statusBadge) {
                                statusBadge.className = `stock-status-${productId} badge bg-danger`;
                                statusBadge.textContent = 'Gagal simpan';
                            }
                            
                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Simpan Stok',
                                text: data.message || 'Terjadi kesalahan saat menyimpan stok.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        // Update status badge to show error
                        if (statusBadge) {
                            statusBadge.className = `stock-status-${productId} badge bg-danger`;
                            statusBadge.textContent = 'Gagal simpan';
                        }
                        
                        // Show error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Simpan Stok',
                            text: 'Terjadi kesalahan saat menyimpan. Silakan coba lagi.'
                        });
                    });
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.edit-product').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.dataset.id;
                        const name = this.dataset.name;
                        const price = this.dataset.price;
                        const stock = this.dataset.stock;
                        
                        document.getElementById('edit_name').value = name;
                        document.getElementById('edit_price').value = price;
                        document.getElementById('edit_stock').value = stock;
                        
                        document.getElementById('editProdukForm').action = `/produk/${id}`;
                    });
                });
                
                // Konfirmasi hapus produk
                document.querySelectorAll('.delete-product').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.dataset.id;
                        const name = this.dataset.name;
                        
                        if (confirm(`Apakah Anda yakin ingin menghapus produk "${name}"?`)) {
                            // Buat form submit hapus
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/produk/${id}`;
                            
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                            
                            form.appendChild(methodInput);
                            form.appendChild(csrfInput);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Helper function to format numbers
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
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
  </body>
</html>
