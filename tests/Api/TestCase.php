<?php

namespace Lta\Test\Api;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    abstract protected function getApiClass();

    protected function getApiMock()
    {
        $httpClient = $this->getMock('Guzzle\Http\Client', array('send'));
        $httpClient
            ->expects($this->any())
            ->method('send');

        $mock = $this->getMock('Lta\HttpClient\HttpClient', array(), array(array(), $httpClient));

        $client = new \Lta\Client($mock);
        $client->setHttpClient($mock);

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(array('get', 'post', 'postRaw', 'patch', 'delete', 'put', 'head'))
            ->setConstructorArgs(array($client))
            ->getMock();
    }
}