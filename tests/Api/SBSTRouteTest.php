<?php

namespace Cpwc\Lta\Test\Api;

class SBSTRouteTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowBusArrival()
    {
        $client = new \Cpwc\Lta\Client();
        $client->authenticate('DXlOeK9vTdemwvFvOr74aA==', '06abea51-0913-48ab-afb5-20ea027deb6b');
        $this->assertEquals('16224', $client->api('SBSTRoute')->all());
    }

    protected function getApiClass()
    {
        return 'Cpwc\Lta\Api\SBSTRoute';
    }
}
