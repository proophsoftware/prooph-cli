<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */


use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'services' => [
        'config' => require __DIR__ . '/config.php',
    ],
    'factories' => [
        \Prooph\Cli\Code\Generator\Aggregate::class => InvokableFactory::class,
        \Prooph\Cli\Code\Generator\Command::class => InvokableFactory::class,
        \Prooph\Cli\Code\Generator\CommandHandler::class => InvokableFactory::class,
        \Prooph\Cli\Code\Generator\CommandHandlerFactory::class => InvokableFactory::class,
        \Prooph\Cli\Code\Generator\Event::class => InvokableFactory::class,
        \Prooph\Cli\Console\Command\GenerateAll::class => InvokableFactory::class,
        \Prooph\Cli\Console\Command\GenerateAggregate::class
            => '\Prooph\Cli\Console\Container\GenerateAggregateFactory',
        \Prooph\Cli\Console\Command\GenerateCommand::class => '\Prooph\Cli\Console\Container\GenerateCommandFactory',
        \Prooph\Cli\Console\Command\GenerateEvent::class => '\Prooph\Cli\Console\Container\GenerateEventFactory',
    ],
];
