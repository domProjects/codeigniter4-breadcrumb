<?php

/**
 * This file is part of domprojects/codeigniter4-breadcrumb.
 *
 * (c) domProjects
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace domProjects\CodeIgniterBreadcrumb\Config;

use CodeIgniter\Config\BaseService;
use domProjects\CodeIgniterBreadcrumb\Breadcrumb;

class Services extends BaseService
{
    /**
     * Returns a breadcrumb instance.
     *
     * Breadcrumb is mutable, so shared instances are disabled by default.
     *
     * @param array<string, string> $template
     */
    public static function breadcrumb(array $template = [], bool $getShared = false): Breadcrumb
    {
        if ($getShared) {
            return static::getSharedInstance('breadcrumb', $template);
        }

        return new Breadcrumb($template);
    }
}
