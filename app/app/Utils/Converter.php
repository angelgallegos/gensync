<?php

namespace App\Utils;

class Converter
{
    public static function toObject(array $array, $object)
    {
        $class = get_class($object);
        $methods = get_class_methods($class);
        foreach ($methods as $method) {
            preg_match(' /^(set)(.*?)$/i', $method, $results);
            $pre = $results[1]  ?? '';
            $k = $results[2]  ?? '';
            $k = self::camel_to_snake(strtolower(substr($k, 0, 1)) . substr($k, 1));
            If ($pre == 'set' && !empty($array[$k])) {
                $object->$method($array[$k]);
            }
        }
        return $object;
    }

    private static function camel_to_snake($input): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
