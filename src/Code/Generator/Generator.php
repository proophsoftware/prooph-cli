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

interface Generator
{
    /**
     * Generates class
     *
     * @param $name
     * @param $namespace
     * @param $classToExtend
     * @param null $fileDocBlock
     * @return FileGenerator
     */
    public function __invoke($name, $namespace, $classToExtend, $fileDocBlock = null);

    /**
     * Writes class to disk.
     *
     * @param $filename
     * @param FileGenerator $fileGenerator
     */
    public function writeClass($filename, FileGenerator $fileGenerator);
}
