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
    Schema::create('pengeluaran', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('modal_id')->nullable(); // relasi ke modal
        $table->decimal('amount', 12, 2);
        $table->string('description')->nullable();
        $table->date('date')->default(DB::raw('CURRENT_DATE'));
        $table->timestamps();

        // Foreign key
        $table->foreign('modal_id')->references('id')->on('modals')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
