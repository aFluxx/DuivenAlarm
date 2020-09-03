<?php

namespace App\Console\Commands;

use App\LosDataKbdb;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

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

        foreach ($livedata as $key => $data) {
            $record = LosDataKbdb::where([
                ['losplaats', '=', $data[0]],
                ['weer', '=', $data[1]],
                ['opmerking', '=', $data[2]],
            ])->first();

            $currentLosplaats = $data[0];
            $currentOpmerking = $data[2];
            $currentLiveLosuur = $data[3];

            if (!$record) {
                if ($key == 0) {
                    Log::info('$$$ No data yet, adding first data to database $$$');
                }
            } elseif (
                in_array($record->losuur, ['wachten', 'attendre', 'Wachten', 'Attendre'])
            ) {
                Log::info('Losuur is veranderd voor vlucht: ' . $currentLosplaats);
                Log::info('Extra opmerking: ' . $currentOpmerking);
                Log::info('De vlucht is gelost om: ' . $currentLiveLosuur);
                Log::info(' ');
            }
        }

        Artisan::call('kbdb:add-latest-data-to-db', ['livedata' => $livedata]);
    }
}