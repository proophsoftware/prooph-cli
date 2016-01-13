<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Code\Generator;

use Zend\Code\Generator\DocBlock\Tag\GenericTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\MethodGenerator;

/**
 * Generator for aggregates
 */
class Aggregate extends AbstractGenerator
{
    /**
     * @interitdoc
     */
    protected function getClassDocBlock($name)
    {
        return new DocBlockGenerator('Aggregate ' . $name);
    }

    /**
     * @inheritDoc
     */
    protected function getMethods($name)
    {
        return [
            $this->methodAggregateId(),
        ];
    }

    /**
     * Build __invoke method
     *
     * @return MethodGenerator
     */
    private function methodAggregateId()
    {
        return new MethodGenerator(
            'aggregateId',
            [],
            MethodGenerator::FLAG_PROTECTED,
            'return ;',
            new DocBlockGenerator(
                null,
                null,
                [
                    new GenericTag('inheritDoc'),
                ]
            )
        );
    }
}
