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
     * @param array    $source
     * @param callable $callable function($value, $key)
     * @return array
     */
    public static function map(array $source, callable $callable): array
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
     * keyを指定する
     * @param array    $source
     * @param callable $callable function($value, $key)
     * @return array
     */
    public static function mapWithKey(array $source, callable $callable): array
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            $results += $callable($vl, $ky);
        }
        return $results;
    }

    /**
     * callable関数を適用した内容を積んで返却する
     * keyを維持する
     * @param array    $source
     * @param callable $callable function($value, $key)
     * @return array
     */
    public static function keyMap(array $source, callable $callable): array
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            $results[$ky] = $callable($vl, $ky);
        }
        return $results;
    }

    /**
     * 多次元コレクションを一次元にする
     * @param array    $source
     * @param int|null $depth         再起回数の指定
     * @param bool     $preserve_keys true:キーを維持する、キーが重複する場合は後勝ちする
     * @return array
     */
    public static function flatten(array $source, int|null $depth = null, bool $preserve_keys = false): array
    {
        return Flattener::flatten($source, $depth, $preserve_keys);
    }

    /**
     * キーを指定してグルーピングを行う
     * @param array           $source
     * @param callable|string $callable function($value, $key) or index key
     * @return array
     */
    public static function groupBy(array $source, callable|string $callable): array
    {
        return Grouper::groupBy($source, $callable);
    }
}
