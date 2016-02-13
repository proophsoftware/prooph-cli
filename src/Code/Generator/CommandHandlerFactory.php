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
use Zend\Code\Generator\DocBlock\Tag\ReturnTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ParameterGenerator;

/**
 * Generates the factory for a command handler
 */
class CommandHandlerFactory extends AbstractGenerator
{
    /**
     * Namespace imports
     *
     * @var array
     */
    private $uses = [];

    /**
     * @interitdoc
     */
    protected function getClassDocBlock($name)
    {
        return new DocBlockGenerator('Factory for command handler ' . $name);
    }

    /**
     * @inheritDoc
     */
    protected function getUses()
    {
        return $this->uses;
    }

    /**
     * @inheritDoc
     */
    protected function getMethods($name, $namespace)
    {
        return [
            $this->methodInvoke($name, $namespace),
        ];
    }

    /**
     * Build __invoke method
     *
     * @param string $name
     * @param string $namespace
     * @return MethodGenerator
     */
    private function methodInvoke($name, $namespace)
    {
        $name = ucfirst($name);

        $parameters = [
            new ParameterGenerator('container', '\Interop\Container\ContainerInterface'),
        ];
        $this->uses[] = 'Interop\Container\ContainerInterface';

        return new MethodGenerator(
            '__invoke',
            $parameters,
            MethodGenerator::FLAG_PUBLIC,
            sprintf('return new %sHandler();', $name),
            new DocBlockGenerator(
                'Creates command handler for command ' . $name,
                null,
                [
                    new ParamTag(
                        'container',
                        [
                            '\Interop\Container\ContainerInterface',
                        ]
                    ),
                    new ReturnTag([$name . 'Handler']),
                ]
            )
        );
    }
}
