<?php

use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activities')->insert([
            'activity_name' => 'Dinner',
        ]);

        DB::table('activities')->insert([
            'activity_name' => 'Movie',
        ]);

        DB::table('activities')->insert([
            'activity_name' => 'Anything',
        ]);
    }
}
