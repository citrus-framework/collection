<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(計測系)
 */
class Measurer
{
    /**
     * 要素数
     *
     * @param array         $source
     * @param callable|null $callable function($value, $key)
     * @return int
     */
    public static function count(array $source, callable|null $callable = null): int
    {
        if (false === is_null($callable))
        {
            return count(Filter::filter($source, $callable));
        }

        return count($source);
    }
}
