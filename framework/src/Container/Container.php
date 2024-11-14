<?php
declare(strict_types=1);

namespace Src\Container;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use Src\Container\Exceptions\DependencyHasNoDefaultValueException;
use Src\Container\Exceptions\DependencyIsNotInstantiableException;
use Src\Container\Exceptions\NotFoundContainerException;

class Container implements ContainerInterface
{
    /**
     * @var array
     */
    private array $instances = [];

    /**
     * @param string $id
     * @return object|null
     * @throws DependencyIsNotInstantiableException
     * @throws DependencyHasNoDefaultValueException
     * @throws ReflectionException
     * @throws NotFoundContainerException
     */
    public function get(string $id): ?object
    {
        if (!$this->has($id)) {
            throw new NotFoundContainerException("No entry found for $id.");
        }

        $concrete = $this->instances[$id];
        return $this->resolve($concrete);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    /**
     * Register an alias in the container.
     *
     * @param string $id
     * @param mixed $concrete
     */
    public function set(string $id, mixed $concrete): void
    {
        $this->instances[$id] = $concrete;
    }

    /**
     * @param mixed $concrete
     * @return object|null
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws ReflectionException
     * @throws NotFoundContainerException
     */
    private function resolve(string $concrete): ?object
    {
        $reflection = new ReflectionClass($concrete);

        if (!$reflection->isInstantiable()) {
            throw new DependencyIsNotInstantiableException("Class $concrete is not instantiable");
        }

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * @param array $parameters
     * @return array
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws ReflectionException
     * @throws NotFoundContainerException
     */
    private function getDependencies(array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependencyClass = $parameter->getClass();

            if (is_null($dependencyClass)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new DependencyHasNoDefaultValueException("Cannot resolve class dependency $parameter->name");
                }
            } else {
                $dependencies[] = $this->get($dependencyClass->name);
            }
        }

        return $dependencies;
    }
}