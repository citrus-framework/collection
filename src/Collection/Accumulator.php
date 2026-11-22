<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(蓄積系)
 */
class Accumulator
{
    /**
     * 要素を積む
     * @param array $results       積み先(参照)
     * @param array $items         積む要素
     * @param bool  $preserve_keys true:キーを維持する、キーが重複する場合は後勝ちする
     * @return void
     */
    public static function push(array &$results, array $items, bool $preserve_keys): void
    {
        foreach ($items as $ky => $vl)
        {
            // キー維持
            if ($preserve_keys === true)
            {
                $results[$ky] = $vl;
            }
            else
            {
                $results[] = $vl;
            }
        }
    }
}
