<?php

namespace Cpwc\Lta\Test\Api;

class SBSTRouteTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowSBSTRoute()
    {
        $client = new \Cpwc\Lta\Client();
        $client->authenticate('DXlOeK9vTdemwvFvOr74aA==', '06abea51-0913-48ab-afb5-20ea027deb6b');
        $result = $client->api('SBSTRoute')->show();

        $this->assertEquals(50, count($result['d']['results']));
    }

    protected function getApiClass()
    {
        return 'Cpwc\Lta\Api\SBSTRoute';
    }
}
