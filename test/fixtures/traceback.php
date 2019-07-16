<?php
use Loilo\Traceback\Traceback;

// Direct traceback() call
function traceback()
{
    return [
        Traceback::file(),
        Traceback::dir()
    ];
}

// Direct traceback() call with 1 file offset
function traceback_offset_one()
{
    return [
        Traceback::file(1),
        Traceback::dir(1)
    ];
}

// Direct traceback() call with infinite files offset
function traceback_offset_infinite()
{
    return [
        Traceback::file(INF),
        Traceback::dir(INF)
    ];
}

// Inline indirect traceback() call
function traceback_indirection($callback)
{
    return $callback();
}
