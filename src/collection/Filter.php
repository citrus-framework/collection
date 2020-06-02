<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(フィルタ系)
 */
class Filter
{
    /**
     * callable関数の返却値がtrueの場合に積んで返却する
     *
     * @param iterable $source
     * @param callable $callable function($key, $value)
     * @return iterable
     */
    public static function filter(iterable $source, callable $callable): iterable
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            if (true === $callable($vl, $ky))
            {
                $results[$ky] = $vl;
            }
        }
        return $results;
    }
}
