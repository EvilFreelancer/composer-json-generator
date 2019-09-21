<?php

namespace ComposerJson\Schemas;

use ComposerJson\Model;

class Repository extends Model
{
    /**
     * A Composer repository is simply a packages.json file served via the network (HTTP, FTP, SSH), that contains a list of composer.json objects with additional dist
     * and/or source information. The packages.json file is loaded using a PHP stream. You can set extra options on that stream using the options parameter.
     *
     * @var string
     */
    public string $composer;

    /**
     * The version control system repository can fetch packages from git, svn, fossil and hg repositories.
     *
     * @var string
     */
    public string $vcs;

    /**
     * With this you can import any pear repository into your Composer project.
     *
     * @var string
     */
    public string $pear;

    /**
     * If you depend on a project that does not have any support for composer whatsoever you can define the package inline using a package repository. You basically
     * inline the composer.json object.
     *
     * @var array
     */
    public array $package = [];

    /**
     * Additional options
     *
     * @var array
     */
    public array $options = [];
}
