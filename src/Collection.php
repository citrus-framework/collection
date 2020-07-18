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
     * @param iterable $source
     */
    public function __construct(iterable $source)
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
     * @return $this
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
     * @return $this
     */
    public function map(callable $callable): self
    {
        $this->source = Scanner::map($this->source, $callable);
        return $this;
    }



    /**
     * callable関数を適用した内容を積んで返却する
     * keyを指定する
     *
     * @param callable $callable
     * @return $this
     */
    public function mapWithKey(callable $callable): self
    {
        $this->source = Scanner::mapWithKey($this->source, $callable);
        return $this;
    }



    /**
     * callable関数を適用した内容を積んで返却する
     * keyを維持する
     *
     * @param callable $callable
     * @return $this
     */
    public function keyMap(callable $callable): self
    {
        $this->source = Scanner::keyMap($this->source, $callable);
        return $this;
    }



    /**************************************************************************
     * Filter
     **************************************************************************/

    /**
     * callable関数の返却値がtrueの場合に積んで返却する
     *
     * @param callable $callable
     * @return $this
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
     * @return $this
     */
    public function remove(callable $callable): self
    {
        // false の場合に残せば良いので filter の逆
        return $this->filter(function ($vl, $ky) use ($callable) {
            return (false === $callable($vl, $ky));
        });
    }



    /**
     * 値がnullではないものを返却する
     *
     * @return $this
     */
    public function notNull(): self
    {
        return $this->filter(function ($vl) {
            return (false === is_null($vl));
        });
    }



    /**************************************************************************
     * Generator
     **************************************************************************/

    /**
     * 配列設定して、コレクションを生成
     *
     * @param iterable $source
     * @return $this
     */
    public static function stream(iterable $source): self
    {
        return Generator::stream($source);
    }



    /**
     * 指定した範囲でcallable関数を実行し、コレクションを生成
     *
     * @param int      $start    開始
     * @param int      $end      終了
     * @param callable $callable
     * @return $this
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
     * @return $this
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
     * @param iterable $values
     * @return $this
     */
    public function betterMerge(iterable $values): self
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
     * @return iterable
     */
    public function toList(): iterable
    {
        return $this->source;
    }



    /**
     * 出力(値だけ)
     *
     * @return iterable
     */
    public function toValues(): iterable
    {
        return array_values($this->source);
    }



    /**
     * 出力(キーだけ)
     *
     * @return iterable
     */
    public function toKeys(): iterable
    {
        return array_keys($this->source);
    }
}
