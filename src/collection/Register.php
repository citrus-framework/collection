<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(追加系)
 */
class Register
{
    /**
     * callable関数がnull以外の値を返した場合、値を積んで返却する
     *
     * @param iterable $source
     * @param callable $callable function($key, $value)
     * @return iterable
     */
    public static function append(iterable $source, callable $callable): iterable
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            $append = $callable($vl, $ky);
            if (false === is_null($append))
            {
                $results[$ky] = $append;
            }
        }
        return $results;
    }
}
