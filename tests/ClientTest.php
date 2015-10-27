<?php

namespace Cpwc\Lta\Test;

use Cpwc\Lta\Client;
use Cpwc\Lta\Exception\BadMethodCallException;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client();

        $this->assertInstanceOf('Cpwc\Lta\HttpClient\HttpClient', $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldPassHttpClientInterfaceToConstructor()
    {
        $client = new Client($this->getHttpClientMock());

        $this->assertInstanceOf('Cpwc\Lta\HttpClient\HttpClientInterface', $client->getHttpClient());
    }

    /**
     * @test
     * @dataProvider getAuthenticationFullData
     */
    public function shouldAuthenticateUsingAllGivenParameters($accountKey, $uniqueUserId, $method)
    {
        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('authenticate')
            ->with($accountKey, $uniqueUserId, $method);

        $client = new Client($httpClient);
        $client->authenticate($accountKey, $uniqueUserId, $method);
    }

    public function getAuthenticationFullData()
    {
        return array(
            array('account_key', 'unique_user_id', Client::AUTH_HTTP_TOKEN),
        );
    }

    /**
     * @test
     */
    public function shouldClearHeadersLazy()
    {
        $httpClient = $this->getHttpClientMock(array('clearHeaders'));
        $httpClient->expects($this->once())->method('clearHeaders');

        $client = new Client($httpClient);
        $client->clearHeaders();
    }

    /**
     * @test
     */
    public function shouldSetHeadersLazily()
    {
        $headers = array('header1', 'header2');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())->method('setHeaders')->with($headers);

        $client = new Client($httpClient);
        $client->setHeaders($headers);
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetMagicApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->$apiName());
    }

    /**
     * @test
     * @expectedException \Cpwc\Lta\Exception\InvalidArgumentException
     */
    public function shouldNotGetApiInstance()
    {
        $client = new Client();
        $client->api('do_not_exist');
    }

    /**
     * @test
     * @expectedException BadMethodCallException
     */
    public function shouldNotGetMagicApiInstance()
    {
        $client = new Client();
        $client->doNotExist();
    }

    public function getApiClassesProvider()
    {
        return array(
            array('bus_arrival', 'Cpwc\Lta\Api\BusArrival'),
            array('busArrival', 'Cpwc\Lta\Api\BusArrival'),
        );
    }

    public function getHttpClientMock(array $methods = array())
    {
        $methods = array_merge(
            array('get', 'post', 'patch', 'put', 'delete', 'request', 'setOption', 'setHeaders', 'authenticate'),
            $methods
        );

        return $this->getMock('Cpwc\Lta\HttpClient\HttpClientInterface', $methods);
    }
}
