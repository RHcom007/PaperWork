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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('project_id');
            $table->string('invoice_id');
            $table->string('user_id')->nullable();
            $table->string('nama_client');
            $table->string('alamat_detail');
            $table->date('start_date');
            $table->date('end_date');
            $table->json('invoices');
            $table->json('additional_informations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
