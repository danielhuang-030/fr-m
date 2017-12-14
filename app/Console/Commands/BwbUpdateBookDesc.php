<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use File;
use Curl\Curl;

class BwbUpdateBookDesc extends Command
{
    /**
     * bwb api url
     *
     * @var string
     */
    const BWB_API_URL = 'http://products.betterworldbooks.com/service.aspx';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bwb:update-desc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update the description of books from bwb';

    /**
     * Curl
     *
     * @var Curl
     */
    protected $curl;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Curl $curl)
    {
        parent::__construct();
        ini_set("memory_limit", "4096M");
        $this->curl = $curl;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = new \App\Models\Book();

        // handle 500 at one time
        $model->where('description', null)->chunk(500, function($books) {
            foreach ($books as $book) {
                // get desc from api
                $this->curl->get(sprintf('%s?%s', static::BWB_API_URL, http_build_query([
                    'ItemId' => $book->isbn13,
                ])));
                if ($this->curl->error) {
                    $this->error(sprintf('%s,%s', $this->curl->curl_error_message, $book->isbn13));
                    continue;
                }
                $xml = new \SimpleXMLElement($this->curl->response);
                if (!isset($xml->Items->Item->ItemAttributes->ShortDescription)) {
                    $this->error(sprintf('Unable to get description,%s', $this->curl->curl_error_message, $book->isbn13));
                    continue;
                }

                // update
                $book->description = (string) $xml->Items->Item->ItemAttributes->ShortDescription;
                $book->save();

                // dd($book);

                $this->info(sprintf('The description updated successfully,%s', $book->isbn13));
            }
        });

    }

    public function error($string, $verbosity = null)
    {
        // log
        $this->logOutputInfo(sprintf('error,%s', $string));

        parent::error($string, $verbosity);
    }

    protected function logOutputInfo($string)
    {
        file_put_contents(sprintf('%s/update_desc.log', storage_path('logs')), $string . "\n", FILE_APPEND);
    }

}
