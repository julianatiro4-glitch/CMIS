<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $categories = [
            ['name' => 'Desktop Computer',  'slug' => 'desktop-computer',  'description' => 'Standard desktop PC units'],
            ['name' => 'Laptop',            'slug' => 'laptop',            'description' => 'Portable laptop computers'],
            ['name' => 'Virtual Machine',   'slug' => 'virtual-machine',   'description' => 'Virtualized computing environments (VMs)'],
            ['name' => 'Monitor',           'slug' => 'monitor',           'description' => 'Display monitors and screens'],
            ['name' => 'Printer',           'slug' => 'printer',           'description' => 'Printers and all-in-one units'],
            ['name' => 'Scanner',           'slug' => 'scanner',           'description' => 'Document scanners'],
            ['name' => 'Photocopier',       'slug' => 'photocopier',       'description' => 'Photocopying machines'],
            ['name' => 'Projector',         'slug' => 'projector',         'description' => 'Presentation projectors'],
            ['name' => 'Keyboard & Mouse',  'slug' => 'keyboard-mouse',    'description' => 'Input peripherals'],
            ['name' => 'Router / Switch',   'slug' => 'router-switch',     'description' => 'Networking equipment'],
            ['name' => 'UPS',               'slug' => 'ups',               'description' => 'Uninterruptible power supply units'],
            ['name' => 'Telephone',         'slug' => 'telephone',         'description' => 'Office telephones'],
            ['name' => 'External Storage',  'slug' => 'external-storage',  'description' => 'USB drives, external HDDs'],
            ['name' => 'Server',            'slug' => 'server',            'description' => 'Physical server hardware'],
        ];

        foreach ($categories as $category) {
            $exists = DB::table('categories')->where('slug', $category['slug'])->exists();
            if (! $exists) {
                DB::table('categories')->insert(array_merge($category, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    public function down(): void
    {
        DB::table('categories')->whereIn('slug', [
            'desktop-computer', 'laptop', 'virtual-machine', 'monitor',
            'printer', 'scanner', 'photocopier', 'projector',
            'keyboard-mouse', 'router-switch', 'ups', 'telephone',
            'external-storage', 'server',
        ])->delete();
    }
};
