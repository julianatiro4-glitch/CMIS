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
        Schema::dropIfExists('maintenance_records');

        Schema::create('technical_supports', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->string('division')->nullable();
            $table->string('reported_by')->nullable();
            $table->text('issue_problem');
            $table->text('action_taken')->nullable();
            $table->string('handled_by')->nullable();
            $table->enum('status', ['in_progress', 'for_checking', 'failed', 'done'])->default('in_progress');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_supports');

        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('technician')->nullable();
            $table->text('issue_description');
            $table->enum('status', ['open', 'in_progress', 'resolved'])->default('open');
            $table->decimal('cost', 12, 2)->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamp('opened_at');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['asset_id', 'status']);
        });
    }
};
