<?php

declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\ContainerException;
use App\Config\Paths;
use ReflectionClass, ReflectionNamedType;
use stdClass;

class Container {
    private array $definitions = [];

    public function addDefinition(array $newDefinitions) {
        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }

    public function resolve(string $className) {
        $reflective = new ReflectionClass($className);
        if (!$reflective->isInstantiable())
            throw new ContainerException("Class {$className} is not instantiable");

        $constructor = $reflective->getConstructor();
        if (!$constructor)
            return new $className;

        $params = $constructor->getParameters();
        if (count($params) === 0)
            return  new $className;

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();
            if (!$type)
                throw new ContainerException("Property \${$name} Doesn't Have Type Hinting");

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin())
                throw new ContainerException("Property \${$name} Can't Determine The Type");

            $dependiences[] = $this->get($type->getName());
            dd($dependiences);
        }
    }

    public function get(string $id) {
        if (!array_key_exists($id, $this->definitions))
            throw new ContainerException("{$id} Doesn't Exist");
        return $this->definitions[$id]();
    }
}
