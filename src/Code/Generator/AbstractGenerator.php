<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Code\Generator;

use Prooph\Cli\Exception\RuntimeException;
use Zend\Code\Generator\FileGenerator;

abstract class AbstractGenerator
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
    abstract public function __invoke($name, $namespace, $classToExtend, $fileDocBlock = null);

    /**
     * Writes class to disk.
     *
     * @param $filename
     * @param FileGenerator $fileGenerator
     */
    public function writeClass($filename, FileGenerator $fileGenerator)
    {
        $dir = dirname($filename);

        if (!@mkdir($dir, 0755, true) && !is_dir($dir)) {
            throw new RuntimeException(sprintf('Could not create "%s" directory.', $dir));
        }
        file_put_contents($filename, $fileGenerator->generate());
    }
}
