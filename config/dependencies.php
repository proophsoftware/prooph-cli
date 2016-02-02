<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */


use Zend\ServiceManager\Factory\InvokableFactory;
use Prooph\Cli\Console\Container;
use Prooph\Cli\Code\Generator;
use Prooph\Cli\Console\Command;

return [
    'services' => [
        'config' => require __DIR__ . '/config.php',
    ],
    'factories' => [
        // generators
        Generator\Aggregate::class => InvokableFactory::class,
        Generator\Command::class => InvokableFactory::class,
        Generator\CommandHandler::class => InvokableFactory::class,
        Generator\CommandHandlerFactory::class => InvokableFactory::class,
        Generator\Event::class => InvokableFactory::class,
        // commands
        Command\GenerateAggregate::class => Container\GenerateAggregateFactory::class,
        Command\GenerateAll::class => InvokableFactory::class,
        Command\GenerateCommand::class => Container\GenerateCommandFactory::class,
        Command\GenerateEvent::class =>  Container\GenerateEventFactory::class,
    ],
];
