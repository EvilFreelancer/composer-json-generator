<?php

namespace ComposerJson;

use ComposerJson\Schemas\Classmap;
use ComposerJson\Schemas\Files;
use ComposerJson\Schemas\Psr0;
use ComposerJson\Schemas\Psr4;
use InvalidArgumentException;

abstract class Model implements ModelInterface
{
    use Helper;

    /**
     * Convert model to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        $items = get_object_vars($this);
        foreach ($items as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    if ($subItem instanceof ModelInterface) {

                        switch (get_class($subItem)) {
                            case Psr0::class:
                                $subKey = 'psr-0';
                                break;
                            case Psr4::class:
                                $subKey = 'psr-4';
                                break;
                            case Classmap::class:
                                $subKey = 'classmap';
                                break;
                            case Files::class:
                                $subKey = 'files';
                                break;
                        }

                        $result[$this->normalize($key)][$subKey] = $subItem->toArray();
                    } else {
                        $result[$this->normalize($key)][$subKey] = $subItem;
                    }
                }
            } elseif ($item instanceof ModelInterface) {
                $result[$this->normalize($key)] = $item->toArray();
            } elseif (!empty($item)) {
                $result[$this->normalize($key)] = $item;
            }
        }

        return $result;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws \InvalidArgumentException
     */
    public function __set(string $name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new InvalidArgumentException('Property "' . $name . '" does not in list [' . implode(',', array_keys(get_class_vars(get_class($this)))) . ']');
        }
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get(string $name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return !empty($this->$name);
    }
}
