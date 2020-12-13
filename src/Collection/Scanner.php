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
     * keyを指定する
     *
     * @param iterable $source
     * @param callable $callable function($key, $value)
     * @return iterable
     */
    public static function mapWithKey(iterable $source, callable $callable): iterable
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



    /**
     * 多次元コレクションを一次元にする
     *
     *
     * @param iterable $source
     * @param int|null $depth         再起回数の指定
     * @param bool     $preserve_keys true:キーを維持する、キーが重複する場合は後勝ちする
     * @return iterable
     */
    public static function flatten(iterable $source, int $depth = null, bool $preserve_keys = false): iterable
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            // 配列ではないので、そのまま追加
            if (false === is_array($vl))
            {
                // キー維持
                if (true === $preserve_keys)
                {
                    $results[$ky] = $vl;
                }
                else
                {
                    $results[] = $vl;
                }
            }
            else
            {
                $values = $vl;
                // 再起指定が0以外の場合は、指定数か無限に再起する
                if (0 !== $depth)
                {
                    $values = static::flatten($vl, (true === is_null($depth) ? null : $depth - 1), $preserve_keys);
                }

                foreach ($values as $vl_ky => $vl_vl)
                {
                    // キー維持
                    if (true === $preserve_keys)
                    {
                        $results[$vl_ky] = $vl_vl;
                    }
                    else
                    {
                        $results[] = $vl_vl;
                    }
                }
            }
        }
        return $results;
    }
}
