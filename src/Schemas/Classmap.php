<?php

namespace ComposerJson\Schemas;

use ComposerJson\Model;

class Classmap extends Model implements AutoloadInterface
{
    /**
     * @var array
     */
    public array $options = [];

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->options;
    }
}
