<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Command;

use Prooph\Cli\Console\Helper\ClassInfo;
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
            ->setName('prooph:generate:all')
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
            ->addArgument(
                'path',
                InputArgument::OPTIONAL,
                'Path to store the files. Starts from configured source folder path.'
            )
            ->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Overwrite all files if exists, optional'
            )
            ->addOption(
                'not-final',
                null,
                InputOption::VALUE_NONE,
                'Mark class as NOT final, optional'
            )
            ->addOption(
                'disable-type-prefix',
                null,
                InputOption::VALUE_NONE,
                'Use this flag if you not want to put the classes under the specific type namespace, optional'
            )
            ->addOption(
                'source-folder',
                null,
                InputOption::VALUE_OPTIONAL,
                'Absolute path to the source folder.'
            )
            ->addOption(
                'package-prefix',
                null,
                InputOption::VALUE_OPTIONAL,
                'Package prefix which is used as class namespace.'
            )
            ->addOption(
                'file-doc-block',
                null,
                InputOption::VALUE_OPTIONAL,
                'Common PHP file doc block.'
            );
    }

    /**
     * @interitdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = [
            'aggregate' => $input->getArgument('aggregate-name'),
            'command' =>  $input->getArgument('command-name'),
            'event' =>  $input->getArgument('event-name'),
        ];

        $path = $input->getArgument('path');

        $aggregatePath = '';

        foreach ($commands as $commandName => $name) {
            $command = $this->getApplication()->find('prooph:generate:' . $commandName);

            $arguments = [
                'name'    => $name,
                'path' => $path,
                '--force' => $input->getOption('force'),
                '--not-final' => $input->getOption('not-final'),
                '--disable-type-prefix' => $input->getOption('disable-type-prefix'),
            ];

            if ($commandName === 'aggregate' && !$input->getOption('disable-type-prefix')) {
                $aggregatePath = rtrim($path, '/') . '/Aggregate';
            }

            /* @var $classInfo ClassInfo */
            $classInfo = $this->getHelper(ClassInfo::class);

            if ($commandName === 'event') {
                $arguments['--update-aggregate'] = $classInfo->getClassNamespace($aggregatePath) . '\\'
                    . $commands['aggregate'];
            }

            if ($input->getOption('source-folder')) {
                $classInfo->setSourceFolder($input->getOption('source-folder'));
            }
            if ($input->getOption('package-prefix')) {
                $classInfo->setPackagePrefix($input->getOption('package-prefix'));
            }
            if ($input->getOption('file-doc-block')) {
                $classInfo->setFileDocBlock($input->getOption('file-doc-block'));
            }

            $command->run(new ArrayInput($arguments), $output);
        }
    }
}
