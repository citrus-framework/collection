<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

use Citrus\Collection;

/**
 * コレクションメソッド(生成系)
 */
class Generator
{
    /**
     * 配列設定して、コレクションを生成
     *
     * @param iterable $source
     * @return Collection
     */
    public static function stream(iterable $source): Collection
    {
        return new Collection($source);
    }



    /**
     * 指定した範囲でcallable関数を実行し、コレクションを生成
     *
     * @param int      $start    開始
     * @param int      $end      終了
     * @param callable $callable
     * @return Collection
     */
    public static function range(int $start, int $end, callable $callable): Collection
    {
        $results = [];
        for ($i = $start; $i <= $end; $i++)
        {
            $results[] = $callable($i);
        }
        return new Collection($results);
    }



    /**
     * 両方の要素を残したいい感じの配列マージ
     *
     * 同じ要素がある場合はあとが優先
     *
     * @param iterable $array1
     * @param iterable $array2
     * @return iterable
     */
    public static function betterMergeRecursive(iterable $array1, iterable $array2): iterable
    {
        foreach ($array2 as $ky => $vl)
        {
            $array1[$ky] = (true === is_array($vl)
                ? self::betterMergeRecursive(($array1[$ky] ?? []), $array2[$ky]) // 配列の場合
                : $array2[$ky]                                                   // 配列以外の場合
            );
        }

        return $array1;
    }
}
