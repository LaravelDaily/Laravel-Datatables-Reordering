<?php

use App\Currency;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                'id'         => '1',
                'name'       => 'U.S. dollar',
                'short_code' => 'USD',
                'position'   => '1'
            ],
            [
                'id'         => '2',
                'name'       => 'Canadian dollar',
                'short_code' => 'CAD',
                'position'   => '2'
            ],
            [
                'id'         => '3',
                'name'       => 'Euro',
                'short_code' => 'EUR',
                'position'   => '3'
            ],
            [
                'id'         => '4',
                'name'       => 'British pound',
                'short_code' => 'GBP',
                'position'   => '4'
            ],
            [
                'id'         => '5',
                'name'       => 'Swiss franc',
                'short_code' => 'CHF',
                'position'   => '5'
            ]
        ];

        Currency::insert($currencies);
    }
}
