<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Helper;

use Symfony\Component\Console\Helper\Helper;

class MinimumInfo extends Helper implements ClassInfo
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return ClassInfo::class;
    }

    /**
     * @inheritDoc
     */
    public function getPackagePrefix()
    {
        return '\\';
    }

    /**
     * @inheritDoc
     */
    public function getSourceFolder()
    {
        return getcwd();
    }

    /**
     * @inheritDoc
     */
    public function getFileHeader()
    {
        return '';
    }
}
