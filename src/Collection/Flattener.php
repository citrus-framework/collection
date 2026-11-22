<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(平坦化系)
 */
class Flattener
{
    /**
     * 多次元コレクションを一次元にする
     * @param array    $source
     * @param int|null $depth         再起回数の指定
     * @param bool     $preserve_keys true:キーを維持する、キーが重複する場合は後勝ちする
     * @return array
     */
    public static function flatten(array $source, int|null $depth, bool $preserve_keys): array
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            // 配列ではない場合は、そのまま追加
            $items = (is_array($vl) === true ? static::expand($vl, $depth, $preserve_keys) : [$ky => $vl]);
            Accumulator::push($results, $items, $preserve_keys);
        }
        return $results;
    }

    /**
     * 配列の要素を展開する
     * @param array    $values
     * @param int|null $depth         再起回数の指定
     * @param bool     $preserve_keys true:キーを維持する、キーが重複する場合は後勝ちする
     * @return array
     */
    public static function expand(array $values, int|null $depth, bool $preserve_keys): array
    {
        // 再起指定が0以外の場合は、指定数か無限に再起する
        $next = ($depth === null ? null : $depth - 1);
        return ($depth !== 0 ? static::flatten($values, $next, $preserve_keys) : $values);
    }
}
