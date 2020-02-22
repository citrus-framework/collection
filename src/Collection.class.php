<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus;

use Citrus\Collection\Filter;
use Citrus\Collection\Generator;
use Citrus\Collection\Register;
use Citrus\Collection\Scanner;

/**
 * コレクションクラス
 */
class Collection
{
    /** @var iterable データソース */
    protected $source;



    /**
     * constructor.
     *
     * @param array $source
     */
    public function __construct(array $source)
    {
        $this->source = $source;
    }



    /**************************************************************************
     * Register
     **************************************************************************/

    /**
     * callable関数がnull以外の値を返した場合、値を積んで返却する
     *
     * @param callable $callable
     * @return self
     */
    public function append(callable $callable): self
    {
        $this->source = Register::append($this->source, $callable);
        return $this;
    }



    /**************************************************************************
     * Scanner
     **************************************************************************/

    /**
     * callable関数を適用した内容を積んで返却する
     *
     * @param callable $callable
     * @return self
     */
    public function map(callable $callable): self
    {
        $this->source = Scanner::map($this->source, $callable);
        return $this;
    }



    /**************************************************************************
     * Filter
     **************************************************************************/

    /**
     * callable関数の返却値がtrueの場合に積んで返却する
     *
     * @param callable $callable
     * @return self
     */
    public function filter(callable $callable): self
    {
        $this->source = Filter::filter($this->source, $callable);
        return $this;
    }



    /**
     * callable関数がの返却値がtrueの場合に削除して返却する
     *
     * @param callable $callable
     * @return self
     */
    public function remove(callable $callable): self
    {
        // false の場合に残せば良いので filter の逆
        return $this->filter(function ($vl, $ky) use ($callable) {
            return (false === $callable($vl, $ky));
        });
    }



    /**************************************************************************
     * Generator
     **************************************************************************/

    /**
     * 配列設定して、コレクションを生成
     *
     * @param array $source
     * @return self
     */
    public static function stream(array $source): self
    {
        return Generator::stream($source);
    }



    /**
     * 指定した範囲でcallable関数を実行し、コレクションを生成
     *
     * @param int      $start    開始
     * @param int      $end      終了
     * @param callable $callable
     * @return self
     */
    public static function range(int $start, int $end, callable $callable): self
    {
        return Generator::range($start, $end, $callable);
    }



    /**
     * 指定した回数でcallable関数を実行し、コレクションを生成
     *
     * @param int      $count    回数
     * @param callable $callable
     * @return self
     */
    public static function repeat(int $count, callable $callable): self
    {
        // 範囲は1から$count
        return Generator::range(1, $count, $callable);
    }



    /**
     * 両方の要素を残したいい感じの配列マージ
     *
     * 同じ要素がある場合はあとが優先
     *
     * @param array $values
     * @return self
     */
    public function betterMerge(array $values): self
    {
        $this->source = Generator::betterMergeRecursive($this->source, $values);
        return $this;
    }



    /**************************************************************************
     * Exporter
     **************************************************************************/

    /**
     * 出力
     *
     * @return array
     */
    public function toList(): array
    {
        return $this->source;
    }



    /**
     * 出力(値だけ)
     *
     * @return array
     */
    public function toValues(): array
    {
        return array_values($this->source);
    }



    /**
     * 出力(キーだけ)
     *
     * @return array
     */
    public function toKeys(): array
    {
        return array_keys($this->source);
    }
}
