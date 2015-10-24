<?php

namespace Lta\HttpClient\Listener;

use Guzzle\Common\Event;
use Lta\Client;
use Lta\Exception\RuntimeException;

class AuthListener
{
    private $accountKey;
    private $uniqueUserId;
    private $method;

    public function __construct($accountKey, $uniqueUserId = null, $method)
    {
        $this->accountKey = $accountKey;
        $this->uniqueUserId = $uniqueUserId;
        $this->method = $method;
    }

    public function onRequestBeforeSend(Event $event)
    {
        // Skip by default
        if (null === $this->method) {
            return;
        }

        switch ($this->method) {
            case Client::AUTH_HTTP_TOKEN:
                $event['request']->setHeader('AccountKey', sprintf('%s', $this->accountKey));
                $event['request']->setHeader('UniqueUserID', sprintf('%s', $this->uniqueUserId));
                break;

            default:
                throw new RuntimeException(sprintf('%s not yet implemented', $this->method));
                break;
        }
    }
}
