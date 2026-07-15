<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Get or create the main office location
        $locationId = DB::table('locations')
            ->where('name', 'QC PESO Main Office')
            ->value('id');

        if (! $locationId) {
            $locationId = DB::table('locations')->insertGetId([
                'name'       => 'QC PESO Main Office',
                'building'   => 'Quezon City Hall Compound',
                'notes'      => 'Main PESO Office, Quezon City',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $divisions = [
            ['code' => 'PED',   'name' => 'Placement and Employment Division'],
            ['code' => 'LMISD', 'name' => 'Labor Market Information and Statistics Division'],
            ['code' => 'ADMIN', 'name' => 'Administrative Division'],
            ['code' => 'SPD',   'name' => 'Special Programs Division'],
            ['code' => 'OPM',   'name' => 'Office of the Public Employment Manager'],
            ['code' => 'LRSD',  'name' => 'Labor Relations and Standards Division'],
            ['code' => 'DOC',   'name' => 'Documentation and Records'],
            ['code' => 'MSD',   'name' => 'Management and Support Division'],
        ];

        foreach ($divisions as $division) {
            $exists = DB::table('divisions')->where('code', $division['code'])->exists();
            if (! $exists) {
                DB::table('divisions')->insert([
                    'location_id' => $locationId,
                    'code'        => $division['code'],
                    'name'        => $division['name'],
                    'description' => null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('divisions')->whereIn('code', [
            'PED','LMISD','ADMIN','SPD','OPM','LRSD','DOC','MSD',
        ])->delete();
    }
};