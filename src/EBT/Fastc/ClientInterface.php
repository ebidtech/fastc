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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * ClientInterface
 */
interface ClientInterface
{
    /**
     * @param string $userAgent
     */
    public function setUserAgent($userAgent);

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber);
}
