<?php

use App\Flight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('flights')->delete();

        $losplaatsen = File::get('database/data/losplaatsen.json');

        foreach (json_decode($losplaatsen) as $obj) {
            Flight::create([
                'name' => $obj->name,
            ]);
        }
    }
}
