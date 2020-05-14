# MySQL FullText Search Trait
PHP Trait to implement MySQL FullText Search in Eloquent Models

## Installation & Usage

First, pull in the package through Composer.

Run `composer require hepplerdotnet/fulltextsearch`

And then include the Trait within your Eloquent Model to implement FullTextSearch
.

```php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HepplerDotNet\FullTextSearch\FullTextSearch;

class FooBar extends Model
{
    use FullTextSearch;
    /* Table Fields which should be searchable */
    protected $searchable = [
        'title',
        'description'
    ];
    ...
 }
```

Create a fulltext index in MySQL for the fields.

Use it as scope on your Model

```php
$result = FooBar::search('Foo')->get();
```

