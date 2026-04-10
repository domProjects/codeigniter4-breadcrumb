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

use CodeIgniter\Test\CIUnitTestCase;
use domProjects\CodeIgniterBreadcrumb\Breadcrumb;
use domProjects\CodeIgniterBreadcrumb\Config\Services;

/**
 * @internal
 */
final class BreadcrumbTest extends CIUnitTestCase
{
    public function testItRendersLinkedAndActiveItems(): void
    {
        $breadcrumb = new Breadcrumb();
        $html       = $breadcrumb
            ->add('Home', 'docs')
            ->add('Article')
            ->render();

        $this->assertStringContainsString('<ol>', $html);
        $this->assertStringContainsString('href="' . site_url('docs') . '"', $html);
        $this->assertStringContainsString('aria-current="page">Article</li>', $html);
    }

    public function testAddManyAcceptsBothListAndAssociativeFormats(): void
    {
        $breadcrumb = new Breadcrumb();

        $breadcrumb->addMany([
            [
                'label' => 'Home',
                'url'   => 'docs',
            ],
            'Article' => '',
            'Contact' => 'contact',
        ]);

        $items = $breadcrumb->getItems();

        $this->assertCount(3, $items);
        $this->assertSame('Home', $items[0]['label']);
        $this->assertSame('docs', $items[0]['url']);
        $this->assertNull($items[1]['url']);
        $this->assertSame('contact', $items[2]['url']);
    }

    public function testServiceReturnsFreshInstancesByDefault(): void
    {
        $first = Services::breadcrumb();
        $first->add('Home');

        $second = Services::breadcrumb();

        $this->assertNotSame($first, $second);
        $this->assertSame([], $second->getItems());
    }
}
