# Hypertext

A PHP HTML to pure text transformer.

## Installation

```bash
composer require stevebauman/hypertext
```

## Usage

```php
use Stevebauman\Hypertext\Transformer;

$transformer = new Transformer();

// (Optional) Retrieve pure text from the HTML document trimming all spacing.
$transformer->keepNewLines();

// (Optional) Retrieve text from the HTML document retaining anchor tags and their href attribute.
$transformer->keepLinks();

$text = $transformer->toText($html);
```
