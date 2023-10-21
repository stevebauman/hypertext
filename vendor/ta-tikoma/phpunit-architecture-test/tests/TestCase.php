<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Architecture\ArchitectureAsserts;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use ArchitectureAsserts;
}
