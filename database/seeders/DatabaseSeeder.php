<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Division;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect(['Desktop', 'Laptop', 'Monitor', 'Printer', 'Networking'])
            ->map(fn ($name) => Category::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)]));

        $locations = collect([
            ['name' => 'HQ', 'building' => 'Main Building', 'floor' => '3', 'room' => '301'],
            ['name' => 'Branch Office', 'building' => 'Annex', 'floor' => '1', 'room' => '105'],
            ['name' => 'Server Room', 'building' => 'Main Building', 'floor' => 'B1', 'room' => 'SR-01'],
        ])->map(fn ($attrs) => Location::firstOrCreate(['name' => $attrs['name']], $attrs));

        $divisions = collect([
            ['name' => 'Placement and Employment Division', 'code' => 'PED', 'location_id' => $locations[0]->id],
            ['name' => 'Labor Market Information and Statistics Division', 'code' => 'LMISD', 'location_id' => $locations[0]->id],
            ['name' => 'Administrative Division', 'code' => 'ADMIN', 'location_id' => $locations[0]->id],
            ['name' => 'Special Programs Division', 'code' => 'SPD', 'location_id' => $locations[0]->id],
            ['name' => 'Office of the Public Employment Manager', 'code' => 'OPM', 'location_id' => $locations[0]->id],
            ['name' => 'Labor Relations and Standards Division', 'code' => 'LRSD', 'location_id' => $locations[0]->id],
            ['name' => 'Documentation and Records', 'code' => 'DOC', 'location_id' => $locations[0]->id],
            ['name' => 'Management and Support Division', 'code' => 'MSD', 'location_id' => $locations[0]->id],
        ])->map(fn ($attrs) => Division::firstOrCreate(
            ['code' => $attrs['code']],
            ['name' => $attrs['name'], 'location_id' => $attrs['location_id']]
        ));

        $statuses = Asset::STATUSES;

        for ($i = 1; $i <= 25; $i++) {
            $assetTag = sprintf('CMP-%04d', $i);
            $asset = Asset::withTrashed()->firstOrNew(['asset_tag' => $assetTag]);
            $asset->fill([
                'name' => 'Sample Computer '.$i,
                'category_id' => $categories->random()->id,
                'location_id' => $locations->random()->id,
                'brand' => ['Dell', 'HP', 'Lenovo', 'Asus'][array_rand(['Dell', 'HP', 'Lenovo', 'Asus'])],
                'serial_number' => 'SN'.strtoupper(uniqid()),
                'status' => $statuses[array_rand($statuses)],
                'purchase_date' => now()->subMonths(rand(1, 36)),
                'purchase_cost' => rand(300, 2000),
                'warranty_expiry' => now()->addMonths(rand(1, 24)),
            ]);
            if ($asset->trashed()) {
                $asset->restore();
            }
            $asset->save();
        }
    }
}
