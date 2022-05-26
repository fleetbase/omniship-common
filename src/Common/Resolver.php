<?php

namespace Omniship\Common;

use Omniship\Common\ServiceProvider;
use Omniship\Common\Utils;

class Resolver
{
    /**
     * The package namespace `\Omniship`
     * 
     * @var string
     */
    public const PACKAGE_NAMESPACE = 'Omniship';

    /**
     * The default service provider name `ServiceProvider`
     * 
     * @var string
     */
    public const SERVICE_PROVIDER_CLASS = 'ServiceProvider';

    /**
     * The FQCN for the `ServiceProviderInterface`
     * 
     * @var string
     */
    public const SERVICE_PROVIDER_INTERFACE = ServiceProviderInterface::class;

    /**
     * Resolves a class instance from a string or FQCN
     *
     * @param string $class
     * @param mixed ...$params
     * 
     * @return mixed|null
     */
    private static function resolveInstance($class, ...$params)
    {
        if (class_exists($class)) {
            return new $class(...$params);
        }

        return null;
    }

    /**
     * Resolves a package class instance from a string.
     * 
     * common:serializer:order => \Omniship\Common\Serializer\Order
     *
     * @param string $name
     * @param mixed ...$params
     * 
     * @return mixed|null
     */
    public static function resolveFromString(string $name, ...$params)
    {
        $class = static::getClassName(explode(':', $name));

        return static::resolveInstance($class, ...$params);
    }

    /**
     * Resolves a Omniship spaced class instance from string.
     *
     * @param string $name
     * @param mixed ...$params
     * 
     * @return mixed
     */
    public static function resolve(string $name, ...$params)
    {
        return static::resolveFromString($name, ...$params);
    }

    public static function resolveSerializer($name, ...$params): SerializerInterface
    {
        if (0 === strpos($name, '\\' . static::PACKAGE_NAMESPACE) || 0 === strpos($name, static::PACKAGE_NAMESPACE)) {
            return new $name(...$params);
        }

        if (is_subclass_of($name, SerializerInterface::class, true)) {
            return new $name(...$params);
        }

        $serializer = static::resolveFromString('serializer', $name . 'Serializer');

        if (class_exists($serializer)) {
            return new $serializer(...$params);
        }

        return new AbstractSerializer(...$params);
    }

    public static function resolveResource($name, ...$params): AbstractResource
    {
        $resource = static::resolveFromString('resources', $name . 'Serializer');

        if (class_exists($resource)) {
            return new $resource(...$params);
        }

        return new AbstractResource(...$params);
    }

    /**
     * Resolve a short gateway name to a full namespaced service provider class.
     *
     * Class names beginning with a namespace marker (\) are left intact.
     * Non-namespaced classes are expected to be in the \Omniship namespace, e.g.:
     *
     *      \Custom\ServiceProvider     => \Custom\ServiceProvider
     *      \Custom_ServiceProvider     => \Custom_ServiceProvider
     *      FedEx              => \Omniship\FedEx\ServiceProvider
     *      FedEx\Freight      => \Omniship\FedEx\Freight\ServiceProvider
     *      FedEx_Freight      => \Omniship\FedEx\Freight\ServiceProvider
     *
     * @param  string  $$name The short gateway name or the FQCN
     * 
     * @return string  The fully namespaced gateway class name
     */
    public static function resolveServiceProviderClassName($shortName)
    {
        if (0 === strpos($shortName, '\\' . static::PACKAGE_NAMESPACE) || 0 === strpos($shortName, static::PACKAGE_NAMESPACE)) {
            return $shortName;
        }

        if (is_subclass_of($shortName, static::SERVICE_PROVIDER_INTERFACE, true)) {
            return $shortName;
        }

        if (Utils::stringContains($shortName, '_')) {
            $shortName = explode('_', $shortName);
            $shortName = array_filter($shortName);
            $shortName = Utils::removeElementFromArray($shortName, static::SERVICE_PROVIDER_CLASS);
        }

        if (Utils::stringContains($shortName, '\\')) {
            $shortName = explode('\\', $shortName);
            $shortName = array_filter($shortName);
            $shortName = Utils::removeElementFromArray($shortName, static::SERVICE_PROVIDER_CLASS);
        }

        if (is_array($shortName)) {
            $shortName = array_filter($shortName);
            $inArray = in_array(static::SERVICE_PROVIDER_CLASS, $shortName);
            $inString = false;

            foreach ($shortName as $shortNamePart) {
                if (Utils::stringContains($shortNamePart, static::SERVICE_PROVIDER_CLASS)) {
                    $inString = true;
                    break;
                }
            }

            $shortName = array_map(function ($shortNamePart) {
                return str_replace('\\', '', $shortNamePart);
            }, $shortName);

            if ($inArray === false || $inString === false) {
                $shortName[] = static::SERVICE_PROVIDER_CLASS;
            }

            return static::getClassName(...$shortName);
        }

        return static::getClassName($shortName, static::SERVICE_PROVIDER_CLASS);
    }

    /**
     * Resolves a string or arguments passed into a Omniship spaced class name.
     *
     * @return string
     */
    public static function getClassName()
    {
        $namespace = static::PACKAGE_NAMESPACE . '\\';
        $args = func_get_args();
        $count = count($args);

        // If the class starts with \ or Omniship\, assume it's a FQCN
        if ($count === 1 && 0 === strpos($args[0], '\\') || 0 === strpos($args[0], static::PACKAGE_NAMESPACE)) {
            return $args[0];
        }

        for ($i = 0; $i < $count; $i++) {
            $class = $args[$i];
            $last = $count === $i + 1;

            $namespace .= Utils::classify($class);

            if (!$last) {
                $namespace .= '\\';
            }
        }

        return $namespace;
    }
}
