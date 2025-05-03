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
        Schema::create('kas', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2); // Jumlah uang kas
            $table->enum('type', ['in', 'out']); // Jenis kas (masuk/keluar)
            $table->string('description')->nullable(); // Deskripsi transaksi
            $table->date('date')->default(DB::raw('CURRENT_DATE')); // Tanggal transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};
