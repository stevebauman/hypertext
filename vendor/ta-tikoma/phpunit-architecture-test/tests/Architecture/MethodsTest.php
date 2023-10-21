<?php

declare(strict_types=1);

namespace tests\Architecture;

use PHPUnit\Architecture\Elements\Layer\Layer;
use PHPUnit\Architecture\Enums\ObjectType;
use tests\TestCase;

final class MethodsTest extends TestCase
{
    public function test_layer_method_incoming_arguments_not_from(): void
    {
        $tests = $this->layer()->leaveByNameStart('tests');
        $filters = $this->layer()->leaveByNameStart('PHPUnit\\Architecture\\Filters');

        $this->assertIncomingsNotFrom($filters, $tests);
    }

    public function test_layer_method_incoming_arguments_from(): void
    {
        $assertMethods = $this->layer()
            ->leaveByNameStart('PHPUnit\\Architecture\\Asserts')
            ->leaveByType(ObjectType::_TRAIT);

        $layerClass = $this->layer()
            ->leaveByNameStart(Layer::class)
            ->leaveByType(ObjectType::_CLASS);

        $this->assertIncomingsFrom($assertMethods, $layerClass);
    }

    public function test_layer_method_size(): void
    {
        $filters = $this->layer()->leaveByNameStart('PHPUnit\\Architecture\\Filters');

        $this->assertMethodSizeLessThan($filters, 20);
    }

    /**
     * @param $parameter
     * @phpstan-ignore-next-line
     */
    public function fakeDocBlockWithoutType($parameter)
    {
        //this fake method with a non-typed docblock will trigger an error to reproduce the issue solved by https://github.com/ta-tikoma/phpunit-architecture-test/pull/8
    }
}
