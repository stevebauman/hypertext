<?php

declare(strict_types=1);

namespace PHPUnit\Architecture\Services;

use phpDocumentor\Reflection\DocBlockFactory;
use PHPUnit\Architecture\Elements\ObjectDescription;
use PHPUnit\Architecture\Storage\Filesystem;
use Symfony\Component\Finder\Finder;
use PhpParser\Parser;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use PhpParser\NodeFinder;

/**
 * For redefined to make extension
 */
final class ServiceContainer
{
    public static Finder $finder;

    public static string $descriptionClass = ObjectDescription::class;

    public static DocBlockFactory $docBlockFactory;

    public static Parser $parser;

    public static NodeTraverser $nodeTraverser;

    public static NodeFinder $nodeFinder;

    public static bool $showException = false;

    public static function init(): void
    {
        self::$finder = Finder::create()
            ->files()
            ->followLinks()
            ->exclude('vendor')
            ->name('/\.php$/')
            ->in(Filesystem::getBaseDir());

        self::$parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

        self::$nodeTraverser = new NodeTraverser();
        self::$nodeTraverser->addVisitor(new NameResolver());

        self::$nodeFinder = new NodeFinder();

        self::$docBlockFactory = DocBlockFactory::createInstance();
    }
}
