<?php

declare(strict_types=1);

namespace tests\Architecture;

use tests\TestCase;

final class LayersTest extends TestCase
{
    public function test_make_layers_and_assert_depends(): void
    {
        $layers = $this->layer()->splitByNameRegex('/^(?\'layer\'.*\\\\Architecture\\\\Builders\\\\[^\\\\]+)/m');

        $this->assertDoesNotDependOn($layers, $layers);
    }
}
