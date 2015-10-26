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

//        var_dump(json_decode('{ "odata.metadata":"http://datamall2.mytransport.sg/ltaodataservice/$metadata#BusArrival/@Element","BusStopID":"72011","Services":[ { "ServiceNo":"15","Status":"In Operation","Operator":"SBST","NextBus":{ "EstimatedArrival":"2015-10-26T08:26:09+00:00","Load":"Standing Available","Feature":"WAB" },"SubsequentBus":{ "EstimatedArrival":"2015-10-26T08:35:12+00:00","Load":"Seats Available","Feature":"WAB" } } ] }'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('BusArrival', array('BusStopID' => 72011, 'ServiceNo' => 15))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show(array('BusStopID' => 72011, 'ServiceNo' => 15)));
    }

    protected function getApiClass()
    {
        return 'Lta\Api\BusArrival';
    }
}
