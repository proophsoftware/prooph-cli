<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Code\Generator;

use Prooph\Cli\Exception\RuntimeException;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\ClassGenerator;

abstract class AbstractGenerator implements Generator
{
    /**
     * @interitdoc
     */
    public function __invoke($name, $namespace, $classToExtend, $fileDocBlock = null)
    {
        $methods = $this->getMethods();
        $uses = $this->getUses();
        $interfaces = $this->getImplementedInterfaces();
        $properties = $this->getClassProperties();
        $docBlock = '';
        $flags = $this->getClassFlags();

        if ($fileDocBlock) {
            $docBlock = new DocBlockGenerator($docBlock);
        }

        if ($classToExtend) {
            $uses[] = $classToExtend;
        }

        $class = new ClassGenerator(
            $name,
            $namespace,
            $flags,
            $classToExtend,
            $interfaces,
            $properties,
            $methods,
            $this->getClassDocBlock($name)
        );

        return new FileGenerator([
            'classes' => [$class],
            'namespace' => $namespace,
            'uses' => $uses,
            'docBlock' => $docBlock
        ]);
    }

    /**
     * @interitdoc
     */
    public function writeClass($filename, FileGenerator $fileGenerator)
    {
        $dir = dirname($filename);

        if (!@mkdir($dir, 0755, true) && !is_dir($dir)) {
            throw new RuntimeException(sprintf('Could not create "%s" directory.', $dir));
        }
        file_put_contents($filename, $fileGenerator->generate());
    }

    /**
     * @param string $name Class name
     * @return DocBlockGenerator
     */
    abstract protected function getClassDocBlock($name);

    /**
     * @return array List of namespace imports
     */
    protected function getUses()
    {
        return [];
    }

    /**
     * @return array List of class methods
     */
    protected function getMethods()
    {
        return [];
    }

    /**
     * @return array List of implemented interfaces
     */
    protected function getImplementedInterfaces()
    {
        return [];
    }

    /**
     * @return array List of class properties
     */
    protected function getClassProperties()
    {
        return [];
    }

    /**
     * @return null|array List of class flags
     */
    protected function getClassFlags()
    {
        return [ClassGenerator::FLAG_FINAL];
    }
}
