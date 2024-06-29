<?php

declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\ContainerException;
use ReflectionClass, ReflectionNamedType;

class Container {
    private array $definitions = [];
    private array $resolved = [];

    public function addDefinition(array $definitionPath) {
        $this->definitions = [...$this->definitions, ...$definitionPath];
    }

    public function resolve(string $className) {
        $reflective = new ReflectionClass($className);
        if (!$reflective->isInstantiable())
            throw new ContainerException("{$className} is Not Instantiable");
        $constructor = $reflective->getConstructor();

        if (!$constructor)
            return new $className;

        $params = $constructor->getParameters();

        if (count($params) === 0)
            return new $className;

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type)
                throw new ContainerException("{$name} Doesn't Have Type Hinting");

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin())
                throw new ContainerException("We Can't Determine Dependency of {$name}");

            $dependiences[] = $this->get($type->getName());
            return $reflective->newInstanceArgs($dependiences);
        }
    }

    public function get(string $id) {
        if (!array_key_exists($id, $this->definitions))
            throw new ContainerException("{$id} Doesn't Exist");

        if (array_key_exists($id, $this->resolved))
            return $this->resolved[$id];

        $this->resolved[$id] = $this->definitions[$id]();
        return $this->resolved[$id];
    }
}
