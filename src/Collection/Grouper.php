<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(グルーピング系)
 */
class Grouper
{
    /**
     * キーを指定してグルーピングを行う
     * @param array           $source
     * @param callable|string $callable function($value, $key) or index key
     * @return array
     */
    public static function groupBy(array $source, callable|string $callable): array
    {
        $results = [];
        foreach ($source as $ky => $vl)
        {
            $results[static::indexKey($vl, $ky, $callable)][] = $vl;
        }
        return $results;
    }

    /**
     * グルーピングのキーを取得する
     * @param mixed           $vl       callable が参照で書き換えた値を積めるように参照で受ける
     * @param string|int      $ky
     * @param callable|string $callable function($value, $key) or index key
     * @return mixed
     */
    public static function indexKey(mixed &$vl, string|int $ky, callable|string $callable): mixed
    {
        // 関数の場合は関数実行
        if (is_callable($callable))
        {
            return $callable($vl, $ky);
        }
        // 文字列の場合、配列は添え字から、オブジェクトはアロー指定で取得
        return (is_array($vl) ? $vl[$callable] : (is_object($vl) ? $vl->$callable : null));
    }
}
