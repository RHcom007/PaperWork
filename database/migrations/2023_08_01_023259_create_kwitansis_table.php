<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kwitansis', function (Blueprint $table) {
            $table->id();
            $table->string('project_id');
            $table->string('kwitansi_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('nama_pemberi');
            $table->bigInteger('nominal');
            $table->string('pembayaran');
            $table->json('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kwitansis');
    }
};
