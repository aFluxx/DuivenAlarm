<?php

namespace App\Console\Commands;

use App\LastChanged;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KBDBCheckIfLossingsDataGotUpdated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kbdb:check-timestamp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kijkt na of de timestamp op de KBDB webiste is geupdate';

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
        $client = new Client();
        $client->setServerParameter('Content-Type', 'text/html; charset=utf-8');

        $crawler = $client->request('GET', 'https://www.kbdb.be/teletekst/lossingsinfo_nl.php');

        // $counter = DB::table('counter')->first()->count;
        // $crawler = $client->request('GET', 'http://844bb6f84631.ngrok.io/kbdb/table/' . $counter);
        // $counter++;
        // DB::table('counter')->truncate();
        // DB::table('counter')->insert(['count' => $counter]);

        $lastChangedData = explode(" ", $crawler->filter('strong:first-of-type')->eq(0)->text());
        $lastChangedTime = Carbon::parse(str_replace('/', '-', $lastChangedData[1]) . ' ' . $lastChangedData[2]);

        if (LastChanged::first() && LastChanged::latest('created_at')->where('source', 'kbdb')->first()->last_changed_time == $lastChangedTime) {
            Log::info('No changes');
            $this->info('No changes');
            Log::info(' ');
        } else {
            Log::info('Info updated, added new time record to table');
            $this->info('Info updated, added new time record to table');

            LastChanged::create([
                'last_changed_time' => $lastChangedTime,
                'source' => 'kbdb',
            ]);

            Log::info('Now crawling kbdb website');
            $this->info('Now crawling kbdb website');
            Log::info(' ');
            Artisan::call('kbdb:crawl', ['crawler' => $crawler]);
        }
    }
}
