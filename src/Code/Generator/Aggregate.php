<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Code\Generator;

use Zend\Code\Generator\DocBlockGenerator;

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
}
