<?php
declare(strict_types=1);

namespace App\Utils;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Response Trait
 *
 */
trait Response
{
    /**
     * @param ResponseInterface $response
     * @param array $data
     * @return ResponseInterface
     * @throws JsonException
     **/
     public static function json(ResponseInterface $response, array $data): ResponseInterface
    {
        $json = JsonEncoder::encode($data);
        $body = new Stream('php://temp', 'wb+');
        $body->write($json);
        $body->rewind();
        return $response->withBody($body);
    }
}
