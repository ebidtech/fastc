<?php

/*
 * This file is a part of the Fastc library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\Fastc\Tests\Model;

use EBT\Fastc\Client;
use Guzzle\Service\ClientInterface;
use Guzzle\Service\Description\ServiceDescription as GuzzleServiceDescription;
use ESO\IReflection\ReflClass;
use JMS\Serializer\SerializerInterface;

/**
 * TestClient;
 */
class TestClient extends Client
{
    /**
     * @return ClientInterface
     */
    public function getInternalClient()
    {
        return $this->client;
    }

    /**
     * @param string|array $config  File to build or array of operation information
     * @param array        $options Service description factory options
     *
     * @return GuzzleServiceDescription
     */
    public static function getInternalServiceDescription($config, array $options = array())
    {
        /** @var TestClient $client */
        $client = ReflClass::create(__CLASS__)->newInstanceWithoutConstructor();

        return $client->getServiceDescription($config, $options);
    }

    /**
     * @param string $dir
     * @param string $namespacePrefix
     *
     * @return SerializerInterface
     */
    public static function getInternalSerializer($dir, $namespacePrefix = '')
    {
        /** @var TestClient $client */
        $client = ReflClass::create(__CLASS__)->newInstanceWithoutConstructor();

        return $client->getSerializer($dir, $namespacePrefix);
    }
}
