<?php
namespace App\ArrayOperations;
use Iterator;

class ArrayIterator implements Iterator
{
    private int
        $position = 0;

    private array
        $array = [];

    public function __construct($array)
    {
        $this->array=$array;
        $this->position = 0;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->array[$this->position];
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->array[$this->position]);
    }
}