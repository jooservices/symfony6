<?php

namespace App\Core\Client;

use App\Core\Exceptions\InvalidPropertyException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RequestOptions
{
    private array $options = [];

    public function __construct(array $options = [])
    {
        $this->fromArray($options);
    }

    public function __set(string $name, mixed $value): void
    {
        if (array_key_exists($name, HttpClientInterface::OPTIONS_DEFAULTS)) {
            $this->options[$name] = $value;

            return;
        }

        throw new InvalidPropertyException("Property {$name} does not exist");
    }

    public function __get(string $name): mixed
    {
        if (!isset($this->options[$name])) {
            throw new InvalidPropertyException("Property {$name} does not exist");
        }

        return $this->options[$name];
    }

    public function __isset(string $name): bool
    {
        return isset($this->options[$name]);
    }

    public function __unset(string $name)
    {
        unset($this->options[$name]);
    }

    public function toArray(): array
    {
        return $this->options;
    }

    public function fromArray(array $options): static
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function merge(RequestOptions $options): static
    {
        return $this->fromArray($options->toArray());
    }
}
