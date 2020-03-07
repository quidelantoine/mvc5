<?php

namespace App\Weblitzer;

use App\Weblitzer\Config;

class Log
{
    static function logWrite(string $data)
    {
        $config = new Config();
        $directory = $_SERVER['DOCUMENT_ROOT'] . $config->get('directory') . 'var/log/';
        $file = date('Y-m-d') . ".log";
        $path = $directory . $file;
        $data = date('H:i:s') . " - " . $data;
        $handle = fopen($path, "a");
        if (flock($handle, LOCK_EX)) {
            fwrite($handle, $data . PHP_EOL);
            flock($handle, LOCK_UN);
        }
        fclose($handle);
    }
}
