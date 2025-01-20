<?php

namespace Src\Container;

use Closure;
use Exception;
use Psr\Container\ContainerInterface;
use Src\TemplateEngine;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Container implements ContainerInterface
{
    private array $instances = [];


    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices(): void
    {
        $this->set(SessionInterface::class, fn() => new Session());

        $this->set(TemplateEngine::class, fn() => new TemplateEngine(__DIR__ . '/../../app/templates'));

    }


    public function set(string $id, $concrete): void
    {
        $this->instances[$id] = $concrete;
    }

    public function get(string $id)
    {
        if (!isset($this->instances[$id])) {
            throw new Exceptions\NotFoundContainerException("No entry found for {$id}.");
        }

        $concrete = $this->instances[$id];

        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        return $this->resolve($concrete);
    }

    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    private function resolve(string $concrete)
    {
        $reflector = new \ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class {$concrete} is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    private function getDependencies(array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if ($dependency === null) {
                $dependencies[] = $this->resolveNonClass($parameter);
            } else {
                $dependencies[] = $this->get($dependency->name);
            }
        }

        return $dependencies;
    }

    private function resolveNonClass(\ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new Exception("Cannot resolve the unknown dependency {$parameter->name}.");
    }

    public static function getInstance(): self
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new self();
        }

        return $instance;
    }
}