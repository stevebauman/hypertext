<?php

use Stevebauman\Hypertext\Hyper;

it('foo', function () {
    $html = file_get_contents(__DIR__.'/../stubs/email.txt');

    ray(Hyper::toText($html));
});
