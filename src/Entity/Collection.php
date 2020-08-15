<?php

namespace Genesis\MicroFramework\Entity;

use Genesis\Services\Persistence\Contracts\ModelInterface;
use Iterator;

class Collection implements Iterator
{
    protected $collection = [];

    private $position = 0;

    public function toArray(): array
    {
        return $this->collection;
    }

    public function add(ModelInterface $item)
    {
        $this->collection[] = $item;

        return $this;
    }

    public function getAll(): array
    {
        return $this->collection;
    }

    public function getCount(): int
    {
        return count($this->collection);
    }

    public function current(): ModelInterface
    {
        return $this->collection[$this->position];
    }

    public function key(): int
    {
        return key($this->position);
    }

    public function next()
    {
        ++$this->position;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }

}