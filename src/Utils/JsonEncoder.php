<?php
declare(strict_types=1);

namespace App\Utils;

/**
 * JsonEncoder 
 * 
 * @package namespace App\Utils
 */
class JsonEncoder
{
    /**
     *  encode
     *
     *  @param array $value
     *  @return string
     */
    public static function encode(array $value): string
    {
        return json_encode($value);
    }
}
