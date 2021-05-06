<?php


namespace App\Class;


use App\Interface\logger;

class InfoLogger implements logger
{
    public function log(string $message) : void
    {
        file_put_contents('log.info', $message, FILE_APPEND);
    }
}