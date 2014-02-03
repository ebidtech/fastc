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
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EBT\ConfigLoader\YamlFileLoader;

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
     * @param EventSubscriberInterface $subscriber
     */
    final public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->client->addSubscriber($subscriber);
    }

    /**
     * @param string|array $config  File to build or array of operation information
     * @param array        $options Service description factory options
     *
     * @return GuzzleServiceDescription
     */
    final protected function getServiceDescription($config, array $options = array())
    {
        // Adds support for YML
        if (is_string($config) && pathinfo($config, PATHINFO_EXTENSION) === 'yml') {
            $config = (new YamlFileLoader())->load($config);
        }

        return GuzzleServiceDescription::factory($config, $options);
    }

    /**
     * @param string $dir
     * @param string $namespacePrefix
     *
     * @return SerializerInterface
     */
    final protected function getSerializer($dir, $namespacePrefix = '')
    {
        return SerializerBuilder::create()->addMetadataDir($dir, $namespacePrefix)->build();
    }
}
