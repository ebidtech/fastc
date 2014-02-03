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
use Guzzle\Common\Event as GuzzleEvent;
use Guzzle\Service\Command\CommandInterface as GuzzleCommandInterface;

/**
 * StatusCodeListener
 */
class StatusCodeListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array('command.after_send' => array('checkStatusCode'));
    }

    /**
     * @param GuzzleEvent $event
     *
     * @throws \RuntimeException
     */
    public function checkStatusCode(GuzzleEvent $event)
    {
        /** @var GuzzleCommandInterface $command */
        $command = $event['command'];
        $response = $command->getResponse();

        $acceptedStatusCodes = $command->getOperation()->getData('acceptedStatusCodes');

        if (!is_int($acceptedStatusCodes)) {
            $acceptedStatusCodes = 200;
        }

        if (is_int($acceptedStatusCodes)) {
            $acceptedStatusCodes = array($acceptedStatusCodes);
        }

        $statusCode = $response->getStatusCode();

        if (!in_array($statusCode, $acceptedStatusCodes)) {
            throw new \RuntimeException(
                sprintf(
                    'Operation "%s" expected status code: "%s" got: "%s" and body: %s',
                    $command->getOperation()->getName(),
                    implode(',', $acceptedStatusCodes),
                    $statusCode,
                    $response->getBody()
                )
            );
        }
    }
}
