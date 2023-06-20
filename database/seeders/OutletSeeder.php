<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlets = [
            [
                'name'        => 'Store One',
                'phone'       => '5555',
                'address'     => 'BOF, Gazipur, Dhaka',
            ]
        ];

        foreach ( $outlets as $outlet ) {
            Outlet::updateOrCreate(['name' => $outlet['name']], $outlet );
        }
    }
}
