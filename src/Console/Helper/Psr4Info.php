<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Helper;

use Zend\Filter\FilterChain;

final class Psr4Info extends AbstractClassInfo implements ClassInfo
{
    /**
     * source folder
     *
     * @var string
     */
    protected $sourceFolder;

    /**
     * Package prefix
     *
     * @var string
     */
    protected $packagePrefix;

    /**
     * File doc block
     *
     * @var string
     */
    protected $fileDocBlock;

    /**
     * Input filter chain
     *
     * @var FilterChain
     */
    protected $filterDirectoryToNamespace;

    /**
     * Input filter chain
     *
     * @var FilterChain
     */
    protected $filterNamespaceToDirectory;

    /**
     * Configure PSR-4 meta info
     *
     * @param string $sourceFolder Absolute path to the source folder
     * @param string $packagePrefix Package prefix which is used as class namespace
     * @param string $fileDocBlock Common PHP file doc block
     */
    public function __construct($sourceFolder, $packagePrefix = '', $fileDocBlock = '')
    {
        $this->sourceFolder = rtrim($sourceFolder, '/');
        $this->packagePrefix = trim($packagePrefix, '\\');
        $this->fileDocBlock = $fileDocBlock;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return ClassInfo::class;
    }

    /**
     * @inheritDoc
     */
    public function getPackagePrefix()
    {
        return $this->packagePrefix;
    }

    /**
     * @inheritDoc
     */
    public function getClassNamespace($path)
    {
        $namespace = $this->filterDirectoryToNamespace()->filter($path);

        return $this->normalizeNamespace($this->getPackagePrefix() . '\\' . $namespace);
    }

    /**
     * @inheritDoc
     */
    public function getPath($fcqn)
    {
        $fcqn = $this->normalizeNamespace($fcqn);
        $namespace = str_replace($this->getPackagePrefix(), '', $fcqn);
        $namespace = ltrim(substr($namespace, 0, strrpos($namespace, '\\')), '\\');
        return $this->filterNamespaceToDirectory()->filter($namespace);
    }

    /**
     * @inheritDoc
     */
    public function getFilename($path, $name)
    {
        $filePath = $this->getSourceFolder() . DIRECTORY_SEPARATOR;

        if ($path = trim($path, '/')) {
            $filePath .= $this->normalizePath($path) . DIRECTORY_SEPARATOR;
        }

        return $filePath . ucfirst($name) . '.php';
    }

    /**
     * @inheritDoc
     */
    public function getSourceFolder()
    {
        return $this->sourceFolder;
    }

    /**
     * @inheritDoc
     */
    public function getFileDocBlock()
    {
        return $this->fileDocBlock;
    }

    /**
     * Removes duplicates of backslashes and trims backslashes
     *
     * @param string $namespace
     * @return string
     */
    private function normalizeNamespace($namespace)
    {
        $namespace = str_replace('\\\\', '\\', $namespace);
        $namespace = explode('\\', $namespace);

        array_walk($namespace, function (&$item) { $item = ucfirst($item); });

        return trim(implode('\\', $namespace), '\\');
    }

    /**
     * PSR-4 folders must be upper camel case
     *
     * @param string $path
     * @return string
     */
    private function normalizePath($path)
    {
        $path = explode('/', $path);

        array_walk($path, function (&$item) { $item = ucfirst($item); });

        return implode('/', $path);
    }

    /**
     * @return FilterChain
     */
    private function filterDirectoryToNamespace()
    {
        if (null === $this->filterDirectoryToNamespace) {
            $this->filterDirectoryToNamespace = new FilterChain();
            $this->filterDirectoryToNamespace->attachByName(
                'wordseparatortoseparator', ['search_separator' => DIRECTORY_SEPARATOR, 'replacement_separator' => '|']
            );
            $this->filterDirectoryToNamespace->attachByName(
                'wordseparatortoseparator', ['search_separator' => '|', 'replacement_separator' => '\\\\']
            );
        }
        return $this->filterDirectoryToNamespace;
    }

    /**
     * @return FilterChain
     */
    private function filterNamespaceToDirectory()
    {
        if (null === $this->filterNamespaceToDirectory) {
            $this->filterNamespaceToDirectory = new FilterChain();
            $this->filterNamespaceToDirectory->attachByName(
                'wordseparatortoseparator', ['search_separator' => '\\', 'replacement_separator' => '|']
            );
            $this->filterNamespaceToDirectory->attachByName(
                'wordseparatortoseparator', ['search_separator' => '|', 'replacement_separator' => DIRECTORY_SEPARATOR]
            );
        }
        return $this->filterNamespaceToDirectory;
    }
}
