<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(スキャン系)
 */
class Scanner
{
    /**
     * callable関数を適用した内容を積んで返却する
     *
     * @param iterable $source
     * @param callable $callable function($key, $value)
     * @return iterable
     */
    public static function map(iterable $source, callable $callable): iterable
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            $results[] = $callable($vl, $ky);
        }
        return $results;
    }



    /**
     * callable関数を適用した内容を積んで返却する
     * keyを維持する
     *
     * @param iterable $source
     * @param callable $callable function($key, $value)
     * @return iterable
     */
    public static function keyMap(iterable $source, callable $callable): iterable
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            $results[$ky] = $callable($vl, $ky);
        }
        return $results;
    }
}
