<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(フィルタ系)
 */
class Filter
{
    /**
     * callable関数の返却値がtrueの場合に積んで返却する
     * @param array         $source
     * @param callable|null $callable function($value, $key)
     * @return array
     */
    public static function filter(array $source, callable|null $callable = null): array
    {
        // 無ければそのまま返す
        if ($callable === null)
        {
            return $source;
        }

        return static::pick($source, $callable);
    }

    /**
     * 指定プロパティと引数値が一致した場合に積む
     * @param array                    $source   ソース
     * @param string                   $property プロパティ名称
     * @param string|int|callable|null $expr     値かcallableで遅延実行
     * @return array
     */
    public static function where(array $source, string $property, string|int|callable|null $expr): array
    {
        // 配列とオブジェクトの場合を振り分けて値を取得し、一致したら積む
        return static::pick(
            $source,
            static fn (&$vl) => PropertyValue::value($vl, $property) === PropertyValue::lazy($expr, $vl)
        );
    }

    /**
     * callable関数の返却値がtrueの場合に、キーを残したまま積んで返却する
     * callable が参照で受けて書き換えた値を積めるように、値は変数のまま渡す
     * @param array    $source
     * @param callable $callable function($value, $key)
     * @return array
     */
    public static function pick(array $source, callable $callable): array
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            if ($callable($vl, $ky) === true)
            {
                $results[$ky] = $vl;
            }
        }
        return $results;
    }
}
