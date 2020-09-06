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
            $toSaveLosPlaats = $data[0];
            $toSaveWeer = $data[1];
            $toSaveOpmerking = $data[2];
            $toSaveLosuur = $data[3];

            if (!$currentFlight) {
                Log::info('Trying to add a flight which we havent saved yet, flight name: ' . $data[0]);
                $this->info('Trying to add a flight which we havent saved yet, flight name: ' . $data[0]);
                Log::info(' ');
            } else {
                LosDataKbdb::create([
                    'losplaats' => stripAccents($toSaveLosPlaats),
                    'flight_id' => $currentFlight->id,
                    'weer' => stripAccents($toSaveWeer),
                    'opmerking' => stripAccents($toSaveOpmerking),
                    'losuur' => $toSaveLosuur,
                ]);
            }
        }

        Log::info('Nieuwe data is overschreven');
        $this->info('Nieuwe data is overschreven');
    }
}
