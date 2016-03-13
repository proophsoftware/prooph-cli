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
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ParameterGenerator;

/**
 * Generates the command handler for a command
 */
class CommandHandler extends AbstractGenerator
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
        return new DocBlockGenerator('Command handler for command ' . $name);
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
     * @param $namespace
     * @return MethodGenerator
     */
    private function methodInvoke($name, $namespace)
    {
        $name = ucfirst($name);

        $this->uses[] = $namespace . '\\' . $name;

        $namespace = '\\' . $namespace . '\\';

        $parameters = [
            new ParameterGenerator(
                'command', $namespace . $name
            ),
        ];

        return new MethodGenerator(
            '__invoke',
            $parameters,
            MethodGenerator::FLAG_PUBLIC,
            '',
            new DocBlockGenerator(
                'Handle command',
                null,
                [
                    new ParamTag('command', [ $namespace . $name]),
                ]
            )
        );
    }
}
