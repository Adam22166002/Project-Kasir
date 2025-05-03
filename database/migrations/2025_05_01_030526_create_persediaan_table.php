<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('persediaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // ID produk yang terkait
            $table->integer('quantity'); // Jumlah persediaan
            $table->decimal('cost_price', 15, 2); // Harga pokok persediaan
            $table->decimal('selling_price', 15, 2); // Harga jual persediaan
            $table->date('date')->default(DB::raw('CURRENT_DATE')); // Tanggal transaksi
            $table->timestamps();

            // Foreign key untuk relasi ke tabel produk
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persediaan');
    }
};
