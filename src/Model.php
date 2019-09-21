<?php

namespace ComposerJson;

use InvalidArgumentException;

abstract class Model implements ModelInterface
{
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
                        $result[$this->normalize($key)][$subKey] = $subItem->toArray();
                    } else {
                        $result[$this->normalize($key)][$subKey] = $subItem;
                    }
                }
            } elseif ($item instanceof ModelInterface) {
                $result[$this->normalize($key)] = $item->toArray();
            } else {
                if (!empty($item)) {
                    $result[$this->normalize($key)] = $item;
                }
            }
        }

        return $result;
    }

    /**
     * normalize parameter from camelCase to composer-case
     *
     * @param string $name
     *
     * @return string
     */
    private function normalize(string $name)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $name)), '-');
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
            throw new InvalidArgumentException('Property does not in list [' . implode(',', get_class_vars(self::class)) . ']');
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