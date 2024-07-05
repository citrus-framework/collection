<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(判定系)
 */
class JudgeMentor
{
    /**
     * 要素が空である
     *
     * @param array         $source
     * @param callable|null $callable function($value, $key)
     * @return bool
     */
    public static function isEmpty(array $source, callable|null $callable): bool
    {
        return 0 === Measurer::count($source, $callable);
    }

    /**
     * 要素が空ではない
     *
     * @param array         $source
     * @param callable|null $callable function($value, $key)
     * @return bool
     */
    public static function isNotEmpty(array $source, callable|null $callable): bool
    {
        return 0 !== Measurer::count($source, $callable);
    }
}
