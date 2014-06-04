<?php

/*
 * This file is a part of the Fastc library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\Fastc\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Guzzle\Service\Command\CreateResponseClassEvent as GuzzleCreateResponseClassEvent;
use Guzzle\Service\Command\CommandInterface as GuzzleCommandInterface;
use Guzzle\Service\Exception\ResponseClassException as GuzzleResponseClassException;
use JMS\Serializer\SerializerInterface;
use Guzzle\Service\Description\OperationInterface;

/**
 * ParseResponseListener
 */
class ParseResponseListener implements EventSubscriberInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array('command.parse_response' => array('commandParseResponse'));
    }

    /**
     * @param GuzzleCreateResponseClassEvent $event
     *
     * @throws GuzzleResponseClassException
     */
    public function commandParseResponse(GuzzleCreateResponseClassEvent $event)
    {
        /** @var GuzzleCommandInterface $command */
        $command = $event['command'];

        $className = $this->getResponseClass($command->getOperation());

        // if the guzzle way fromCommand is present don't do anything
        if (!method_exists($className, 'fromCommand')) {
            $event->setResult(
                $this->serializer->deserialize($command->getResponse()->getBody(), $className, 'json')
            );
        }
    }

    /**
     * This is a good extension point if you need something fancier
     *
     * @param OperationInterface $operation
     *
     * @return string
     */
    protected function getResponseClass(OperationInterface $operation)
    {
        return $operation->getResponseClass();
    }
}
