<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli;

use Prooph\Cli\Console\Helper\ClassInfo;

/**
 * Used to load generated classes if no autoloader is configured, because \Reflection tries to load the class if it is
 * used on code generation
 */
final class Autoloader
{
    /**
     * Class info
     *
     * @var ClassInfo
     */
    private $classInfo;

    /**
     * @param ClassInfo $classInfo
     */
    public function __construct(ClassInfo $classInfo)
    {
        $this->classInfo = $classInfo;
    }

    /**
     * Loads class depending on class info
     *
     * @param string $class
     * @return bool
     */
    public function __invoke($class)
    {
        $file = $this->classInfo->getFilename(
            $this->classInfo->getPath($class),
            $this->classInfo->getClassName($class)
        );

        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}
