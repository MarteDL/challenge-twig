<?php


namespace App\Class;

use App\Interface\transform;

class SpacesToDashes implements transform
{

    public function transform(string $string): string
    {
        return str_replace(' ', '-', $string);
    }
}