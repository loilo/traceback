<?php namespace Loilo\Traceback;

use UnexpectedValueException;
use RuntimeException;

class Traceback
{
    protected static function findTraceItem($skipFiles)
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        $previousFile = null;
        foreach ($trace as $item) {
            if (isset($item['file']) && $item['file'] === __FILE__) {
                continue;
            }

            if (isset($item['class']) && $item['class'] === static::class) {
                $previousFile = $item['file'];
                $skipFiles++;
                continue;
            }

            if ($previousFile !== $item['file']) {
                $previousFile = $item['file'];
                $skipFiles--;
            }

            if ($skipFiles > 0) {
                continue;
            }

            return $item;
        }

        throw new RuntimeException('Cannot trace back calls');
    }

    public static function file($skipFiles = 0)
    {
        $file = static::findTraceItem($skipFiles)['file'];

        if (is_file($file)) {
            return $file;
        } else {
            throw new UnexpectedValueException(sprintf(
                'Cannot find traced back file "%s"',
                $file
            ));
        }
    }

    public static function dir($skipFiles = 0)
    {
        $dir = dirname(static::findTraceItem($skipFiles)['file']);

        if (is_dir($dir)) {
            return $dir;
        } else {
            throw new UnexpectedValueException(sprintf(
                'Cannot find traced back directory "%s"',
                $dir
            ));
        }
    }
}
