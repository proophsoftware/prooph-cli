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
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateAll extends Command
{
    /**
     * @interitdoc
     */
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
            )->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Overwrite file if exists, optional'
            )
            ->addOption(
                'not-final',
                null,
                InputOption::VALUE_NONE,
                'Mark class as NOT final, optional'
            )
        ;
    }

    /**
     * @interitdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = [
            'event' =>  $input->getArgument('event-name'),
            'aggregate' => $input->getArgument('aggregate-name'),
            'command' =>  $input->getArgument('command-name'),
        ];

        foreach ($commands as $commandName => $name) {
            $command = $this->getApplication()->find('prooph:' . $commandName);

            $arguments = [
                'name'    => $name,
                '--force' => $input->getOption('force'),
                '--not-final' => $input->getOption('not-final'),
            ];

            $command->run(new ArrayInput($arguments), $output);
        }
    }
}
