<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(比較系)
 */
class Comparator
{
    /**
     * 昇順なら1、それ以外なら-1
     * @param bool $ascending true:昇順,false:降順
     * @return int
     */
    public static function direction($ascending): int
    {
        return ($ascending === true ? 1 : -1);
    }

    /**
     * プロパティを指定して比較する
     * @param array|object $data1
     * @param array|object $data2
     * @param string       $property
     * @param bool         $ascending true:昇順,false:降順
     * @return int
     */
    public static function byProperty($data1, $data2, string $property, bool $ascending): int
    {
        $value1 = PropertyValue::value($data1, $property);
        $value2 = PropertyValue::value($data2, $property);
        // 降順の場合は-1を掛ける
        return ($value1 <=> $value2) * static::direction($ascending);
    }

    /**
     * プロパティを複数指定して比較する
     * @param array|object $data1
     * @param array|object $data2
     * @param array        $properties [[property => ascending], [property => ascending], ...]
     * @return int
     */
    public static function byProperties($data1, $data2, array $properties): int
    {
        foreach ($properties as $property => $ascending)
        {
            $compare = (PropertyValue::value($data1, $property) <=> PropertyValue::value($data2, $property));
            // 比較して 0の場合はもう一周する
            if ($compare !== 0)
            {
                // 降順の場合は-1を掛ける
                return $compare * static::direction($ascending);
            }
        }
        return 0;
    }
}
