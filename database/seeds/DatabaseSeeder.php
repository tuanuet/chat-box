<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topics')->insert([
            'name' => "Technique",
        ]);
        DB::table('topics')->insert([
            'name' => "Sale",
        ]);
        DB::table('topics')->insert([
            'name' => "Other",
        ]);
        factory(App\Admin::class, 10)->create()->make();
        factory(App\Message::class, 10000)->create()->make();
        factory(App\Customer::class, 500)->create()->make();
        factory(App\Room::class, 200)->create()->make();
    }
}
