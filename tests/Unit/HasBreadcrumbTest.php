<?php

declare(strict_types=1);

/**
 * This file is part of domprojects/codeigniter4-breadcrumb.
 *
 * (c) domProjects
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace domProjects\CodeIgniterBreadcrumb\Tests\Unit;

use Config\App;
use CodeIgniter\Test\CIUnitTestCase;
use domProjects\CodeIgniterBreadcrumb\Traits\HasBreadcrumb;

/**
 * @internal
 */
final class HasBreadcrumbTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $appConfig                   = config(App::class);
        $appConfig->supportedLocales = ['en', 'fr'];

        $routes = service('routes');
        $routes->get('breadcrumb-test/home', '\App\Controllers\Home::index', ['as' => 'breadcrumb.home']);
        $routes->get('{locale}/breadcrumb-test/home', '\App\Controllers\Home::index', ['as' => 'breadcrumb.home.localized']);
    }

    public function testItReturnsConfiguredBackendTemplate(): void
    {
        $controller = new BreadcrumbControllerDouble();
        $template   = $controller->template('backend');

        $this->assertSame('<ol class="breadcrumb d-flex align-items-center">', $template['tag_open']);
    }

    public function testItUsesRequestLocaleWhenNoExplicitLocaleIsSet(): void
    {
        $controller = new BreadcrumbControllerDouble();

        $this->assertSame(service('request')->getLocale(), $controller->locale());
    }

    public function testItRendersBreadcrumbMarkupFromTraitData(): void
    {
        $controller = new BreadcrumbControllerDouble();
        $html       = $controller
            ->root('Home', 'docs')
            ->append('Guide', 'breadcrumb.home')
            ->append('Article')
            ->render($controller->template('backend'));

        $this->assertStringContainsString('breadcrumb d-flex align-items-center', $html);
        $this->assertStringContainsString('href="' . site_url('docs') . '"', $html);
        $this->assertStringContainsString('aria-current="page">Article</li>', $html);
    }

    public function testItBuildsLocalizedUrlsWhenLocaleIsSpecified(): void
    {
        $controller = new BreadcrumbControllerDouble();
        $html       = $controller
            ->setLocale('fr')
            ->append('Accueil', 'breadcrumb.home.localized')
            ->append('Article')
            ->render();

        $this->assertStringContainsString('href="' . site_url('fr/breadcrumb-test/home') . '"', $html);
    }
}

final class BreadcrumbControllerDouble
{
    use HasBreadcrumb;

    /**
     * @param array<int|string, mixed> $params
     */
    public function append(string $label, ?string $routeName = null, array $params = []): self
    {
        return $this->breadcrumbAppend($label, $routeName, $params);
    }

    public function locale(): string
    {
        return $this->getBreadcrumbLocale();
    }

    /**
     * @param array<string, string>|null $template
     */
    public function render(?array $template = null): string
    {
        return $this->renderBreadcrumb($template);
    }

    public function root(string $label, ?string $url = null): self
    {
        return $this->breadcrumbRoot($label, $url);
    }

    public function setLocale(string $locale): self
    {
        return $this->setBreadcrumbLocale($locale);
    }

    /**
     * @return array<string, string>
     */
    public function template(?string $templateName = null): array
    {
        return $this->getBreadcrumbTemplate($templateName);
    }
}
