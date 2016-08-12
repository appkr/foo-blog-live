<?php

function markdown($text)
{
    return (new Parsedown)->text($text);
}