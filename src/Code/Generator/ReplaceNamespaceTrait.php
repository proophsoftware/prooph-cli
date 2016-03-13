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
 * Workaround for Zend\Code which does not support namespace imports for parameter types
 */
trait ReplaceNamespaceTrait
{
    /**
     * Search for unnecessary namespace imports and definitions and replace occurrences.
     *
     * @param FileGenerator $fileGenerator
     * @return string Generated code
     */
    public function replaceNamespace(FileGenerator $fileGenerator)
    {
        $uses = [];
        $search = [];
        $replace = [];

        foreach ($fileGenerator->getUses() as $import) {
            $namespace = trim(substr($import[0], 0, strrpos($import[0], '\\')), '\\');

            if ($fileGenerator->getNamespace() !== $namespace) {
                $uses[] = $import;
            }

            $name = trim(substr($import[0], strrpos($import[0], '\\')), '\\');
            $search[] = '\\' . $import[0];
            $search[] = ', \\' . $import[0];
            $replace[] = $name;
            $replace[] = ', ' . $name;
        }
        // workaround to reset use imports
        $reflection = new \ReflectionClass($fileGenerator);
        $property = $reflection->getProperty('uses');
        $property->setAccessible(true);
        $property->setValue($fileGenerator, $uses);

        $code = $fileGenerator->generate();
        return str_replace($search, $replace, $code);
    }
}
