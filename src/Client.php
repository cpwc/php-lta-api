<?php

namespace Cpwc\Lta;

use Cpwc\Lta\Api\ApiInterface;
use Cpwc\Lta\Exception\InvalidArgumentException;
use Cpwc\Lta\Exception\BadMethodCallException;
use Cpwc\Lta\HttpClient\HttpClient;
use Cpwc\Lta\HttpClient\HttpClientInterface;

/**
 * Simple yet very cool PHP LTA client.
 *
 * @method Api\BusArrival busArrival()
 *
 * @author Poh Wei Cheng <calvinpohwc@gmail.com>
 */
class Client
{
    /**
     * Constant for authentication method. Indicates the new login method with
     * with username and token via HTTP Authentication.
     */
    const AUTH_HTTP_TOKEN = 'http_token';

    /**
     * @var array
     */
    private $options = array(
        'base_url'   => 'http://datamall2.mytransport.sg/ltaodataservice/',
        'user_agent' => 'php-lta-api (https://github.com/cpwc/php-lta-api)',
        'accept'     => 'application/json',
        'timeout'    => 10,
        'cache_dir'  => null
    );

    /**
     * The Buzz instance used to communicate with GitHub.
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Instantiate a new LTA client.
     *
     * @param null|HttpClientInterface $httpClient LTA http client
     */
    public function __construct(HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return ApiInterface
     */
    public function api($name)
    {
        switch ($name) {
            case 'bus_arrival':
            case 'busArrival':
                $api = new Api\BusArrival($this);
                break;

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }

    /**
     * Authenticate a user for all next requests.
     *
     * @param string      $accountKey   LTA DataMall AccountKey
     * @param string      $uniqueUserId UniqueUserID generated from DataMall Tool
     * @param null|string $authMethod   One of the AUTH_* class constants
     */
    public function authenticate($accountKey, $uniqueUserId, $authMethod = null)
    {
        if (null === $authMethod) {
            $authMethod = self::AUTH_HTTP_TOKEN;
        }

        $this->getHttpClient()->authenticate($accountKey, $uniqueUserId, $authMethod);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = new HttpClient($this->options);
        }

        return $this->httpClient;
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Clears used headers.
     */
    public function clearHeaders()
    {
        $this->getHttpClient()->clearHeaders();
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->getHttpClient()->setHeaders($headers);
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        return $this->options[$name];
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws InvalidArgumentException
     * @throws InvalidArgumentException
     */
    public function setOption($name, $value)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        $this->options[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return ApiInterface
     */
    public function __call($name, $args)
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }
}
