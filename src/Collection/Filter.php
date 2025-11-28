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
     *
     * @param array         $source
     * @param callable|null $callable function($value, $key)
     * @return array
     */
    public static function filter(array $source, callable|null $callable = null): array
    {
        // 無ければそのまま返す
        if (is_null($callable))
        {
            return $source;
        }

        $results = [];
        foreach ($source as $ky => $vl)
        {
            if (true === $callable($vl, $ky))
            {
                $results[$ky] = $vl;
            }
        }
        return $results;
    }

    /**
     * 指定プロパティと引数値が一致した場合に積む
     *
     * @param array                    $source   ソース
     * @param string                   $property プロパティ名称
     * @param string|int|callable|null $expr     値かcallableで遅延実行
     * @return array
     */
    public static function where(array $source, string $property, string|int|callable|null $expr): array
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            // 配列とオブジェクトの場合を振り分けて値を取得
            $value = (true === is_array($vl) ? $vl[$property] : $vl->$property);
            // 一致したら積む
            $expr_value = (true === is_callable($expr) ? $expr($vl) : $expr);
            if ($value === $expr_value)
            {
                $results[$ky] = $vl;
            }
        }
        return $results;
    }
}
