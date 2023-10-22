<h1 align="center">Hypertext</h1>

<p align="center">
A PHP HTML to pure text transformer that beautifully handles various and malformed HTML.
</p>

<p align="center">
<a href="https://github.com/stevebauman/hypertext/actions" target="_blank">
<img src="https://img.shields.io/github/actions/workflow/status/stevebauman/hypertext/run-tests.yml?branch=master&style=flat-square"/>
</a>

<a href="https://packagist.org/packages/stevebauman/hypertext" target="_blank">
<img src="https://img.shields.io/packagist/v/stevebauman/hypertext.svg?style=flat-square"/>
</a>

<a href="https://packagist.org/packages/stevebauman/hypertext" target="_blank">
<img src="https://img.shields.io/packagist/dt/stevebauman/hypertext.svg?style=flat-square"/>
</a>

<a href="https://packagist.org/packages/stevebauman/hypertext" target="_blank">
<img src="https://img.shields.io/packagist/l/stevebauman/hypertext.svg?style=flat-square"/>
</a>

---

## Installation

```bash
composer require stevebauman/hypertext
```

## Usage

```php
use Stevebauman\Hypertext\Transformer;

$transformer = new Transformer();

// (Optional) Retain new line characters.
$transformer->keepNewLines();

// (Optional) Retain anchor tags and their href attribute.
$transformer->keepLinks();

$text = $transformer->toText($html);
```
