<?php

namespace Omniship\Common;

use Omniship\Common\Http\ClientInterface;

class AbstractService
{
    private string $resource;
    private array $options = [];
    private ClientInterface $client;

    public function __construct(string $resource, ?ClientInterface $client = null, ?array $options = [])
    {
        $this->resource = $resource;
        $this->client = $client;
        $this->options = $options;
    }
}
