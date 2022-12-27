<?php

namespace MercadoPago\PP\Sdk\Common;

/**
 * Class AbstractEntity
 *
 * @package MercadoPago\PP\Sdk\Common
 */
abstract class AbstractEntity implements \JsonSerializable
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * AbstractEntity constructor.
     *
     * @param Manager|null $manager
     */
    public function __construct(Manager $manager = null)
    {
        $this->manager = $manager;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->{$name};
    }

    /**
     * @param string $name
     * @param        $value
     */
    public function __set(string $name, $value)
    {
        if (!property_exists($this, $name)) {
            return;
        }

        if (is_subclass_of($this->{$name}, AbstractEntity::class)
            || is_subclass_of($this->{$name}, AbstractCollection::class)) {
            $this->{$name}->setEntity($value);
        } else {
            $this->{$name} = $value;
        }
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset(string $name)
    {
        return isset($this->{$name});
    }

    /**
     * @param string $name
     */
    public function __unset(string $name)
    {
        unset($this->{$name});
    }


    /**
     * Set values for an entity's attributes.
     *
     * @param $data
     */
    public function setEntity($data)
    {
        if (is_array($data) || is_object($data)) {
            foreach ($data as $key => $value) {
                $this->__set($key, $value);
            }
        }
    }

    /**
     * @codeCoverageIgnore
     * Get the properties of the given object.
     *
     * @return array
     */
    public function getProperties(): array
    {
        return get_object_vars($this);
    }

    /**
     * Get an array from an object.
     *
     * @return array
     */
    public function toArray(): array
    {
        $properties = $this->getProperties();

        $data = [];
        foreach ($properties as $property => $value) {
            if ($property === 'manager') {
                continue;
            }

            if ($value instanceof self) {
                $data[$property] = $value->toArray();
                continue;
            }

            if (($value instanceof \IteratorAggregate) || (is_array($value) && count($value))) {
                foreach ($value as $index => $item) {
                    if ($item instanceof self) {
                        $data[$property][$index] = $item->toArray();
                    } else {
                        $data[$property][$index] = $item;
                    }
                }
                continue;
            }

            $data[$property] = $this->$property;
        }

        return $data;
    }

    /**
     * Read method (GET).
     *
     * @param array $params
     *
     * @return mixed
     * @throws \Exception
     */
    public function read(array $params = [])
    {
        $method = 'get';
        $class = get_called_class();
        $entity = new $class($this->manager);

        $uri = $this->manager->getEntityUri($entity, $method, $params);
        $header = $this->manager->getHeader();
        $response = $this->manager->execute($entity, $uri, $method, $header);

        return $this->manager->handleResponse($response, $method, $entity);
    }

    /**
     * Save method (POST).
     *
     * @return mixed
     * @throws \Exception
     */
    public function save()
    {
        $method = 'post';

        $uri = $this->manager->getEntityUri($this, $method);
        $header = $this->manager->getHeader();
        $response = $this->manager->execute($this, $uri, $method, $header);

        return $this->manager->handleResponse($response, $method);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
