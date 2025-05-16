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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
                        $table->string('name')->unique(); // admin, petugas lapangan, masyarakat
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
    $table->foreignId('role_id')
        ->constrained('roles')
        ->onDelete('cascade'); // atau cascade jika ingin menghapus user saat role dihapus
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
               Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('role_id');
        });

        Schema::dropIfExists('roles');
    }
};
