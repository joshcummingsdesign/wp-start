<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\MockObject\MockObject;
use WP_UnitTestCase;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The base test case class.
 *
 * All test cases should extend this class.
 *
 * @unreleased
 */
class TestCase extends WP_UnitTestCase
{
    /**
     * Returns a mock for the specified class.
     *
     * @unreleased
     *
     * @param string|string[] $originalClassName
     * @param ?callable       $builderCallable function (MockBuilder $builder) {}
     */
    protected function createMock($originalClassName, ?callable $builderCallable = null): MockObject
    {
        $mockBuilder = $this->getMockBuilder($originalClassName)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes();

        if ($builderCallable !== null) {
            $mock = $builderCallable($mockBuilder);

            if (is_object($mock)) {
                return $mock;
            }
        }

        return $mockBuilder->getMock();
    }

    /**
     * Sets a mock for the specified class in the service container and returns the mock.
     *
     * @unreleased
     *
     * @param ?callable $builderCallable function (MockBuilder $builder) {}
     */
    protected function mock(string $originalClassName, ?callable $builderCallable = null): MockObject
    {
        $mock = $this->createMock($originalClassName, $builderCallable);

        app()->set($originalClassName, fn() => $mock);

        return $mock;
    }
}
