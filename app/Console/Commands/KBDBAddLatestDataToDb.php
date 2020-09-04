<?php

namespace App\Console\Commands;

use App\Flight;
use App\LosDataKbdb;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class KBDBAddLatestDataToDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kbdb:add-latest-data-to-db {livedata}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Overschrijf de oude data met de nieuwe gecrawlde data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $livedata = $this->argument('livedata');

        LosDataKbdb::truncate();

        foreach ($livedata as $data) {
            $currentFlight = Flight::where('name', $data[0])->orWhereJsonContains('flight_nicenames', $data[0])->first();

            if (!$currentFlight) {
                Log::info('Trying to add a flight which we havent saved yet, flight name: ' . $data[0]);
                Log::info(' ');
            } else {
                LosDataKbdb::create([
                    'losplaats' => $data[0],
                    'flight_id' => $currentFlight->id,
                    'weer' => $data[1],
                    'opmerking' => $data[2],
                    'losuur' => $data[3],
                ]);
            }
        }

        Log::info('Nieuwe data is overschreven');
    }
}
