<?php

namespace Omniship\Common\Http;

use Omniship\Common\Http\Exception\NetworkException;
use Omniship\Common\Http\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

interface ClientInterface
{
    /**
     * Creates a new PSR-7 request.
     *
     * @param string|UriInterface                  $uri
     * @param string                               $method
     * @param array                                $options
     *
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     *
     * @return ResponseInterface
     */
    public function request(
        string $uri,
        string $method = 'GET',
        array $options = []
    );

    /**
     * Creates a new PSR-7 POST request.
     *
     * @param string|UriInterface                  $uri
     * @param string                               $method
     * @param array                                $options
     *
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     *
     * @return ResponseInterface
     */
    public function post(
        $uri,
        array $options = []
    );

    /**
     * Creates a new PSR-7 GET request.
     *
     * @param string|UriInterface                  $uri
     * @param string                               $method
     * @param array                                $options
     *
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     *
     * @return ResponseInterface
     */
    public function get(
        $uri,
        array $options = []
    );

    /**
     * Creates a new PSR-7 PUT request.
     *
     * @param string|UriInterface                  $uri
     * @param string                               $method
     * @param array                                $options
     *
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     *
     * @return ResponseInterface
     */
    public function put(
        $uri,
        array $options = []
    );

    /**
     * Creates a new PSR-7 PATCH request.
     *
     * @param string|UriInterface                  $uri
     * @param string                               $method
     * @param array                                $options
     *
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     *
     * @return ResponseInterface
     */
    public function patch(
        $uri,
        array $options = []
    );

    /**
     * Creates a new PSR-7 DELETE request.
     *
     * @param string               $uri
     * @param string                               $method
     * @param array                                $options
     *
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     *
     * @return ResponseInterface
     */
    public function delete(
        $uri,
        array $options = []
    );
}
