<?php

namespace App\Console\Commands;

use Curl\Curl;

class BwbUpdateBookDesc extends BwbCommand
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
                try {
                    // get desc from api
                    $this->curl->get(sprintf('%s?%s', static::BWB_API_URL, http_build_query([
                        'ItemId' => $book->isbn13,
                    ])));
                    $xml = new \SimpleXMLElement($this->curl->response);
                    if (empty($xml->Items->Item->ItemAttributes->ShortDescription)) {
                        $this->error(sprintf('Unable to get description,%s', $book->isbn13));
                        continue;
                    }

                    // update
                    $book->description = (string) $xml->Items->Item->ItemAttributes->ShortDescription;
                    $book->save();

                    // dd($book);
                } catch (\Exception $e) {
                    $this->error(sprintf('%s,%s', $e->getMessage(), $book->isbn13));
                    continue;
                }
                $this->info(sprintf('The description updated successfully,%s', $book->isbn13));
            }
        });

    }

}
