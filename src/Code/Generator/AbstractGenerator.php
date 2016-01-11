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
        $interfaces = $this->getImplementedInterfaces();
        $properties = $this->getClassProperties();
        $flags = $this->getClassFlags();
        $methods = $this->getMethods($name);
        $uses = $this->getUses();

        $fileDocBlock = new DocBlockGenerator($fileDocBlock);

        if ($classToExtend) {
            $uses[] = ltrim($classToExtend, '\\');
            $classToExtend = substr($classToExtend, strrpos($classToExtend, '\\') + 1);
        }

        switch (get_class($this)) {
            case 'Prooph\Cli\Code\Generator\CommandHandler':
                $className = $name . 'Handler';
                break;
            case 'Prooph\Cli\Code\Generator\CommandHandlerFactory':
                $className = $name . 'HandlerFactory';
                break;
            default:
                $className = $name;
                break;
        }

        $class = new ClassGenerator(
            $className,
            $namespace,
            $flags,
            $classToExtend,
            $interfaces,
            $properties,
            $methods,
            $this->getClassDocBlock($name)
        );

        foreach ($this->getTraits() as $trait) {
            $class->addTrait($trait);
        }

        return new FileGenerator([
            'classes' => [$class],
            'namespace' => $namespace,
            'uses' => $uses,
            'docBlock' => $fileDocBlock
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
     * @param string $name
     * @return array List of class methods
     */
    protected function getMethods($name)
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

    /**
     * @return null|array List of used Traits
     */
    protected function getTraits()
    {
        return [];
    }
}
