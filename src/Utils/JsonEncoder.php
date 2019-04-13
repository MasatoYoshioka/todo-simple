<?php
declare(strict_types=1);

namespace App\Utils;

use App\Exceptions\JsonException;
    
/**
 * JsonEncoder 
 * 
 * @package namespace App\Utils
 */
class JsonEncoder
{
    /** @var array **/
    private static $errors = [
        JSON_ERROR_NONE => 'no error',
        JSON_ERROR_DEPTH => '',
        JSON_ERROR_STATE_MISMATCH => '',
        JSON_ERROR_CTRL_CHAR => '',
        JSON_ERROR_SYNTAX => '',
        JSON_ERROR_UTF8 => '',
        JSON_ERROR_RECURSION => '',
        JSON_ERROR_INF_OR_NAN => '',
        JSON_ERROR_UNSUPPORTED_TYPE => '',
        JSON_ERROR_INVALID_PROPERTY_NAME => '',
        JSON_ERROR_UTF16 => '',
    ];

    /**
     *  encode
     *
     *  @param array $value
     *  @return string
     *  @throws JsonException
     */
    public static function encode(array $value): string
    {
        $ret = json_encode($value);
        if ($ret === false) {
            throw new JsonException(self::$errors[json_last_error()]);
        }
        return $ret;
    }
}
