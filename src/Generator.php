<?php

namespace ComposerJson;

use ComposerJson\Schemas\Author;
use ComposerJson\Schemas\Classmap;
use ComposerJson\Schemas\Composer;
use ComposerJson\Schemas\Files;
use ComposerJson\Schemas\Psr0;
use ComposerJson\Schemas\Psr4;
use ComposerJson\Schemas\Repository;
use ComposerJson\Schemas\Support;
use ErrorException;
use InvalidArgumentException;

class Generator
{
    /**
     * Main root object of composer
     *
     * @var Composer
     */
    private Composer $composer;

    /**
     * Check if file is JSON
     *
     * @param string $source
     *
     * @return false|array
     */
    private function isJson(string &$source)
    {
        $json = json_decode($source, true);
        return $json !== false ? $json : false;
    }

    /**
     * Generator constructor.
     *
     * @param \ComposerJson\Schemas\Composer|null $composer
     */
    public function __construct(Composer $composer = null)
    {
        if (null !== $composer) {
            $this->composer = $composer;
        }
    }

    /**
     * Load composer to memory
     *
     * @param \ComposerJson\Schemas\Composer $composer
     *
     * @return $this
     */
    public function load(Composer $composer): self
    {
        $this->composer = $composer;
        return $this;
    }

    /**
     * Return array of values
     *
     * @return array
     */
    public function toArray()
    {
        return $this->composer->toArray();
    }

    /**
     * Return JSON with composer
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Read JSON conde and return Composer object
     *
     * @param string $file
     *
     * @return Composer
     * @throws \ErrorException
     * @throws \InvalidArgumentException
     */
    public function read(string $file)
    {
        // Read file from string
        if (!$source = file_get_contents($file)) {
            throw new ErrorException('Provided file could not to be read');
        }

        // Convert JSON to array
        if (!$array = $this->isJson($source)) {
            throw new ErrorException('Provided string is not a valid JSON');
        }

        // Initiate composer object
        $this->composer = new Composer();

        // Parse values
        foreach ($array as $key => $value) {

            switch ($key) {

                /*
                 * Specific objects
                 */

                case 'authors':
                    $this->composer->authors = $this->parseAuthors($value);
                    break;
                case 'support':
                    $this->composer->support = $this->parseSupport($value);
                    break;
                case 'repositories':
                    $this->composer->repositories = $this->parseRepositories($value);
                    break;
                case 'autoload':
                    $this->composer->autoload = $this->parseAutoload($value);
                    break;
                case 'autoload-dev':
                    $this->composer->autoloadDev = $this->parseAutoload($value);
                    break;

                /*
                 * Convert format of keys
                 */

                case 'require-dev':
                    $this->composer->requireDev = $value;
                    break;
                case 'include-path':
                    $this->composer->includePath = $value;
                    break;
                case 'target-dir':
                    $this->composer->targetDir = $value;
                    break;
                case 'minimum-stability':
                    $this->composer->minimumStability = $value;
                    break;
                case 'prefer-stable':
                    $this->composer->preferStable = $value;
                    break;
                case 'non-feature-branches';
                    $this->composer->nonFeatureBranches = $value;
                    break;

                /*
                 * Default values
                 */

                default:
                    $this->composer->$key = $value;
                    break;
            }

        }

        return $this->composer;
    }

    private function parseAutoload(array $autoload): array
    {
        $objects = [];
        foreach ($autoload as $type => $options) {

            switch ($type) {
                case 'psr-0':
                    $object = new Psr0();
                    break;
                case 'psr-4':
                    $object = new Psr4();
                    break;
                case 'classmap':
                    $object = new Classmap();
                    break;
                case 'files':
                    $object = new Files();
                    break;
                default:
                    throw new InvalidArgumentException('Incorrect type of autoloader provided');
                    break;
            }

            // Autoload object options
            $object->options = $options;

            // Save object
            $objects[$type] = $object;
        }

        return $objects;
    }

    /**
     * Convert array of repositories to array of repository objects
     *
     * @param array $repositories
     *
     * @return \ComposerJson\Schemas\Repository[]
     */
    private function parseRepositories(array $repositories): array
    {
        $objects = [];
        foreach ($repositories as $repository) {
            $object = new Repository();

            foreach ($repository as $key => $value) {
                $object->$key = $value;
            }

            $objects[] = $object;
        }

        return $objects;
    }

    /**
     * Convert support array to object of schema
     *
     * @param array $support
     *
     * @return \ComposerJson\Schemas\Support
     */
    private function parseSupport(array $support): Support
    {
        $object = new Support();

        foreach ($support as $key => $value) {
            $object->$key = $value;
        }

        return $object;
    }

    /**
     * Convert authors array to array of objects
     *
     * @param array $authors
     *
     * @return \ComposerJson\Schemas\Author[]
     */
    private function parseAuthors(array $authors): array
    {
        $objects = [];
        foreach ($authors as $author) {
            $object = new Author();

            foreach ($author as $key => $value) {
                $object->$key = $value;
            }

            $objects[] = $object;
        }

        return $objects;
    }
}