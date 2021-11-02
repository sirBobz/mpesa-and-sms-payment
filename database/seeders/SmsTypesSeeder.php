<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SmsType;

class SmsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         SmsType::create(['sms_type' => 'Payment Initialization']);

         SmsType::create(['sms_type' => 'Payment Completion']);


    }
}
