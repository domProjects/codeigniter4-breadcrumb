<?php

/**
 * This file is part of domprojects/codeigniter4-breadcrumb.
 *
 * (c) domProjects
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace domProjects\CodeIgniterBreadcrumb\Traits;

use domProjects\CodeIgniterBreadcrumb\Config\Breadcrumb as BreadcrumbConfig;

trait HasBreadcrumb
{
    /**
     * @var array<string, list<array{label: string, url: string|null}>>
     */
    protected array $breadcrumb = [
        'root'       => [],
        'controller' => [],
        'function'   => [],
    ];

    protected ?string $breadcrumbLocale = null;

    protected function resetBreadcrumb(): self
    {
        $this->breadcrumb = [
            'root'       => [],
            'controller' => [],
            'function'   => [],
        ];

        return $this;
    }

    protected function setBreadcrumbLocale(string $locale): self
    {
        $this->breadcrumbLocale = $locale;

        return $this;
    }

    protected function breadcrumbRoot(string $label, ?string $url = null): self
    {
        $this->breadcrumb['root'] = [
            [
                'label' => $label,
                'url'   => $url,
            ],
        ];

        return $this;
    }

    /**
     * @param array<int|string, mixed> $params
     */
    protected function breadcrumbController(string $label, string $routeName, array $params = []): self
    {
        $this->breadcrumb['controller'] = [
            [
                'label' => $label,
                'url'   => url_to($routeName, $this->getBreadcrumbLocale(), ...$params),
            ],
        ];

        return $this;
    }

    /**
     * @param array<int|string, mixed> $params
     */
    protected function breadcrumbFunction(string $label, string $routeName, array $params = []): self
    {
        $this->breadcrumb['function'] = [
            [
                'label' => $label,
                'url'   => url_to($routeName, $this->getBreadcrumbLocale(), ...$params),
            ],
        ];

        return $this;
    }

    /**
     * @param array<int|string, mixed> $params
     */
    protected function breadcrumbAppend(string $label, ?string $routeName = null, array $params = []): self
    {
        $url = null;

        if ($routeName !== null && $routeName !== '') {
            $url = url_to($routeName, $this->getBreadcrumbLocale(), ...$params);
        }

        $this->breadcrumb['function'][] = [
            'label' => $label,
            'url'   => $url,
        ];

        return $this;
    }

    /**
     * @param array<string, string>|null $template
     */
    protected function renderBreadcrumb(?array $template = null): string
    {
        $items = array_merge(
            $this->breadcrumb['root'] ?? [],
            $this->breadcrumb['controller'] ?? [],
            $this->breadcrumb['function'] ?? [],
        );

        if ($items === []) {
            return '';
        }

        $breadcrumb = single_service('breadcrumb', $template ?? []);
        $breadcrumb->addMany($items);

        return $breadcrumb->render();
    }

    /**
     * @return array<string, string>
     */
    protected function getBreadcrumbTemplate(?string $templateName = null): array
    {
        $config = config(BreadcrumbConfig::class);
        $templateName ??= $config->defaultTemplate;

        return $config->templates[$templateName]
            ?? $config->templates[$config->defaultTemplate]
            ?? [];
    }

    protected function getBreadcrumbLocale(): string
    {
        if ($this->breadcrumbLocale !== null && $this->breadcrumbLocale !== '') {
            return $this->breadcrumbLocale;
        }

        return service('request')->getLocale();
    }
}
