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
     *
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
     *
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
     *
     * @param array    $source
     * @param int|null $depth         再起回数の指定
     * @param bool     $preserve_keys true:キーを維持する、キーが重複する場合は後勝ちする
     * @return array
     */
    public static function flatten(array $source, int $depth = null, bool $preserve_keys = false): array
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

    /**
     * キーを指定してグルーピングを行う
     *
     * @param array    $source
     * @param callable|string $callable function($value, $key) or index key
     * @return array
     */
    public static function groupBy(array $source, callable|string $callable): array
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            $indexKey = null;
            // 関数の場合は関数実行
            if (is_callable($callable))
            {
                $indexKey = $callable($vl, $ky);
            }
            // 文字列の場合
            else if (is_string($callable))
            {
                // 配列の場合は添え字から取得
                if (is_array($vl))
                {
                    $indexKey = $vl[$callable];
                }
                // オブジェクトの場合はアロー指定
                else if (is_object($vl))
                {
                    $indexKey = $vl->$callable;
                }
            }

            if (array_key_exists($indexKey, $results) === false)
            {
                $results[$indexKey] = [];
            }

            $results[$indexKey][] = $vl;
        }
        return $results;
    }
}
