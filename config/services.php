<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

$config = new Config(require __DIR__ . '/dependencies.php');

$serviceManager = new ServiceManager();
$config->configureServiceManager($serviceManager);
unset($config);

return $serviceManager;
