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
    public function up()
{
    Schema::create('pendapatan', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('transaksi_id')->nullable(); // FK
        $table->decimal('amount', 15, 2);
        $table->string('description')->nullable();
        $table->date('date')->nullable();
        $table->timestamps();
    
        // Perbaikan FK
        $table->foreign('transaksi_id')->references('id')->on('transactions')->onDelete('set null');
    });
    
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendapatan');
    }
};
