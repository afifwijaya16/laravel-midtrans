<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produks')->insert(
            [
                [
                    'name'  => 'Apel',
                    'price'  => '3000',
                    'quantity'  => '50',
                ],
                [
                    'name'  => 'Jeruk',
                    'price'  => '2000',
                    'quantity'  => '40',
                ],
            ]
        );
    }
}
