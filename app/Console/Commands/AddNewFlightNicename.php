<?php

namespace App\Console\Commands;

use App\Flight;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AddNewFlightNicename extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:nicename {flight_id} {pendingNiceName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $flightId = $this->argument('flight_id');
        $pendingNiceName = $this->argument('pendingNiceName');

        $flight = Flight::where('id', $flightId)->first();

        $currentFlightNicenames = (array) json_decode($flight->flight_nicenames);

        if ($currentFlightNicenames != null) {
            if (!in_array($pendingNiceName, $currentFlightNicenames)) {
                $currentFlightNicenames[] = $pendingNiceName;
                $flight->flight_nicenames = $currentFlightNicenames;
                $this->info('Flight already has a nicename, adding new one to the json object');
            } else {
                $this->info('This nicename already exists, skipping!');
            }
        } else {
            $flight->flight_nicenames = json_encode((array) $pendingNiceName);

            $this->info('Flight has no nicenames yet, pushing first to json object');
        }

        $flight->save();

        $this->info('Added the new nicename to ' . $flight->name);

        $client = new Client();
        $crawler = $client->request('GET', 'https://www.kbdb.be/teletekst/lossingsinfo_nl.php');
        Artisan::call('kbdb:crawl', ['crawler' => $crawler]);
    }
}
