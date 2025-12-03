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
        Schema::create('customer_expressions', function (Blueprint $table) {
            $table->id();

            // Ekspresi yang terdeteksi dari pelanggan
            $table->string('emotion', 50);

            // Tingkat keyakinan dari model deteksi (opsional)
            $table->decimal('confidence', 5, 2)->nullable();

            // Waktu ketika ekspresi terdeteksi
            $table->timestamp('detected_at')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_expressions');
    }
};

