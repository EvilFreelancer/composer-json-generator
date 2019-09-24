<?php

namespace ComposerJson\Schemas;

use ComposerJson\Model;
use phpDocumentor\Reflection\Types\Array_;

class Composer extends Model
{
    /**
     * The name of the package. It consists of vendor name and project name, separated by /. Examples:
     *
     * monolog/monolog
     * igorw/event-source
     *
     * The name can contain any character, including white spaces, and it's case insensitive (foo/bar and Foo/Bar are considered the same package). In order to simplify
     * its installation, it's recommended to define a short and lowercase name that doesn't include non-alphanumeric characters or white spaces.
     *
     * Required for published packages (libraries).
     *
     * @var string
     */
    public ?string $name;

    /**
     * A short description of the package. Usually this is one line long.
     *
     * Required for published packages (libraries).
     *
     * @var string
     */
    public ?string $description;

    /**
     * The version of the package. In most cases this is not required and should be omitted (see below).
     *
     * This must follow the format of X.Y.Z or vX.Y.Z with an optional suffix of -dev, -patch (-p), -alpha (-a), -beta (-b) or -RC. The patch, alpha, beta and RC
     * suffixes can also be followed by a number.
     *
     * Examples:
     *
     * 1.0.0
     * 1.0.2
     * 1.1.0
     * 0.2.5
     * 1.0.0-dev
     * 1.0.0-alpha3
     * 1.0.0-beta2
     * 1.0.0-RC5
     * v2.0.4-p1
     *
     * Optional if the package repository can infer the version from somewhere, such as the VCS tag name in the VCS repository. In that case it is also recommended to
     * omit it.
     *
     * Note: Packagist uses VCS repositories, so the statement above is very much true for Packagist as well. Specifying the version yourself will most likely end up
     * creating problems at some point due to human error.
     *
     * @var string
     */
    public ?string $version;

    /**
     * The type of the package. It defaults to library.
     *
     * Package types are used for custom installation logic. If you have a package that needs some special logic, you can define a custom type. This could be a
     * symfony-bundle, a wordpress-plugin or a typo3-cms-extension. These types will all be specific to certain projects, and they will need to provide an installer
     * capable of installing packages of that type.
     *
     * Out of the box, Composer supports four types:
     *
     * library: This is the default. It will simply copy the files to vendor.
     * project: This denotes a project rather than a library. For example application shells like the Symfony standard edition, CMSs like the SilverStripe installer or
     * full fledged applications distributed as packages. This can for example be used by IDEs to provide listings of projects to initialize when creating a new
     * workspace. metapackage: An empty package that contains requirements and will trigger their installation, but contains no files and will not write anything to the
     * filesystem. As such, it does not require a dist or source key to be installable. composer-plugin: A package of type composer-plugin may provide an installer for
     * other packages that have a custom type. Read more in the dedicated article.
     *
     * Only use a custom type if you need custom logic during installation. It is recommended to omit this field and have it default to library.
     *
     * @var string
     */
    public ?string $type;

    /**
     * An array of keywords that the package is related to. These can be used for searching and filtering.
     *
     * Examples:
     *
     * logging
     * events
     * database
     * redis
     * templating
     *
     * Optional.
     *
     * @var array
     */
    public array $keywords = [];

    /**
     * An URL to the website of the project.
     *
     * Optional.
     *
     * @var string
     */
    public ?string $homepage;

    /**
     * A relative path to the readme document.
     *
     * Optional.
     *
     * @var string
     */
    public ?string $readme;

    /**
     * Release date of the version.
     *
     * Must be in YYYY-MM-DD or YYYY-MM-DD HH:MM:SS format.
     *
     * Optional.
     *
     * @var ?string
     */
    public ?string $time;

    /**
     * The license of the package. This can be either a string or an array of strings.
     *
     * The recommended notation for the most common licenses is (alphabetical):
     *
     * Apache-2.0
     * BSD-2-Clause
     * BSD-3-Clause
     * BSD-4-Clause
     * GPL-2.0-only / GPL-2.0-or-later
     * GPL-3.0-only / GPL-3.0-or-later
     * LGPL-2.1-only / LGPL-2.1-or-later
     * LGPL-3.0-only / LGPL-3.0-or-later
     * MIT
     *
     * Optional, but it is highly recommended to supply this. More identifiers are listed at the SPDX Open Source License Registry.
     *
     * For closed-source software, you may use "proprietary" as the license identifier.
     *
     * @var string|string[]
     */
    public $license;

    /**
     * The authors of the package. This is an array of objects.
     *
     * Each author object can have following properties:
     *
     * name: The author's name. Usually their real name.
     * email: The author's email address.
     * homepage: An URL to the author's website.
     * role: The author's role in the project (e.g. developer or translator)
     *
     * @var \ComposerJson\Schemas\Author[]
     */
    public array $authors = [];

    /**
     * Various information to get support about the project.
     *
     * Support information includes the following:
     *
     * email: Email address for support.
     * issues: URL to the issue tracker.
     * forum: URL to the forum.
     * wiki: URL to the wiki.
     * irc: IRC channel for support, as irc://server/channel.
     * source: URL to browse or download the sources.
     * docs: URL to the documentation.
     * rss: URL to the RSS feed.
     * chat: URL to the chat channel.
     *
     * @var \ComposerJson\Schemas\Support
     */
    public $support;

    /**
     * Lists packages required by this package. The package will not be installed unless those requirements can be met.
     *
     * @var array
     */
    public array $require = [];

    /**
     * Lists packages required for developing this package, or running tests, etc. The dev requirements of the root package are installed by default. Both install or
     * update support the --no-dev option that prevents dev dependencies from being installed.
     *
     * @var array
     */
    public array $requireDev = [];

    /**
     * Lists packages that conflict with this version of this package. They will not be allowed to be installed together with your package.
     *
     * Note that when specifying ranges like <1.0 >=1.1 in a conflict link, this will state a conflict with all versions that are less than 1.0 and equal or newer than
     * 1.1 at the same time, which is probably not what you want. You probably want to go for <1.0 || >=1.1 in this case.
     *
     * @var array
     */
    public array $conflict = [];

    /**
     * Lists packages that are replaced by this package. This allows you to fork a package, publish it under a different name with its own version numbers, while
     * packages requiring the original package continue to work with your fork because it replaces the original package.
     *
     * This is also useful for packages that contain sub-packages, for example the main symfony/symfony package contains all the Symfony Components which are also
     * available as individual packages. If you require the main package it will automatically fulfill any requirement of one of the individual components, since it
     * replaces them.
     *
     * Caution is advised when using replace for the sub-package purpose explained above. You should then typically only replace using self.version as a version
     * constraint, to make sure the main package only replaces the sub-packages of that exact version, and not any other version, which would be incorrect.
     *
     * @var array
     */
    public array $replace = [];

    /**
     * List of other packages that are provided by this package. This is mostly useful for common interfaces. A package could depend on some virtual logger package, any
     * library that implements this logger interface would simply list it in provide.
     *
     * @var array
     */
    public array $provide = [];

    /**
     * Suggested packages that can enhance or work well with this package. These are informational and are displayed after the package is installed, to give your users a
     * hint that they could add more packages, even though they are not strictly required.
     *
     * The format is like package links above, except that the values are free text and not version constraints.
     *
     * @var array
     */
    public array $suggest = [];

    /**
     * Autoload mapping for a PHP autoloader.
     *
     * PSR-4 and PSR-0 autoloading, classmap generation and files includes are supported.
     *
     * PSR-4 is the recommended way since it offers greater ease of use (no need to regenerate the autoloader when you add classes).
     *
     * @var \ComposerJson\Schemas\AutoloadInterface[]
     */
    public array $autoload = [];

    /**
     * This section allows to define autoload rules for development purposes.
     *
     * Classes needed to run the test suite should not be included in the main autoload rules to avoid polluting the autoloader in production and when other people use
     * your package as a dependency.
     *
     * Therefore, it is a good idea to rely on a dedicated path for your unit tests and to add it within the autoload-dev section.
     *
     * @var \ComposerJson\Schemas\AutoloadInterface[]
     */
    public array $autoloadDev = [];

    /**
     * DEPRECATED: This is only present to support legacy projects, and all new code should preferably use autoloading. As such it is a deprecated practice, but the
     * feature itself will not likely disappear from Composer.
     *
     * A list of paths which should get appended to PHP's include_path.
     *
     * @var array
     */
    public array $includePath = [];

    /**
     * DEPRECATED: This is only present to support legacy PSR-0 style autoloading, and all new code should preferably use PSR-4 without target-dir and projects using
     * PSR-0 with PHP namespaces are encouraged to migrate to PSR-4 instead.
     *
     * Defines the installation target.
     *
     * In case the package root is below the namespace declaration you cannot autoload properly. target-dir solves this problem.
     *
     * An example is Symfony. There are individual packages for the components. The Yaml component is under Symfony\Component\Yaml. The package root is that Yaml
     * directory. To make autoloading possible, we need to make sure that it is not installed into vendor/symfony/yaml, but instead into
     * vendor/symfony/yaml/Symfony/Component/Yaml, so that the autoloader can load it from vendor/symfony/yaml.
     *
     * @var string
     */
    public ?string $targetDir;

    /**
     * This defines the default behavior for filtering packages by stability. This defaults to stable, so if you rely on a dev package, you should specify it in your
     * file to avoid surprises.
     *
     * All versions of each package are checked for stability, and those that are less stable than the minimum-stability setting will be ignored when resolving your
     * project dependencies. (Note that you can also specify stability requirements on a per-package basis using stability flags in the version constraints that you
     * specify in a require block (see package links for more details).
     *
     * Available options (in order of stability) are dev, alpha, beta, RC, and stable.
     *
     * @var string
     */
    public ?string $minimumStability;

    /**
     * When this is enabled, Composer will prefer more stable packages over unstable ones when finding compatible stable packages is possible. If you require a dev
     * version or only alphas are available for a package, those will still be selected granted that the minimum-stability allows for it.
     *
     * Use "prefer-stable": true to enable.
     *
     * @var bool
     */
    public bool $preferStable;

    /**
     * Custom package repositories to use.
     *
     * By default Composer only uses the packagist repository. By specifying repositories you can get packages from elsewhere.
     *
     * Repositories are not resolved recursively. You can only add them to your main composer.json. Repository declarations of dependencies' composer.jsons are ignored.
     *
     * The following repository types are supported:
     *
     * composer: A Composer repository is simply a packages.json file served via the network (HTTP, FTP, SSH), that contains a list of composer.json objects with
     * additional dist and/or source information. The packages.json file is loaded using a PHP stream. You can set extra options on that stream using the options
     * parameter. vcs: The version control system repository can fetch packages from git, svn, fossil and hg repositories. pear: With this you can import any pear
     * repository into your Composer project. package: If you depend on a project that does not have any support for composer whatsoever you can define the package
     * inline using a package repository. You basically inline the composer.json object.
     *
     * @var \ComposerJson\Schemas\Repository[]
     */
    public array $repositories = [];

    /**
     * A set of configuration options. It is only used for projects. See Config for a description of each individual option.
     *
     * @var array
     */
    public array $config = [];

    /**
     * Composer allows you to hook into various parts of the installation process through the use of scripts.
     *
     * See Scripts for events details and examples
     *
     * @var array
     */
    public array $scripts = [];

    /**
     * Arbitrary extra data for consumption by scripts.
     *
     * This can be virtually anything. To access it from within a script event handler, you can do:
     *
     * $extra = $event->getComposer()->getPackage()->getExtra();
     *
     * Optional.
     *
     * @var array
     */
    public array $extra = [];

    /**
     * A set of files that should be treated as binaries and symlinked into the bin-dir (from config).
     *
     * See Vendor Binaries for more details.
     *
     * Optional.
     *
     * @var string|array
     */
    public $bin;

    /**
     * A set of options for creating package archives.
     *
     * The following options are supported:
     *
     * exclude: Allows configuring a list of patterns for excluded paths. The pattern syntax matches .gitignore files. A leading exclamation mark (!) will result in any
     * matching files to be included even if a previous pattern excluded them. A leading slash will only match at the beginning of the project relative path. An asterisk
     * will not expand to a directory separator.
     *
     * Optional.
     *
     * @var array
     */
    public array $archive = [];

    /**
     * Indicates whether this package has been abandoned.
     *
     * It can be boolean or a package name/URL pointing to a recommended alternative.
     *
     * Examples:
     *
     * Use "abandoned": true to indicates this package is abandoned. Use "abandoned": "monolog/monolog" to indicates this package is abandoned and the recommended
     * alternative is monolog/monolog.
     *
     * Defaults to false.
     *
     * Optional.
     *
     * @var bool|string
     */
    public $abandoned;

    /**
     * A list of regex patterns of branch names that are non-numeric (e.g. "latest" or something), that will NOT be handled as feature branches. This is an array of
     * strings.
     *
     * If you have non-numeric branch names, for example like "latest", "current", "latest-stable" or something, that do not look like a version number, then Composer
     * handles such branches as feature branches. This means it searches for parent branches, that look like a version or ends at special branches (like master) and the
     * root package version number becomes the version of the parent branch or at least master or something.
     *
     * To handle non-numeric named branches as versions instead of searching for a parent branch with a valid version or special branch name like master, you can set
     * patterns for branch names, that should be handled as dev version branches.
     *
     * This is really helpful when you have dependencies using "self.version", so that not dev-master, but the same branch is installed (in the example: latest-testing).
     *
     * Optional.
     *
     * @var array
     */
    public array $nonFeatureBranches = [];
}
