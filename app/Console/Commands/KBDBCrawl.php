<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class KBDBCrawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kbdb:crawl {crawler}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl www.kbdb.be for lossingsdata';

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
        $crawler = (object) $this->argument('crawler');

        $table = $crawler->filter('table:first-of-type')->filter('tr')->each(function ($tr, $i) {
            return $tr->filter('td')->each(function ($td, $i) {
                return trim($td->text());
            });
        });

        // Remove the first row cause it's the header row, but they failed their HTML markup
        unset($table[0]);

        Artisan::call('kbdb:check-welke-losuren-zijn-veranderd', ['livedata' => $table]);

        Log::info('KBDB website has been crawled en losuren zijn geupdate');
        $this->info('KBDB website has been crawled en losuren zijn geupdate');
        Log::info(' ');
    }
}
