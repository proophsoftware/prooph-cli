<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

/**
 * This makes our life easier when dealing with paths. Everything is relative to the application root now.
 */
chdir(dirname(__DIR__));

if (!file_exists('vendor/autoload.php')) {
    throw new \RuntimeException(
        'Unable to load application. Run `php composer.phar install`'
    );
}

// Setup autoloading
require 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use \Prooph\Cli\Console\Command;

/* @var $container \Zend\ServiceManager\ServiceManager */
$container = require 'config/services.php';

$cli = new Application('Prooph Command Line Interface');

$helperSet = new \Symfony\Component\Console\Helper\HelperSet();

$application = new Application();

$application->getHelperSet()->set(new \Prooph\Cli\Console\Helper\MinimumInfo());

//$application->add($container->get(Command\GenerateCommand::class));
//$application->add($container->get(Command\GenerateAll::class));
$application->add($container->get(Command\GenerateEvent::class));
$application->add($container->get(Command\GenerateAggregate::class));

$application->run();





