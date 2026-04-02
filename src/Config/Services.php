<?php

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
