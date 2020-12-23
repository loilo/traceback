<?php
declare(strict_types=1);

namespace Loilo\Traceback\Test;

use PHPUnit\Framework\TestCase;
use Webmozart\PathUtil\Path;
use RuntimeException;

require_once __DIR__ . '/fixtures/traceback.php';

final class TracebackTest extends TestCase
{
    protected function resolve(...$parts)
    {
        return Path::canonicalize(Path::join(__DIR__, ...$parts));
    }

    public function testDirectTraceback(): void
    {
        $this->assertEquals(
            [__FILE__, __DIR__],
            traceback()
        );
    }

    public function testInlineIndirectTraceback(): void
    {
        $this->assertEquals(
            [__FILE__, __DIR__],
            traceback_indirection('traceback')
        );
    }

    public function testIndirectTraceback(): void
    {
        $caller = require __DIR__ . '/fixtures/caller.php';

        $this->assertEquals(
            [
                $this->resolve('fixtures/caller.php'),
                $this->resolve('fixtures')
            ],
            str_replace('\\', '/', $caller)
        );
    }

    public function testOffsetOneTraceback(): void
    {
        $this->assertEquals(
            [
                __FILE__,
                __DIR__
            ],
            require __DIR__ . '/fixtures/caller-offset-one.php'
        );
    }

    public function testOffsetInfiniteTraceback(): void
    {
        $this->expectException(RuntimeException::class);

        require __DIR__ . '/fixtures/caller-offset-infinite.php';
    }
}
