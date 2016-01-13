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
 * Generates a command
 */
class Command extends AbstractGenerator
{
    /**
     * Namespace imports
     *
     * @var array
     */
    private $uses = [];

    /**
     * @inheritDoc
     */
    protected function getUses()
    {
        return $this->uses;
    }

    /**
     * @interitdoc
     */
    protected function getClassDocBlock($name)
    {
        return new DocBlockGenerator('Command ' . $name);
    }

    /**
     * @inheritDoc
     */
    protected function getImplementedInterfaces()
    {
        $this->uses[] = 'Prooph\Common\Messaging\PayloadConstructable';
        return ['PayloadConstructable'];
    }

    /**
     * @inheritDoc
     */
    protected function getTraits()
    {
        $this->uses[] = 'Prooph\Common\Messaging\PayloadTrait';
        return ['PayloadTrait'];
    }
}
