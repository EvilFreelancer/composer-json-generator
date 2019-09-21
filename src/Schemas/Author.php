<?php

namespace ComposerJson\Schemas;

use ComposerJson\Model;

/**
 * Each author object can have following properties
 *
 * @package ComposerJson\Schemas
 */
class Author extends Model
{
    /**
     * The author's name. Usually their real name.
     *
     * @var string
     */
    public string $name;

    /**
     * The author's email address.
     *
     * @var string
     */
    public string $email;

    /**
     * An URL to the author's website.
     *
     * @var string
     */
    public string $homepage;

    /**
     * The author's role in the project (e.g. developer or translator)
     *
     * @var string
     */
    public string $role;
}