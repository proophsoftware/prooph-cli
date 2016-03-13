<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Helper;

use Symfony\Component\Console\Helper\HelperInterface;

/**
 * Interface ClassInfo
 *
 * You can write your own info class e.g. for PSR-0 or with a predefined package prefix, source folder and file doc
 * block
 */
interface ClassInfo extends HelperInterface
{
    /**
     * PSR-4 namespace prefix
     *
     * @return string
     */
    public function getPackagePrefix();

    /**
     * PSR-4 namespace prefix
     *
     * @param string
     */
    public function setPackagePrefix($packagePrefix);

    /**
     * PSR-4 source folder
     *
     * @return string
     */
    public function getSourceFolder();

    /**
     * PSR-4 source folder
     *
     * @param string
     */
    public function setSourceFolder($sourceFolder);

    /**
     * Class namespace is determined by package prefix, source folder and given path.
     *
     * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md#3-examples
     *
     * @param string $path
     * @return string
     */
    public function getClassNamespace($path);

    /**
     * Extracts class name from FQCN
     *
     * @param string $fqcn Full class qualified name
     * @return string Class name
     */
    public function getClassName($fqcn);

    /**
     * Path is extracted from class name by using package prefix and source folder
     *
     * @param string $fqcn
     * @return string
     */
    public function getPath($fqcn);

    /**
     * Returns path to file with source folder
     *
     * @param string $path Path without source folder
     * @param string $name Class name
     * @return string
     */
    public function getFilename($path, $name);

    /**
     * PHPDoc file doc block for copyright, license ...
     *
     * @return string
     */
    public function getFileDocBlock();

    /**
     * PHPDoc file doc block for copyright, license ...
     *
     * @param string $fileDocBlock
     */
    public function setFileDocBlock($fileDocBlock);
}
