<?php

namespace ComposerJson;

interface ModelInterface
{
    /**
     * Convert model to array
     *
     * @return array
     */
    public function toArray(): array;
}