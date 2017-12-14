<?php

namespace App\Console\Commands;

use Storage;
use Curl\Curl;

class BwbGetBooks extends BwbCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bwb:get {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get books from bwb algolia feed';

    /**
     * curl
     *
     * @var Curl
     */
    private $curl;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Curl $curl)
    {
        parent::__construct();
        ini_set("memory_limit", "4096M");
        $curl->setHeader("X-Algolia-API-Key", env('ALGOLIA_API_KEY'));
        $curl->setHeader("X-Algolia-Application-Id", env('ALGOLIA_APP_ID'));
        $this->curl = $curl;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cursor = '';
        $books = [];
        $page = 1;
        $directory = sprintf('%s/%s', env('ALGOLIA_DATA_PATH'), $this->getDate());
        Storage::disk('public')->makeDirectory($directory, 0777);
        do {
            $url = (!empty($cursor) ? sprintf("%s?%s", env('ALGOLIA_API_URL'), http_build_query(['cursor' => urldecode($cursor)])) : env('ALGOLIA_API_URL'));
            $this->curl->get($url);
            $data = json_decode($this->curl->response, true);
            $cursor = (!empty($data['cursor']) ? urlencode($data['cursor']) : "");
            $books = $data['hits'];
            Storage::disk('public')->put(sprintf("%s/page_%05d.min.json", $directory, $page), json_encode($books));
            $data = null;
            $books = null;

            // info
            $this->info(sprintf('page: %d downloaded next cursor,%s', $page, $cursor));

            $page ++;

            // 先抓 30 頁測試
            if (51 == $page) {
                $cursor = "";
            }
        } while (!empty($cursor));

    }

    private function getDate()
    {
        return $this->argument('date') ? $this->argument('date'): (new \DateTime())->format('Ymd');
    }
}
