<?php

namespace Lta\Test\Api;

class BusArrivalTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowBusArrival()
    {
        $expectedArray = array('id' => 1, 'username' => 'l3l0');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('BusArrival', array('BusStopID' => 72019, 'ServiceNo' => 5))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show(array('BusStopID' => 72019, 'ServiceNo' => 5)));
    }

    protected function getApiClass()
    {
        return 'Lta\Api\BusArrival';
    }
}