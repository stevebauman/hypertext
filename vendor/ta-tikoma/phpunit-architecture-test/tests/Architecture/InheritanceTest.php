<?php

declare(strict_types=1);

namespace tests\Architecture;

use PHPUnit\Architecture\Elements\ObjectDescription;
use tests\TestCase;

final class InheritanceTest extends TestCase
{
    public function test_layer_essence(): void
    {
        $tests = $this->layer()->leaveByNameStart('tests\\Architecture');

        $this->assertEach(
            $tests,
            fn (ObjectDescription $objectDescription) => $objectDescription->extendsClass === TestCase::class,
            fn (string|int $key, ObjectDescription $objectDescription) => "Test {$objectDescription->name} does not extends TestCase::class"
        );
    }
}
