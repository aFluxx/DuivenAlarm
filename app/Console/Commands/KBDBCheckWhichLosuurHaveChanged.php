<?php

namespace App\Console\Commands;

use App\Flight;
use App\LosDataKbdb;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KBDBCheckWhichLosuurHaveChanged extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kbdb:check-welke-losuren-zijn-veranderd {livedata}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kijkt na welke losuren zijn veranderd';

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

        $flightsThatWereUpdated = [];

        foreach ($livedata as $key => $data) {
            $currentLosplaats = $data[0];
            $currentWeer = $data[1];
            $currentOpmerking = $data[2];
            $currentLiveLosuur = $data[3];

            if ($key == 0) {
                Log::info('$$$ No data yet, adding first data to database $$$');
                $this->info('$$$ No data yet, adding first data to database $$$');
            } elseif (!in_array($currentLiveLosuur, ['wachten', 'attendre', 'Wachten', 'Attendre'])) {
                Log::info('Losuur is veranderd voor vlucht: ' . $currentLosplaats);
                $this->info('Losuur is veranderd voor vlucht: ' . $currentLosplaats);
                Log::info('Extra opmerking: ' . $currentOpmerking);
                $this->info('Extra opmerking: ' . $currentOpmerking);
                Log::info('De vlucht is gelost om: ' . $currentLiveLosuur);
                $this->info('De vlucht is gelost om: ' . $currentLiveLosuur);
                Log::info(' ');

                $flightsThatWereUpdated[] = [
                    'losplaats_id' => Flight::where('name', $currentLosplaats)->orWhereJsonContains('flight_nicenames', $currentLosplaats)->first()->id,
                    'losplaats' => $currentLosplaats,
                    'opmerking' => $currentOpmerking,
                    'losuur' => $currentLiveLosuur,
                ];
            }
        }

        LosDataKbdb::notifyUsers($flightsThatWereUpdated);

        Artisan::call('kbdb:add-latest-data-to-db', ['livedata' => $livedata]);
    }
}
