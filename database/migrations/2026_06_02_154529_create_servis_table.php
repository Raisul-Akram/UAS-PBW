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
        Schema::create('servis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_servis')->unique();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            // teknisi_id can be null if not assigned yet
            $table->foreignId('teknisi_id')->nullable()->constrained('teknisis')->onDelete('set null');
            $table->string('nama_perangkat');
            $table->text('jenis_kerusakan');
            $table->string('status')->default('antri'); // antri, diproses, selesai, diambil
            $table->decimal('estimasi_biaya', 12, 2);
            $table->decimal('biaya_final', 12, 2)->nullable();
            $table->text('catatan_teknisi')->nullable();
            $table->timestamp('tgl_masuk')->useCurrent();
            $table->date('tgl_estimasi_selesai');
            $table->timestamp('tgl_selesai')->nullable();
            $table->softDeletes(); // soft delete support
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servis');
    }
};
