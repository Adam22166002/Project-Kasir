<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Schema::create('modals', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('description');
        //     $table->decimal('amount', 15, 2);
        //     $table->enum('type', ['in', 'out']); // 'in' = setoran, 'out' = pengambilan
        //     $table->date('modal_date');
        //     $table->timestamps();
        // });
        Schema::create('modals', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 12, 2);
            $table->enum('type', ['in', 'out'])->default('in');
            $table->string('description', 255)->nullable();
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('modals');
    }
};
