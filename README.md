# Breadcrumb for CodeIgniter 4

Breadcrumb builder and controller integration for CodeIgniter 4 projects.

## Features

- Reusable breadcrumb builder service
- Ordered breadcrumb items with a single active item
- Named templates for different application areas
- Optional trait for controller integration
- Compatible with CodeIgniter 4.7.2+

## Installation

Install the package with Composer:

```bash
composer require domprojects/codeigniter4-breadcrumb
```

## Basic Usage

Create and render a breadcrumb manually:

```php
<?php

$breadcrumb = single_service('breadcrumb');

$breadcrumb
    ->add('Home', url_to('home'))
    ->add('Blog', url_to('blog.index'))
    ->add('Article');

echo $breadcrumb->render();
```

## Controller Integration

The package includes a `HasBreadcrumb` trait to simplify breadcrumb handling in controllers.

```php
<?php

namespace App\Controllers;

use domProjects\CodeIgniterBreadcrumb\Traits\HasBreadcrumb;
use CodeIgniter\Controller;

abstract class BaseController extends Controller
{
    use HasBreadcrumb;
}
```

Example in a controller:

```php
<?php

$this
    ->breadcrumbRoot('Home', url_to('home'))
    ->breadcrumbController('Blog', 'blog.index')
    ->breadcrumbAppend('Article');

$data['breadcrumb'] = $this->renderBreadcrumb();
```

## Templates

Default config ships with three template names:

- `default`
- `frontend`
- `backend`

Get a configured template in a controller:

```php
<?php

$data['breadcrumb'] = $this->renderBreadcrumb(
    $this->getBreadcrumbTemplate('backend')
);
```

## Package Structure

```text
src/
  Breadcrumb.php
  Config/
    Breadcrumb.php
    Services.php
  Traits/
    HasBreadcrumb.php
```

## License

MIT
