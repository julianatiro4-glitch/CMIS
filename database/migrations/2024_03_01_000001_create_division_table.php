<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable(); // e.g. HR, FIN, IT, ADMIN
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('location_id');
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->foreignId('division_id')
                ->nullable()
                ->after('location_id')
                ->constrained('divisions')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropColumn('division_id');
        });

        Schema::dropIfExists('divisions');
    }
};