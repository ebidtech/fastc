<?php

/*
 * This file is a part of the Fastc library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\Fastc\Tests;

use EBT\Fastc\Tests\Model\TestClient;
use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Message\RequestInterface;
use EBT\Fastc\Listener\StatusCodeListener;
use EBT\Fastc\Listener\ParseResponseListener;
use EBT\Fastc\Tests\Model\ModelResponse;

/**
 * ClientTest
 */
class ClientTest extends TestCase
{
    /**
     * @expectedException \Guzzle\Common\Exception\InvalidArgumentException
     * @expectedExceptionMessage Command was not found
     */
    public function testMissingCommand()
    {
        $client = new TestClient(
            TestClient::getInternalServiceDescription(__DIR__ . '/Model/description_services.yml')
        );
        $client->getInternalClient()->getCommand('getTestAbsent');
    }

    public function testUserAgent()
    {
        $client = new TestClient(
            TestClient::getInternalServiceDescription(__DIR__ . '/Model/description_services.yml')
        );
        $client->setUserAgent('user agent test');

        $mockPlugin = new MockPlugin();
        $client->addSubscriber($mockPlugin);
        $mockPlugin->addResponse(new Response(200));

        $client->getInternalClient()->getCommand('getTest2')->execute();

        /** @var RequestInterface $request */
        $request = $mockPlugin->getReceivedRequests()[0];

        $this->assertEquals('user agent test', $request->getHeader('User-agent')->getIterator()[0]);
    }

    /**
     * @expectedException \EBT\Fastc\Exception\RuntimeException
     * @expectedExceptionMessage expected status code
     */
    public function testStatusCodeListener()
    {
        $client = new TestClient(
            TestClient::getInternalServiceDescription(__DIR__ . '/Model/description_services.yml')
        );
        $client->addSubscriber(new StatusCodeListener());

        $mockPlugin = new MockPlugin();
        $client->addSubscriber($mockPlugin);
        $mockPlugin->addResponse(new Response(205, null, 'test'));

        $client->getInternalClient()->getCommand('getTest')->execute();
    }



    public function testParseResponseListener()
    {
        $client = new TestClient(
            TestClient::getInternalServiceDescription(__DIR__ . '/Model/description_services.yml')
        );
        $client->addSubscriber(
            new ParseResponseListener(
                TestClient::getInternalSerializer(__DIR__ . '/Model/serializer/')
            )
        );

        $mockPlugin = new MockPlugin();
        $client->addSubscriber($mockPlugin);
        $mockPlugin->addResponse(new Response(200, null, '{"type":"test"}'));

        /** @var ModelResponse $response */
        $response = $client->getInternalClient()->getCommand('getTest')->execute();

        $this->assertEquals('test', $response->getType());
    }
}
