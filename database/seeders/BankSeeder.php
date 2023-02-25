<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;
class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            'name' => 'A Bank',
            'phone_number' => '01111111111',
            'head_address' => 'Thanh pho Ho Chi Minh',
        ]);

        Bank::create([
            'name' => 'B Bank',
            'phone_number' => '0111222333',
            'head_address' => 'Ha Noi',
        ]);

        Bank::create([
            'name' => 'C Bank',
            'phone_number' => '0999999999',
            'head_address' => 'tp Ho Chi Minh',
        ]);

        Bank::create([
            'name' => 'A Bank',
            'phone_number' => '0123123123',
            'head_address' => 'tp Ho Chi Minh',
        ]);
    }
}
