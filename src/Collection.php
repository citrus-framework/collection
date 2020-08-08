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
use Citrus\Collection\Sorter;

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



    /**
     * 値がnullではないものを返却する
     *
     * @param string              $property キー名称
     * @param string|int|callable $expr     値かcallableで遅延実行
     * @return $this
     */
    public function where(string $property, $expr): self
    {
        $this->source = Filter::where($this->source, $property, $expr);
        return $this;
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
     * Sorter
     **************************************************************************/

    /**
     * callable関数を利用してソートする
     *
     * callable関数は -1 or 0 or 1 を返却する
     *
     * @param callable $callable
     * @return $this
     */
    public function sortBy(callable $callable): self
    {
        $this->source = Sorter::sortBy($this->source, $callable);
        return $this;
    }



    /**
     * プロパティを指定してソートする
     *
     * @param string $property
     * @param bool   $ascending true:昇順,false:降順
     * @return $this
     */
    public function sortByProp(string $property, bool $ascending = true): self
    {
        $this->source = Sorter::sortBy($this->source, function ($data1, $data2) use ($property, $ascending) {
            // 配列かオブジェクトで取得方法を変える
            $value1 = (true === is_array($data1) ? $data1[$property] : $data1->$property);
            $value2 = (true === is_array($data2) ? $data2[$property] : $data2->$property);
            // 降順の場合は-1を掛ける
            return ($value1 <=> $value2) * (true === $ascending ? 1 : -1);
        });
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



    /**
     * 一件取得
     *
     * @return mixed|null
     */
    public function one()
    {
        foreach ($this->source as $one)
        {
            return $one;
        }
        return null;
    }
}
