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
     * イテレーター設定して、コレクションを生成
     *
     * @param iterable $source
     * @return Collection
     * @deprecated 後方互換のため
     */
    public static function stream(iterable $source): Collection
    {
        return self::fromArray(iterator_to_array($source));
    }

    /**
     * 配列設定して、コレクションを生成
     *
     * @param array $source
     * @return Collection
     */
    public static function fromArray(array $source): Collection
    {
        return new Collection($source);
    }

    /**
     * イテレーター設定して、コレクションを生成
     *
     * @param iterable $source
     * @return Collection
     */
    public static function fromIterator(iterable $source): Collection
    {
        return self::fromArray(iterator_to_array($source));
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
     * 同じ要素がある場合はあとが優先
     *
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function betterMergeRecursive(array $array1, array $array2): array
    {
        foreach ($array2 as $ky => $vl)
        {
            $array1[$ky] = (
                true === is_array($vl)
                ? self::betterMergeRecursive(($array1[$ky] ?? []), $array2[$ky]) // 配列の場合
                : $array2[$ky]                                                   // 配列以外の場合
            );
        }

        return $array1;
    }
}
