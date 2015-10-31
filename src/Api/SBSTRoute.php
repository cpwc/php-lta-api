<?php

namespace Cpwc\Lta\Api;

/**
 * @author Poh Wei Cheng <calvinpohwc@gmail.com>
 */
class SBSTRoute extends AbstractApi
{
    const SIZE = 50;

    public function all()
    {
//        $this->client->getHttpClient()->client->setBaseUrl('http://datamall.mytransport.sg/ltaodataservice.svc/');
        $results = $this->get('SBSTRouteSet', array('$inlinecount' => 'allpages'));
        $totalCount = $results['d']['__count'];
        $totalPages = $totalCount / $this::SIZE;

        for ($i = 1; $i <= $totalPages; $i++) {
            $this->get('SBSTRouteSet', array('$skip' => ($this::SIZE * $i), '$inlinecount' => 'allpages'));
        }

        return $results['d']['__count'];
    }

    public function show(array $params)
    {
        return $this->get('SBSTRouteSet', $params);
    }
}
