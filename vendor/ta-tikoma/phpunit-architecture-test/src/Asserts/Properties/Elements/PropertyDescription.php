<?php

declare(strict_types=1);

namespace PHPUnit\Architecture\Asserts\Properties\Elements;

use Exception;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use PHPUnit\Architecture\Asserts\Properties\ObjectPropertiesDescription;
use PHPUnit\Architecture\Enums\Visibility;
use PHPUnit\Architecture\Services\ServiceContainer;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

final class PropertyDescription
{
    public string $name;

    /**
     * @var null|string|string[]
     */
    public $type;

    public Visibility $visibility;

    public static function make(
        ObjectPropertiesDescription $objectPropertiesDescription,
        ReflectionProperty $reflectionProperty
    ): self {
        $description = new static();
        $description->name = $reflectionProperty->getName();
        $description->type = self::getPropertyType($objectPropertiesDescription, $reflectionProperty);

        if ($reflectionProperty->isPrivate()) {
            $description->visibility = Visibility::PRIVATE;
        } elseif ($reflectionProperty->isProtected()) {
            $description->visibility = Visibility::PROTECTED;
        } else {
            $description->visibility = Visibility::PUBLIC;
        }

        return $description;
    }

    /**
     * @return string|string[]|null
     */
    private static function getPropertyType(
        ObjectPropertiesDescription $objectPropertiesDescription,
        ReflectionProperty $reflectionProperty
    ): string|array|null {
        $type = $reflectionProperty->getType();
        if ($type !== null) {
            if ($type instanceof ReflectionUnionType) {
                return array_map(static fn ($type) => $type->getName(), $type->getTypes());
            }

            if ($type instanceof ReflectionIntersectionType) {
                return null; // @todo
            }

            /** @var ReflectionNamedType $type */
            return $type->getName();
        }


        $docComment = $reflectionProperty->getDocComment();
        if (empty($docComment)) {
            return null;
        }

        try {
            $docBlock = ServiceContainer::$docBlockFactory->create($docComment);
        } catch (Exception $e) {
            if (ServiceContainer::$showException) {
                echo "Can't parse: '$docComment'";
            }
            return null;
        }

        /** @var Var_[] $tags */
        $tags = $docBlock->getTagsWithTypeByName('var');
        if ($tag = array_shift($tags)) {
            if (($type = $tag->getType()) === null) {
                return null;
            }

            return $objectPropertiesDescription->getDocBlockTypeWithNamespace($type);
        }

        return null;
    }


    public function __toString()
    {
        return $this->name;
    }
}
