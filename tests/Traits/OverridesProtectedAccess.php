<?php

namespace Shomisha\Cards\Tests\Traits;

trait OverridesProtectedAccess
{
    protected function setProtectedProperty($object, string $property, $value)
    {
        $objectReflection = new \ReflectionObject($object);

        $propertyReflection = $objectReflection->getProperty($property);
        $propertyReflection->setAccessible(true);
        $propertyReflection->setValue($object, $value);
    }

    protected function getProtectedMethod($object, string $method): \ReflectionMethod
    {
        $objectReflection = new \ReflectionObject($object);

        $methodReflection = $objectReflection->getMethod($method);
        $methodReflection->setAccessible(true);

        return $methodReflection;
    }
}