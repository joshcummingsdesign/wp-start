<?php

declare(strict_types=1);

namespace Tests\Unit\Auth\Actions;

use PHPUnit\Framework\MockObject\MockBuilder;
use WPStart\Auth\Actions\AddCheckForE2EAuthCookie;
use WPStart\Helpers\Support\Facades\Cookie\CookieFacade;
use Tests\TestCase;

/**
 * Test the AddCheckForE2EAuthCookieTest action.
 */
final class AddCheckForE2EAuthCookieTest extends TestCase
{
    private string $constantName = 'E2E_AUTH_KEY';
    private string $cookieName = 'e2e_auth_key';
    private string $authKey = 'abc123';

    public function testShouldReturnIfConstantNotSet(): void
    {
        $this->mock(AddCheckForE2EAuthCookie::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['sendRestrictedAccessHtml'])->getMock();

            $mock->expects($this->never())
                ->method('sendRestrictedAccessHtml');

            return $mock;
        });

        (new AddCheckForE2EAuthCookie())();
    }

    public function testShouldReturnIfCookieSet(): void
    {
        $this->mock(CookieFacade::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['get'])->getMock();

            $mock->expects($this->once())
                ->method('get')
                ->with($this->cookieName)
                ->willReturn($this->authKey);

            return $mock;
        });

        $action = $this->mock(AddCheckForE2EAuthCookie::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['sendRestrictedAccessHtml'])->getMock();

            $mock->expects($this->never())
                ->method('sendRestrictedAccessHtml');

            return $mock;
        });

        if ( ! defined($this->constantName)) {
            define($this->constantName, $this->authKey);
        }

        $action->__invoke();
    }

    public function testShouldRestrictAccess(): void
    {
        $action = $this->mock(AddCheckForE2EAuthCookie::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['sendRestrictedAccessHtml'])->getMock();

            $mock->expects($this->once())
                ->method('sendRestrictedAccessHtml');

            return $mock;
        });

        if ( ! defined($this->constantName)) {
            define($this->constantName, $this->authKey);
        }

        $action->__invoke();
    }
}
