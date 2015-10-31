<?php

namespace Cpwc\Lta\Api;

/**
 * @author Poh Wei Cheng <calvinpohwc@gmail.com>
 */
class SBSTRoute extends AbstractApi
{
    const SIZE = 50;

    public function show($page = 1)
    {
        $skipCount = $this::SIZE * ($page - 1);
        $results = $this->get('SBSTRouteSet', array('$skip' => $skipCount, '$inlinecount' => 'allpages'));
//        $totalCount = $results['d']['__count'];
//        $totalPages = $totalCount / $this::SIZE;

//        for ($i = 1; $i <= $totalPages; $i++) {
//            $temp = $this->get('SBSTRouteSet', array('$skip' => ($this::SIZE * $i), '$inlinecount' => 'allpages'));
//            $results['d']['results'] = array_merge($results['d']['results'], $temp['d']['results']);
//        }

        return $results;
    }
}
