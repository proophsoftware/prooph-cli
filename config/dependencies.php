<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

return [
    'services' => [
        'config' => require __DIR__ . '/config.php',
    ],
    'invokables' => [
        \Prooph\Cli\Code\Generator\Aggregate::class => '\Prooph\Cli\Code\Generator\Aggregate',
        \Prooph\Cli\Code\Generator\Command::class => '\Prooph\Cli\Code\Generator\Command',
        \Prooph\Cli\Code\Generator\CommandHandler::class => '\Prooph\Cli\Code\Generator\CommandHandler',
        \Prooph\Cli\Code\Generator\CommandHandlerFactory::class => '\Prooph\Cli\Code\Generator\CommandHandlerFactory',
        \Prooph\Cli\Code\Generator\Event::class => '\Prooph\Cli\Code\Generator\Event',
        \Prooph\Cli\Console\Command\GenerateAll::class => \Prooph\Cli\Console\Command\GenerateAll::class,
    ],
    'factories' => [
        \Prooph\Cli\Console\Command\GenerateAggregate::class
            => '\Prooph\Cli\Console\Container\GenerateAggregateFactory',
        \Prooph\Cli\Console\Command\GenerateCommand::class => '\Prooph\Cli\Console\Container\GenerateCommandFactory',
        \Prooph\Cli\Console\Command\GenerateEvent::class => '\Prooph\Cli\Console\Container\GenerateEventFactory',
    ],
];
