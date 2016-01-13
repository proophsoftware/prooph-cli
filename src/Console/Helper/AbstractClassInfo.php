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
use Symfony\Component\Console\Helper\HelperSet;

/**
 * Abstract class for console helpers
 *
 * Implements common functions for \Symfony\Component\Console\Helper\HelperInterface
 */
abstract class AbstractClassInfo implements HelperInterface
{
    private $helperSet;

    /**
     * Sets the helper set associated with this helper.
     *
     * @param HelperSet $helperSet A HelperSet instance
     */
    public function setHelperSet(HelperSet $helperSet = null)
    {
        $this->helperSet = $helperSet;
    }

    /**
     * Gets the helper set associated with this helper.
     *
     * @return HelperSet A HelperSet instance
     */
    public function getHelperSet()
    {
        return $this->helperSet;
    }
}
