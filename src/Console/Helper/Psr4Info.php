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
    protected $inputFilter;

    /**
     * Configure PSR-4 meta info
     *
     * @param string $sourceFolder Absolute path to the source folder
     * @param string $packagePrefix Package prefix which is used as class namespace
     * @param string $fileDocBlock Common PHP file doc block
     */
    public function __construct($sourceFolder, $packagePrefix = '\\', $fileDocBlock = '')
    {
        $this->sourceFolder = $sourceFolder;
        $this->packagePrefix = $packagePrefix;
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
        $namespace = $this->getInputFilter()->filter($path);

        if ($packagePrefix = trim($this->getPackagePrefix(), '\\')) {
            $namespace = $packagePrefix . '\\' . $namespace;
        }

        return $namespace;
    }

    /**
     * @inheritDoc
     */
    public function getFilename($path, $name)
    {
        return $this->getSourceFolder() . DIRECTORY_SEPARATOR
            . rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR
            . $name . '.php';
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
    private function getInputFilter()
    {
        if (null === $this->inputFilter) {
            $this->inputFilter = new FilterChain();
            $this->inputFilter->attachByName('wordseparatortocamelcase', ['separator' => DIRECTORY_SEPARATOR]);
            $this->inputFilter->attachByName('wordcamelcasetoseparator', ['separator' => '\\\\']);
        }
        return $this->inputFilter;
    }
}
