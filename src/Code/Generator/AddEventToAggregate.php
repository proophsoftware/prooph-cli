<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Code\Generator;

use Zend\Code\Generator\DocBlock\Tag\ParamTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Reflection\ClassReflection;

/**
 * Adds the event method to the aggregate to update aggregate data
 */
class AddEventToAggregate implements ReflectionGenerator
{
    /**
     * @inheritDoc
     */
    public function __invoke($fcqn, $namespace, $commandName)
    {
        $commandName = ucfirst($commandName);

        $reflectionClass = new ClassReflection($fcqn);

        $fileGenerator = FileGenerator::fromReflectedFileName($reflectionClass->getFileName());
        $fileGenerator->setFilename($reflectionClass->getFileName());

        $namespace = ltrim($namespace, '\\') . '\\';
        $fileGenerator->setUse($namespace . $commandName);

        $classGenerator = $fileGenerator->getClass();

        // workaround for import namespace
        if ($classToExtend = $classGenerator->getExtendedClass()) {
            $classGenerator->setExtendedClass(substr($classToExtend, strrpos($classToExtend, '\\') + 1));
        }

        $classGenerator->addMethodFromGenerator($this->methodWhenEvent($commandName, $namespace));

        return $fileGenerator;
    }

    /**
     * @inheritDoc
     */
    public function writeClass(FileGenerator $fileGenerator)
    {
        file_put_contents($fileGenerator->getFilename(), $fileGenerator->generate());
    }

    /**
     * Build when[Event]() method
     *
     * @param string $name
     * @return MethodGenerator
     */
    private function methodWhenEvent($name, $namespace)
    {
        $parameters = [
            new ParameterGenerator(
                'event', '\\' . $namespace . $name
            ),
        ];

        return new MethodGenerator(
            'when' . $name,
            $parameters,
            MethodGenerator::FLAG_PROTECTED,
            '',
            new DocBlockGenerator(
                'Updates aggregate if event was occurred',
                null,
                [
                    new ParamTag('event', [ '\\' . $namespace . $name]),
                ]
            )
        );
    }
}
