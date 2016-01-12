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

/**
 * Interface ReflectionGenerator
 *
 * Used by generators which updates code of a class
 */
interface ReflectionGenerator
{
    /**
     * Updates class
     *
     * @param string $fcqn
     * @param string $namespace
     * @param string $commandName Event
     * @return FileGenerator
     */
    public function __invoke($fcqn, $namespace, $commandName);

    /**
     * Writes class to disk. Filename must be set in FileGenerator instance
     *
     * @param FileGenerator $fileGenerator
     */
    public function writeClass(FileGenerator $fileGenerator);
}
