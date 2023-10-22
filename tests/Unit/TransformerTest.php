<?php

use Stevebauman\Hypertext\Transformer;

function fixture(string $path): string
{
    return __DIR__ . "/../Fixtures/$path";
}

it('transforms html to text', function (string $inputFile, string $outputFile, Closure $callback = null) {
    $input = file_get_contents(fixture($inputFile));
    $output = file_get_contents(fixture($outputFile));

    $transformer = new Transformer();

    if ($callback) {
        $callback($transformer);
    }

    expect($transformer->toText($input))->toEqual($output);
})->with([
    [
        'email/input.txt',
        'email/output.txt',
    ],
    [
        'email/input.txt',
        'email/output-links.txt',
        fn (Transformer $transformer) => $transformer->keepLinks(),
    ],
    [
        'email/input.txt',
        'email/output-lines.txt',
        fn (Transformer $transformer) => $transformer->keepNewLines(),
    ],
    [
        'email/input.txt',
        'email/output-both.txt',
        fn (Transformer $transformer) => $transformer->keepLinks()->keepNewLines(),
    ],

    [
        'website/input.txt',
        'website/output.txt',
    ],
    [
        'website/input.txt',
        'website/output-links.txt',
        fn (Transformer $transformer) => $transformer->keepLinks(),
    ],
    [
        'website/input.txt',
        'website/output-lines.txt',
        fn (Transformer $transformer) => $transformer->keepNewLines(),
    ],
    [
        'website/input.txt',
        'website/output-both.txt',
        fn (Transformer $transformer) => $transformer->keepLinks()->keepNewLines(),
    ],
    [
        'html2text/huge-msoffice/input.txt',
        'html2text/huge-msoffice/output.txt',
    ],
    [
        'html2text/huge-msoffice/input.txt',
        'html2text/huge-msoffice/output-lines.txt',
        fn (Transformer $transformer) => $transformer->keepNewLines(),
    ],
]);
