<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(取得系)
 */
class Fetcher
{
    /**
     * 先頭の要素を取得
     *
     * @param array         $source
     * @param callable|null $callable function($value, $key)
     * @return mixed
     */
    public static function first(array $source, callable|null $callable = null): mixed
    {
        $filtered = Filter::filter($source, $callable);
        $count = Measurer::count($filtered);
        // 無ければnull
        if (0 === $count)
        {
            return null;
        }
        return array_values($filtered)[0];
    }

    /**
     * 最後の要素を取得
     *
     * @param array         $source
     * @param callable|null $callable function($value, $key)
     * @return mixed
     */
    public static function last(array $source, callable|null $callable = null): mixed
    {
        $filtered = Filter::filter($source, $callable);
        $count = Measurer::count($filtered);
        // 無ければnull
        if (0 === $count)
        {
            return null;
        }
        return array_values($filtered)[$count - 1];
    }

    /**
     * 指定番号の要素を取得
     *
     * @param array         $source
     * @param int           $index
     * @param callable|null $callable function($value, $key)
     * @return mixed
     */
    public static function at(array $source, int $index, callable|null $callable = null): mixed
    {
        $filtered = Filter::filter($source, $callable);
        $count = Measurer::count($filtered);
        // 無ければnull
        if (0 === $count)
        {
            return null;
        }
        return array_values($filtered)[$index];
    }
}
