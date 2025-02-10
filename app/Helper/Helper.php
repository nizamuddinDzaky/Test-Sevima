<?php

declare(strict_types=1);

namespace App\Helper;
trait Helper
{
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = \strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function multi_array_search($array, $search, $returnData = false, $like = false)
    {
        // Create the result array
        $result = [];
        // Iterate over each array element
        foreach ($array as $key => $value) {
            // Iterate over each search condition
            foreach ($search as $k => $v) {
                if (\is_object($value)) {
                    if(!$like){
                        if (!isset($value->{$k}) || $value->{$k} !== $v) {
                            continue 2;
                        }
                    }else{
                        if (!isset($value->{$k}) || !strpos($value->{$k},$v)) {
                            continue 2;
                        }
                    }
                } else {
                    // If the array element does not meet the search condition then continue to the next element
                    if(!$like){
                        if (!isset($value[$k]) || $value[$k] !== $v) {
                            continue 2;
                        }
                    }else{
                        if (!isset($value[$k]) || !strpos($value[$k],$v)) {
                            continue 2;
                        }
                    }
                }
            }
            // Add the array element's key to the result array
            if ($returnData) {
                if(is_object($array[$key])){
                    $result[] = clone $array[$key];

                }else{
                    $result[] = $array[$key];
                }
                // dd(gettype($array));
            } else {
                $result[] = $key;
            }
        }
        // Return the result array
        return $result;
    }
}