<?php

namespace ComposerJson;

use ComposerJson\Schemas\Author;
use ComposerJson\Schemas\Composer;
use ComposerJson\Schemas\Repository;
use ComposerJson\Schemas\Support;
use ErrorException;
use JsonException;
use InvalidArgumentException;

class Generator
{
    use Helper;

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
     * @return JsonException|array
     * @throws JsonException
     */
    private function isJson(string &$source)
    {
        return json_decode($source, true, 512, JSON_THROW_ON_ERROR);
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
    public function toArray(): array
    {
        return $this->composer->toArray();
    }

    /**
     * Return JSON with composer
     *
     * @return string
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    }

    /**
     * Compolomus believe what is a simplification of code...
     *
     * @param string $rule
     * @param mixed  $value
     */
    private function parseFields(string $rule, $value): void
    {
        $rule      = $rule !== 'autoload-dev' ? $rule : 'autoload';
        $classRule = $this->denormalize($rule);

        if (!empty($classRule)) {
            if (is_array($this->composer->$classRule)) {
                $method = 'parse' . $this->normalizeMethodName($rule);
                if (method_exists($this, $method)) {
                    $this->composer->$classRule = $this->$method($value);
                } else {
                    $this->composer->$classRule = $value;
                }
            } else {
                $this->composer->$classRule = $value;
            }
        }

    }

    /**
     * Read JSON conde and return Composer object
     *
     * @param string $file
     *
     * @return Composer
     * @throws ErrorException
     * @throws JsonException
     */
    public function read(string $file): Composer
    {
        // Read file from string
        if (!$source = file_get_contents($file)) {
            throw new ErrorException('Provided file could not to be read');
        }

        // Convert JSON to array or throw JsonException
        $array = $this->isJson($source);

        // Initiate composer object
        $this->composer = new Composer();

        // Parse values
        foreach ($array as $key => $value) {
            $this->parseFields($key, $value);
        }

        return $this->composer;
    }

    /**
     * Parse autoload parts of composer.json
     *
     * @param array $autoload
     *
     * @return array
     */
    private function parseAutoload(array $autoload): array
    {
        $objects = [];

        $methodsArray = [
            'psr-0',
            'psr-4',
            'classmap',
            'files'
        ];

        foreach ($autoload as $type => $options) {
            if (in_array($type, $methodsArray, true)) {
                $class  = 'ComposerJson\\Schemas\\' . $this->normalizeMethodName($type);
                $object = new $class;

                // Autoload object options
                $object->options = $options;

                // Save object
                $objects[$type] = $object;
            } else {
                throw new InvalidArgumentException('Incorrect type of autoloader provided');
            }
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

                if ($key === 'packagist.org') {
                    $key = 'packagistOrg';
                }

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
