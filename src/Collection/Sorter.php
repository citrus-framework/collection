<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(ソート系)
 */
class Sorter
{
    /**
     * callable関数を利用してソートする
     *
     * callable関数は -1 or 0 or 1 を返却する
     *
     * @param array    $source
     * @param callable $callable function($value1, $value2)
     * @return array
     */
    public static function sortBy(array $source, callable $callable): array
    {
        usort($source, $callable);
        return $source;
    }
}
