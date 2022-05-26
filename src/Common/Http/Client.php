<?php

namespace Omniship\Common\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use Omniship\Common\Http\Exception\RequestException;
use Omniship\Common\Http\Exception\ResponseException;
use Omniship\Common\Http\Exception\NetworkException;

class Client implements ClientInterface
{
    private string $host;
    private string $namespace;
    private GuzzleClient $client;
    private Response $lastResponse;

    public function __construct(array $options = [])
    {
        $this->host = $options['host'];
        $this->namespace = $options['namespace'];
        $this->client = $this->initialize($options);
    }

    public function request(string $uri, string $method = 'GET', array $options = []): ResponseInterface
    {
        $request = new Request($method, $uri);

        if (isset($options['onBefore']) && is_callable($options['onBefore'])) {
            call_user_func($options['onBefore'], $request, $options);
        }

        try {
            $this->lastResponse = $response = $this->client->send($request, $options);
        } catch (GuzzleRequestException| ClientException $exception) {
            throw new RequestException($exception->getMessage(), $request, $exception);
        } catch (BadResponseException $exception) {
            throw new ResponseException($exception->getMessage(), $request, $exception);
        } catch (Exception $exception) {
            throw new NetworkException($exception->getMessage(), $request, $exception);
        }

        if (isset($options['onAfter']) && is_callable($options['onAfter'])) {
            call_user_func($options['onAfter'], $response);
        }

        return $response;
    }

    public function get($uri, array $options = [])
    {
        return $this->request($uri, 'GET', $options);
    }

    public function post($uri, array $options = [])
    {
        return $this->request($uri, 'POST', $options);
    }

    public function put($uri, array $options = [])
    {
        return $this->request($uri, 'PUT', $options);
    }

    public function patch($uri, array $options = [])
    {
        return $this->request($uri, 'PATCH', $options);
    }

    public function delete($uri, array $options = [])
    {
        return $this->request($uri, 'DELETE', $options);
    }

    private function initialize(?array $options = null): GuzzleClient
    {
        $options = $options ?? $this->getOptions();

        unset($options['host'], $options['namespace']);

        return new GuzzleClient(array_merge(['base_uri' => $this->createRequestUri()], $options));
    }

    public function jsonFromResponse(?Response $response)
    {
        $body = $response->getBody();
        $contents = $body->getContents();
        $json = json_decode($contents);

        return $json;
    }

    private function createRequestUri(...$parts): string
    {
        $baseUri = $this->host . '/' . $this->namespace;
        $count = count($parts);

        for ($i = 0; $i < $count; $i++) {
            $part = $parts[$i];

            if (empty($part) || !is_string($part)) {
                continue;
            }

            $baseUri .= '/' . $part;
        }

        return trim($baseUri) . '/';
    }

    public function setHost(string $host): Client
    {
        $this->host = $this->options['host'] = $host;
        $this->client = $this->initialize();

        return $this;
    }

    public function setNamespace(string $namespace): Client
    {
        $this->namespace = $this->options['namespace'] = $namespace;
        $this->client = $this->initialize();

        return $this;
    }

    public function setOptions(?array $options = []): Client
    {
        $this->options = $options;
        $this->client = $this->initialize();

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getLastResponse(): Response
    {
        return $this->lastResponse;
    }
}
