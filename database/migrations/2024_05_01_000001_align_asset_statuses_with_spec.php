<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('assets')) {
            return;
        }

        DB::table('assets')->where('status', 'in_repair')->update(['status' => 'under_maintenance']);
        DB::table('assets')->where('status', 'retired')->update(['status' => 'for_replacement']);
        DB::table('assets')->where('status', 'lost')->update(['status' => 'defective']);
    }

    public function down(): void
    {
        if (! Schema::hasTable('assets')) {
            return;
        }

        DB::table('assets')->where('status', 'under_maintenance')->update(['status' => 'in_repair']);
        DB::table('assets')->where('status', 'for_replacement')->update(['status' => 'retired']);
        DB::table('assets')->where('status', 'defective')->update(['status' => 'lost']);
    }
};
