<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Collection;

/**
 * コレクションメソッド(値の取り出し)
 */
class PropertyValue
{
    /**
     * 配列かオブジェクトで取得方法を変えて、プロパティの値を取得する
     * @param array|object $data
     * @param string|int   $property
     * @return mixed
     */
    public static function value($data, $property): mixed
    {
        return (is_array($data) === true ? $data[$property] : $data->$property);
    }

    /**
     * 値かcallableで遅延実行した値を取得する
     * @param string|int|callable|null $expr 値かcallableで遅延実行
     * @param array|object             $data callable が参照で書き換えた値を呼び出し元に返せるように参照で受ける
     * @return mixed
     */
    public static function lazy($expr, &$data): mixed
    {
        return (is_callable($expr) === true ? $expr($data) : $expr);
    }
}
