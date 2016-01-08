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

interface ClassInfo extends HelperInterface
{
    /**
     * PSR-0 or PSR-4 namespace prefix
     *
     * @return string
     */
    public function getPackagePrefix();

    /**
     * PSR-4 source folder
     *
     * @return string
     */
    public function getSourceFolder();

    /**
     * PHPDoc file DocBlock
     *
     * @return string
     */
    public function getFileHeader();
}
