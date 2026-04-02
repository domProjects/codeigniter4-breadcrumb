<?php

namespace domProjects\CodeIgniterBreadcrumb\Config;

use CodeIgniter\Config\BaseConfig;

class Breadcrumb extends BaseConfig
{
    public string $defaultTemplate = 'default';
    public string $frontendTemplate = 'frontend';
    public string $backendTemplate = 'backend';

    /**
     * @var array<string, array<string, string>>
     */
    public array $templates = [
        'default' => [
            'tag_open'     => '<ol class="breadcrumb">',
            'tag_close'    => '</ol>',
            'crumb_open'   => '<li class="breadcrumb-item">',
            'crumb_close'  => '</li>',
            'crumb_active' => '<li class="breadcrumb-item active" aria-current="page">',
        ],
        'frontend' => [
            'tag_open'     => '<ol class="breadcrumb">',
            'tag_close'    => '</ol>',
            'crumb_open'   => '<li class="breadcrumb-item">',
            'crumb_close'  => '</li>',
            'crumb_active' => '<li class="breadcrumb-item active" aria-current="page">',
        ],
        'backend' => [
            'tag_open'     => '<ol class="breadcrumb d-flex align-items-center">',
            'tag_close'    => '</ol>',
            'crumb_open'   => '<li class="breadcrumb-item">',
            'crumb_close'  => '</li>',
            'crumb_active' => '<li class="breadcrumb-item active" aria-current="page">',
        ],
    ];
}
