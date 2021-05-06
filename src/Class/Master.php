<?php


namespace App\Class;

use App\Interface\logger;
use App\Interface\transform;

class Master
{
    public function messageHandler(string $input, transform $transformClass, logger $logger):
    string
    {
        $logger->log($input);
        return $transformClass->transform($input);
    }
}