<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateAll extends Command
{
    protected function configure()
    {
        $this
            ->setName('prooph:all')
            ->setDescription(
                'Generates an aggregate, command, command handler, command handler factory and event class.'
            )
            ->addArgument(
                'command-name',
                InputArgument::REQUIRED,
                'What is the name of the command class?'
            )
            ->addArgument(
                'event-name',
                InputArgument::REQUIRED,
                'What is the name of the event class?'
            )
            ->addArgument(
                'aggregate-name',
                InputArgument::REQUIRED,
                'What is the name of the aggregate class?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
