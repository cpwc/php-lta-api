<?php

namespace Cpwc\Lta\Api;

/**
 * @author Poh Wei Cheng <calvinpohwc@gmail.com>
 */
class SMRTRoute extends AbstractApi
{
    const SIZE = 50;

    public function show($page = 1)
    {
        $skipCount = $this::SIZE * ($page - 1);
        $results = $this->get('SMRTRouteSet', array('$skip' => $skipCount, '$inlinecount' => 'allpages'));

        return $results;
    }
}
