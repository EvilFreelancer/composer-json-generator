<?php

namespace ComposerJson\Schemas;

use ComposerJson\Model;

class Psr0 extends Model implements AutoloadInterface
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
