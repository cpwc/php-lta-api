<?php

namespace Cpwc\Lta\Api;

/**
 * @author Poh Wei Cheng <calvinpohwc@gmail.com>
 */
class BusArrival extends AbstractApi
{
    public function show(array $params)
    {
        return $this->get('BusArrival', $params);
    }
}
