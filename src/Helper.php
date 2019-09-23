<?php

namespace ComposerJson;

trait Helper
{
    /**
     * Normalize parameter from camelCase to composer-case
     *
     * @param string $name
     *
     * @return string
     */
    private function normalize(string $name): string
    {
        return strtolower(ltrim(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $name), '-'));
    }

    /**
     * Convert string like "require-dev" to "requireDev"
     *
     * @param string $name
     *
     * @return string
     */
    private function denormalize(string $name): string
    {
        $exploded = array_map(function ($item) {
            return ucfirst($item);
        }, explode('-', $name));

        return lcfirst(implode('', $exploded));
    }

    /**
     * Convert string like "require-dev" to "requireDev"
     *
     * @param string $name
     *
     * @return string
     */
    private function denormalizeClassName(string $name): string
    {
        $class = explode('\\', $name);
        $class = $class[array_key_last($class)];

        return $this->normalize($class);
    }

    /**
     * Convert string to normal name
     *
     * @param string $name
     *
     * @return string
     */
    private function normalizeMethodName(string $name): string
    {
        return str_replace(' ', '', ucwords(implode(' ', explode('-', $name))));
    }
}
