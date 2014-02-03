<?php

/*
 * This file is a part of the Fastc library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\Fastc;

use Guzzle\Service\Client as GuzzleClient;
use Guzzle\Service\ClientInterface as GuzzleClientInterface;
use Guzzle\Service\Description\ServiceDescription as GuzzleServiceDescription;

/**
 * Client
 */
abstract class Client
{
    /**
     * @var GuzzleClientInterface
     */
    protected $client;

    /**
     * @param GuzzleServiceDescription $description
     * @param array                    $config
     */
    public function __construct(GuzzleServiceDescription $description, array $config = array())
    {
        $this->client = GuzzleClient::factory(array_merge($this->getDefaultConfig(), $config));
        $this->client->setDescription($description);
    }

    /**
     * @return array
     */
    protected function getDefaultConfig()
    {
        return array();
    }

    /**
     * @param $userAgent
     */
    final public function setUserAgent($userAgent)
    {
        $this->client->setUserAgent($userAgent);
    }

    /**
     * @param array $subscribers
     */
    final public function addSubscribers(array $subscribers)
    {
        foreach ($subscribers as $subscriber) {
            $this->client->addSubscriber($subscriber);
        }
    }

    /**
     * @param string|array $config  File to build or array of operation information
     * @param array        $options Service description factory options
     *
     * @return GuzzleServiceDescription
     */
    protected static function getServiceDescription($config, array $options = array())
    {
        return GuzzleServiceDescription::factory($config, $options);
    }
}
