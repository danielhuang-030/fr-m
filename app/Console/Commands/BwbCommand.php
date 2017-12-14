<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

abstract class BwbCommand extends Command
{
    /**
     * log file name
     *
     * @var string
     */
    protected $logFileName = '';

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();

        // set log file name
        $this->logFileName = sprintf('%s_%s.csv', snake_case(class_basename(get_class($this))), date('YmdHis'));
    }

    /**
     * info
     *
     * @param string $string
     * @param string $verbosity
     */
    public function info($string, $verbosity = null)
    {
        // log
        $this->logOutputInfo(sprintf('%s,info,%s', date('Y-m-d H:i:s'), $string));

        parent::info($string, $verbosity);
    }

    /**
     * error
     *
     * @param string $string
     * @param string $verbosity
     */
    public function error($string, $verbosity = null)
    {
        // log
        $this->logOutputInfo(sprintf('%s,error,%s', date('Y-m-d H:i:s'), $string));

        parent::error($string, $verbosity);
    }

    /**
     * log output info
     *
     * @param type $string
     */
    protected function logOutputInfo($string)
    {
        File::append(sprintf('%s/%s', storage_path('logs'), $this->logFileName), $string . PHP_EOL);
    }

}
