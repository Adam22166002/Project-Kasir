document.addEventListener("DOMContentLoaded", function () {
    const cart = {
        items: [],
        total: 0,

        addItem(productId, name, price, quantity) {
            // Cek apakah produk sudah ada di keranjang
            const existingItem = this.items.find(
                (item) => item.productId === productId
            );

            if (existingItem) {
                existingItem.quantity += quantity;
                existingItem.subtotal = existingItem.quantity * price;
            } else {
                this.items.push({
                    productId,
                    name,
                    price,
                    quantity,
                    subtotal: quantity * price,
                });
            }

            this.updateCart();
        },

        removeItem(productId) {
            this.items = this.items.filter(
                (item) => item.productId !== productId
            );
            this.updateCart();
        },

        updateCart() {
            // Hitung total
            this.total = this.items.reduce(
                (sum, item) => sum + item.subtotal,
                0
            );

            // Update tampilan keranjang
            const cartElement = document.getElementById("cart");
            const totalElement = document.getElementById("total-harga");

            cartElement.innerHTML = this.items
                .map(
                    (item) => `
                <div class="cart-item">
                    ${item.name} - ${
                        item.quantity
                    } x Rp. ${item.price.toLocaleString()} 
                    = Rp. ${item.subtotal.toLocaleString()}
                    <button class="btn btn-sm btn-danger remove-item" data-id="${
                        item.productId
                    }">Hapus</button>
                </div>
            `
                )
                .join("");

            totalElement.textContent = this.total.toLocaleString();

            // Tambah event listener untuk tombol hapus
            document.querySelectorAll(".remove-item").forEach((button) => {
                button.addEventListener("click", (e) => {
                    const productId = e.target.dataset.id;
                    this.removeItem(parseInt(productId));
                });
            });
        },

        checkout() {
            // Kirim data transaksi ke backend
            fetch("/transaksi", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({
                    items: this.items,
                    total: this.total,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert("Transaksi berhasil!");
                        this.reset();
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Transaksi gagal");
                });
        },

        reset() {
            this.items = [];
            this.total = 0;
            this.updateCart();
        },
    };

    // Event listener untuk tombol tambah produk
    document.querySelectorAll(".add-to-cart").forEach((button) => {
        button.addEventListener("click", (e) => {
            const card = e.target.closest(".card");
            const productId = parseInt(e.target.dataset.id);
            const name = card.querySelector(".card-title").textContent;
            const price = parseFloat(
                card
                    .querySelector(".card-body p")
                    .textContent.replace("Rp. ", "")
                    .replace(".", "")
            );
            const quantity = parseInt(card.querySelector("input").value);

            if (quantity > 0) {
                cart.addItem(productId, name, price, quantity);
            }
        });
    });

    // Event listener untuk tombol selesai transaksi
    document
        .getElementById("selesai-transaksi")
        .addEventListener("click", () => {
            cart.checkout();
        });

    // Event listener untuk tombol reset
    document.getElementById("reset-transaksi").addEventListener("click", () => {
        cart.reset();
    });
});
