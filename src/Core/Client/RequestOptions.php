<?php

namespace App\Core\Client;

use App\Core\Exceptions\InvalidPropertyException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RequestOptions
{
    private bool $verify_peer = false;
    private bool $verify_host = false;
    private ?array $query = null;

    public function __construct(array $options = [])
    {
        $this->fromArray($options);
    }

    public function __set(string $name, mixed $value): void
    {
        if (array_key_exists($name, HttpClientInterface::OPTIONS_DEFAULTS)) {
            $this->{$name} = $value;

            return;
        }

        throw new InvalidPropertyException("Property {$name} does not exist");
    }

    public function __get(string $name)
    {
        if (!isset($this->{$name})) {
            throw new InvalidPropertyException("Property {$name} does not exist");
        }
    }

    public function __isset(string $name): bool
    {
        return isset($this->{$name});
    }

    public function __unset(string $name)
    {
        unset($this->{$name});
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function fromArray(array $options): static
    {
        foreach ($options as $name => $value) {
            $this->{$name} = $value;
        }

        return $this;
    }

    public function merge(RequestOptions $options): static
    {
        return $this->fromArray($options->toArray());
    }

    public function mergeArray(array $options): static
    {
        return $this->fromArray($options);
    }
}
