<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_two_values_are_same(): void
    {
        $this->assertSame(1, 1);
    }

    public function test_two_negative_values_are_same(): void
    {
        $this->assertSame(-1, -1);
    }
}
