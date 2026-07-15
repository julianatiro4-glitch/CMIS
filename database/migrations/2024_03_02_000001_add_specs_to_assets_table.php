<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Hardware specs
            $table->string('cpu')->nullable()->after('specifications');
            $table->string('ram_total')->nullable()->after('cpu');
            $table->string('ram_used')->nullable()->after('ram_total');
            $table->string('storage_capacity')->nullable()->after('ram_used');
            $table->string('storage_device')->nullable()->after('storage_capacity');
            $table->string('operating_system')->nullable()->after('storage_device');

            // Identity & usage
            $table->string('hostname')->nullable()->after('operating_system');
            $table->string('utilized_by')->nullable()->after('hostname');
            $table->enum('ownership_type', ['office_owned', 'personally_owned'])
                ->default('office_owned')->after('utilized_by');

            // Connectivity
            $table->enum('connectivity', ['lan', 'wifi', 'both', 'none'])
                ->default('lan')->after('ownership_type');
            $table->string('wifi_network')->nullable()->after('connectivity');

            // Condition & software
            $table->enum('condition', ['good', 'fair', 'for_repair', 'unserviceable'])
                ->default('good')->after('wifi_network');
            $table->text('software_installed')->nullable()->after('condition');
            $table->boolean('has_crowdstrike')->default(false)->after('software_installed');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn([
                'cpu', 'ram_total', 'ram_used', 'storage_capacity',
                'storage_device', 'operating_system', 'hostname',
                'utilized_by', 'ownership_type', 'connectivity',
                'wifi_network', 'condition', 'software_installed',
                'has_crowdstrike',
            ]);
        });
    }
};
