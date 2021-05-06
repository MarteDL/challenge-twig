<?php


namespace App\Class;

use App\Interface\transform;
use Monolog\Logger;

class Master
{
    public function messageHandler(string $message, transform $transformClass, Logger $logger):
    string
    {
        $logger->info($message);
        return $transformClass->transform($message);
    }
}