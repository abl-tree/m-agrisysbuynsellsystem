<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class access_levels extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'id' => 1,
                'name' => 'admin',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'id' => 2,
                'name' => 'cashier',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            )
        );

        DB::table('access_levels')->insert($data);
    }
}
