<?php

/*
 * This file is a part of the Fastc library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\Fastc\Exception;

/**
 * RuntimeException
 */
class RuntimeException extends \RuntimeException
{
    /**
     * @param string $operationName
     * @param array  $acceptedStatusCodes
     * @param int    $statusCode
     * @param string $body
     *
     * @return RuntimeException
     */
    public static function operationExpectedStatusCode($operationName, array $acceptedStatusCodes, $statusCode, $body)
    {
        return new static(
            sprintf(
                'Operation "%s" expected status code: "%s" got: "%s" and body: %s',
                $operationName,
                implode(',', $acceptedStatusCodes),
                $statusCode,
                $body
            )
        );
    }
}
