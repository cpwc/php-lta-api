<?php

namespace Cpwc\Lta\Api;

/**
 * @author Poh Wei Cheng <calvinpohwc@gmail.com>
 */
class SMRTRoute extends AbstractApi
{
    public function all()
    {
        $results = $this->get('SMRTRouteSet', array('$inlinecount' => 'allpages'));

        return $results['d']['__count'];
    }

    public function show(array $params)
    {
        return $this->get('SMRTRouteSet', $params);
    }
}
