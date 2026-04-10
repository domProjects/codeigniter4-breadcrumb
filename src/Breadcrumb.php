<?php

/**
 * This file is part of domprojects/codeigniter4-breadcrumb.
 *
 * (c) domProjects
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace domProjects\CodeIgniterBreadcrumb;

class Breadcrumb
{
    public const VERSION = '1.0.1';

    /**
     * @var list<array{label: string, url: string|null}>
     */
    protected array $items = [];

    protected string $newline = "\n";

    /**
     * @param array<string, string> $template
     */
    public function __construct(protected array $template = [])
    {
        helper(['url', 'html']);
    }

    /**
     * @param array<string, string> $template
     */
    public function setTemplate(array $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function add(string $label, ?string $url = null): self
    {
        $label = trim($label);

        if ($label === '') {
            return $this;
        }

        $this->items[] = [
            'label' => $label,
            'url'   => $url !== null && $url !== '' ? $url : null,
        ];

        return $this;
    }

    /**
     * @param array<int|string, mixed> $items
     */
    public function addMany(array $items): self
    {
        foreach ($items as $key => $value) {
            if (is_array($value) && isset($value['label'])) {
                $this->add(
                    (string) $value['label'],
                    isset($value['url']) ? (string) $value['url'] : null,
                );

                continue;
            }

            if (is_string($key) && ! is_array($value)) {
                $this->add($key, (string) $value);
            }
        }

        return $this;
    }

    /**
     * @return list<array{label: string, url: string|null}>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function clear(): self
    {
        $this->items = [];

        return $this;
    }

    public function render(): string
    {
        if ($this->items === []) {
            return '';
        }

        $template = $this->resolveTemplate();
        $output   = $template['tag_open'] . $this->newline;
        $last     = array_key_last($this->items);

        foreach ($this->items as $index => $item) {
            $label = esc($item['label']);
            $url   = $item['url'];

            if ($index === $last || $url === null) {
                $output .= $template['crumb_active']
                    . $label
                    . $template['crumb_close']
                    . $this->newline;

                continue;
            }

            $output .= $template['crumb_open']
                . anchor($url, $label)
                . $template['crumb_close']
                . $this->newline;
        }

        return $output . ($template['tag_close'] . $this->newline);
    }

    /**
     * @return array<string, string>
     */
    protected function resolveTemplate(): array
    {
        $template = $this->template;

        foreach ($this->defaultTemplate() as $key => $value) {
            if (! isset($template[$key])) {
                $template[$key] = $value;
            }
        }

        return $template;
    }

    /**
     * @return array<string, string>
     */
    protected function defaultTemplate(): array
    {
        return [
            'tag_open'     => '<ol>',
            'tag_close'    => '</ol>',
            'crumb_open'   => '<li>',
            'crumb_close'  => '</li>',
            'crumb_active' => '<li class="active" aria-current="page">',
        ];
    }
}
