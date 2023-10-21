<?php

namespace Stevebauman\Hypertext;

use Closure;
use HTMLPurifier;
use HTMLPurifier_Config;

class Hyper
{
    /**
     * The HTML purifier configuration.
     */
    public static array $config = [
        'HTML.Allowed' => '',
        'Core.Encoding' => 'utf-8',
        'CSS.AllowedProperties' => '',
        'AutoFormat.RemoveEmpty' => true,
        'AutoFormat.AutoParagraph' => true,
        'HTML.Doctype' => 'HTML 4.01 Transitional',
    ];

    /**
     * The various unicode spaces to replace with single spaces.
     */
    public static array $spaces = [
        "\u{00AD}", // Soft Hyphen
        "\u{200B}", // Zero Width Space
        "\u{200C}", // Zero Width Non-Joiner
        "\u{200D}", // Zero Width Joiner
        "\u{200E}", // Left-To-Right Mark
        "\u{200F}", // Right-To-Left Mark
        "\u{FEFF}", // Zero Width No-Break Space (Byte Order Mark)
        "\u{2060}", // Word Joiner
        "\u{2002}", // En Space
        "\u{2003}", // Em Space
        "\u{2004}", // Three-Per-Em Space
        "\u{2005}", // Four-Per-Em Space
        "\u{2006}", // Six-Per-Em Space
        "\u{2007}", // Figure Space
        "\u{2008}", // Punctuation Space
        "\u{2009}", // Thin Space
        "\u{200A}", // Hair Space
        "\u{00A0}", // Non-breaking Space
        "\u{202F}", // Narrow No-Break Space
        "\u{205F}", // Medium Mathematical Space
        "\u{3000}", // Ideographic Space
        "\u{034F}", // Combining Grapheme Joiner (CGJ)
    ];

    /**
     * Transform the HTML into pure text.
     */
    public static function toText(string $html): string
    {
        return array_reduce(static::pipeline(), fn (string $html, Closure $transformer) => (
            $transformer($html)
        ), $html);
    }

    /**
     * Get the HTML to text pipeline.
     */
    protected static function pipeline(): array
    {
        return [
            // Decode any HTML
            fn (string $text) => quoted_printable_decode($text),

            // Add spacing around HTML tags
            fn (string $text) => preg_replace('/(>)(<)/', '$1 $2', $text),

            // Strip all HTML and CSS
            fn (string $text) => static::makePurifier()->purify($text),

            // Remove all excess spacing (squish)
            fn (string $text) => preg_replace('~(\s|\x{3164}|\x{1160})+~u', ' ', preg_replace('~^[\s\x{FEFF}]+|[\s\x{FEFF}]+$~u', '', $text))
        ];
    }

    /**
     * make a new HTML Purifier instance.
     */
    protected static function makePurifier(): HTMLPurifier
    {
        return new HTMLPurifier(static::makePurifierConfig());
    }

    /**
     * Create a new HTML Purifier config.
     */
    protected static function makePurifierConfig(): HTMLPurifier_Config
    {
        return HTMLPurifier_Config::create(static::$config);
    }
}
