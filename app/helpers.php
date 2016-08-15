<?php

/**
 * 마크다운 문자열을 HTML로 컴파일한다.
 *
 * @param string $text
 * @return string
 */
function markdown($text)
{
    return (new Parsedown)->text($text);
}

/**
 * 컬렉션에 주어진 키의 포함 여부를 확인한다.
 *
 * @param \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection $collection
 * @param int $search
 * @return boolean
 */
function collection_contains($collection, $search)
{
    return $collection->contains($search);
}