<?php


namespace App\Class;

use App\Interface\transform;

class Capitalize implements transform
{

    public function transform(string $string): string
    {
        $stringAsArray = str_split($string);

        foreach ($stringAsArray as $i => $char){
            if($i%2 === 0){
                $stringAsArray[$i] = strtoupper($char);
            }
        }

        return implode($stringAsArray);
    }
}
