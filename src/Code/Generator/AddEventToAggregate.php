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
use Zend\Code\Reflection\FileReflection;

/**
 * Adds the event method to the aggregate to update aggregate data
 */
class AddEventToAggregate implements ReflectionGenerator
{
    use ReplaceNamespaceTrait;

    /**
     * @inheritDoc
     */
    public function __invoke($file, $namespace, $commandName)
    {
        $commandName = ucfirst($commandName);

        require $file;

        $reflectionClass = new FileReflection($file);
        $fileGenerator = FileGenerator::fromReflection($reflectionClass);
        $fileGenerator->setFilename($file);

        $classGenerator = $fileGenerator->getClass();

        /* @var $method MethodGenerator */
        foreach ($classGenerator->getMethods() as $method) {
            if (strpos($method->getName(), 'when') !== 0) {
                continue;
            }
            /* @var $parameter ParameterGenerator */
            foreach ($method->getParameters() as $parameter) {
                $fileGenerator->setUse($parameter->getType());
            }
        }

        $namespace = ltrim($namespace, '\\') . '\\';
        $fileGenerator->setUse($namespace . $commandName);


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
        file_put_contents($fileGenerator->getFilename(), $this->replaceNamespace($fileGenerator));
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
                'Updates aggregate if event ' . $name . ' was occurred',
                null,
                [
                    new ParamTag('event', [ '\\' . $namespace . $name]),
                ]
            )
        );
    }
}
