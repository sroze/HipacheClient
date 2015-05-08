<?php
namespace Hipache;

class Collection implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $objects;

    /**
     * @param array $objects
     */
    public function __construct(array $objects = [])
    {
        $this->objects = $objects;
    }

    /**
     * Add an element to the collection.
     *
     * @param mixed $object
     */
    public function add($object)
    {
        $this->objects[] = $object;
    }

    /**
     * Check if the given element is in the collection.
     *
     * @param mixed $object
     * @return bool
     */
    public function has($object)
    {
        return false !== array_search($object, $this->objects);
    }

    /**
     * Remove an object from the collection.
     *
     * @param mixed $object
     */
    public function remove($object)
    {
        if (false === ($position = array_search($object, $this->objects))) {
            throw new \InvalidArgumentException('Object not found in collection');
        }

        array_splice($this->objects, $position, 1);
    }

    /**
     * Return the number of objects in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->objects);
    }

    /**
     * Return the array representation of the collection.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->objects;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }
}
