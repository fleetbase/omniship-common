<?php

/**
 * Omniship Provider Factory class
 */

namespace Omniship\Common;

use Omniship\Common\Exception\RuntimeException;
use Omniship\Common\Http\ClientInterface;
use GuzzleHttp\Psr7\Request as HttpRequest;

/**
 * Omniship Service Provider Factory class
 *
 * This class abstracts a set of providers that can be independently
 * registered, accessed, and used.
 *
 * Note that static calls to the Omniship class are routed to this class by
 * the static call router (__callStatic) in Omniship.
 *
 * Example:
 *
 * <code>
 *   // Create a provider for the Fedex Service
 *   // (routes to ProviderFactory::create)
 *   $provider = Omniship::create('Fedex');
 * </code>
 *
 */
class ServiceProviderFactory
{
    /**
     * Internal storage for all available providers
     *
     * @var array
     */
    private $providers = array();

    /**
     * All available providers
     *
     * @return array An array of provider names
     */
    public function all()
    {
        return $this->providers;
    }

    /**
     * Replace the list of available providers
     *
     * @param array $providers An array of provider names
     */
    public function replace(array $providers)
    {
        $this->providers = $providers;
    }

    /**
     * Register a new provider
     *
     * @param string $className Gateway name
     */
    public function register($className)
    {
        if (!in_array($className, $this->providers)) {
            $this->providers[] = $className;
        }
    }

    /**
     * Create a new provider instance
     *
     * @param string               $class       Gateway name
     * @param ClientInterface|null $httpClient  A HTTP Client implementation
     * @param HttpRequest|null     $httpRequest A Symfony HTTP Request implementation
     * @throws RuntimeException                 If no such provider is found
     * @return GatewayInterface                 An object of class $class is created and returned
     */
    public function create($class, ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        $class = Resolver::getClassName($class);

        if (!class_exists($class)) {
            throw new RuntimeException("Class '$class' not found");
        }

        return new $class($httpClient, $httpRequest);
    }
}
