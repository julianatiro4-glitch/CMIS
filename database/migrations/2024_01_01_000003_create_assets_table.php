<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag')->unique(); // internal inventory code, e.g. CMP-0001
            $table->string('name'); // e.g. "Dell OptiPlex 7090"
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable()->unique();
            $table->enum('status', ['available', 'in_use', 'in_repair', 'retired', 'lost'])
                ->default('available');
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 12, 2)->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->text('specifications')->nullable(); // CPU/RAM/Storage/etc free text or JSON
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status']);
            $table->index(['category_id', 'location_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
