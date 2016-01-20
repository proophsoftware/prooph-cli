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

        if ($packagePrefix = $this->getPackagePrefix()) {
            $namespace = $packagePrefix . '\\' . $namespace;
        }

        return rtrim($namespace, '\\');
    }

    /**
     * @inheritDoc
     */
    public function getPath($fcqn)
    {
        $fcqn = ltrim($fcqn, '\\');
        $namespace = str_replace($this->getPackagePrefix(), '', $fcqn);
        $namespace = ltrim(substr($namespace, 0, strrpos($namespace, '\\')), '\\');
        return $this->filterNamespaceToDirectory()->filter($namespace);
    }

    /**
     * @inheritDoc
     */
    public function getFilename($path, $name)
    {
        $filename = $this->getSourceFolder() . DIRECTORY_SEPARATOR;

        if ($path = trim($path, '/')) {
            $filename .= $path . DIRECTORY_SEPARATOR;
        }

        return $filename . $name . '.php';
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
     * @return FilterChain
     */
    private function filterDirectoryToNamespace()
    {
        if (null === $this->filterDirectoryToNamespace) {
            $this->filterDirectoryToNamespace = new FilterChain();
            $this->filterDirectoryToNamespace->attachByName(
                'wordseparatortocamelcase', ['separator' => DIRECTORY_SEPARATOR]
            );
            $this->filterDirectoryToNamespace->attachByName(
                'wordcamelcasetoseparator', ['separator' => '\\\\']
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
                'wordseparatortocamelcase', ['separator' => '\\']
            );
            $this->filterNamespaceToDirectory->attachByName(
                'wordcamelcasetoseparator', ['separator' => DIRECTORY_SEPARATOR]
            );
        }
        return $this->filterNamespaceToDirectory;
    }
}
