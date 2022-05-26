<?php

namespace Omniship;

use Omniship\Common\ServiceProviderFactory;

class Omniship
{
    /**
     * Internal factory storage
     *
     * @var ServiceProviderFactory
     */
    private static $factory;

    /**
     * Get the shipper factory
     *
     * Creates a new empty ServiceProviderFactory if none has been set previously.
     *
     * @return ServiceProviderFactory A ServiceProviderFactory instance
     */
    public static function getFactory()
    {
        if (is_null(self::$factory)) {
            self::$factory = new ServiceProviderFactory;
        }

        return self::$factory;
    }

    /**
     * Set the gateway factory
     *
     * @param ServiceProviderFactory $factory A ServiceProviderFactory instance
     */
    public static function setFactory(ServiceProviderFactory $factory = null)
    {
        self::$factory = $factory;
    }

    /**
     * Static function call router.
     *
     * All other function calls to the Omniship class are routed to the
     * factory.  e.g. Omniship::getSupportedServiceProviders(1, 2, 3, 4) is routed to the
     * factory's getSupportedServiceProviders method and passed the parameters 1, 2, 3, 4.
     *
     * Example:
     *
     * <code>
     *   // Create a gateway for a Fleetbase organization
     *   $gateway = Omniship::create('Fleetbase');
     * </code>
     *
     * @see ServiceProviderFactory
     *
     * @param string $method     The factory method to invoke.
     * @param array  $parameters Parameters passed to the factory method.
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $factory = self::getFactory();

        return call_user_func_array(array($factory, $method), $parameters);
    }
}
