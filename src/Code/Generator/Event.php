<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Code\Generator;

use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\ClassGenerator;

/**
 * Generator class for Events
 */
final class Event extends AbstractGenerator
{
    /**
     * @inheritdoc
     */
    public function __invoke($name, $namespace, $classToExtend, $fileDocBlock = null)
    {
        $methods = [];
        $uses = [];
        $interfaces = [];
        $properties = [];
        $docBlock = '';
        $flags = null;

        if ($fileDocBlock) {
            $docBlock = new DocBlockGenerator($docBlock);
        }

        if ($classToExtend) {
            $uses = [$classToExtend];
        }

        $class = new ClassGenerator(
            $name,
            $namespace,
            $flags,
            $classToExtend,
            $interfaces,
            $properties,
            $methods,
            new DocBlockGenerator('Event ' . $name)
        );

        return new FileGenerator([
            'classes' => [$class],
            'namespace' => $namespace,
            'uses' => $uses,
            'docBlock' => $docBlock
        ]);
    }
}
