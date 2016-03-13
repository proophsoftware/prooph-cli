<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Command;

use Prooph\Cli\Code\Generator\Command as CommandGenerator;
use Prooph\Cli\Code\Generator\CommandHandler as CommandHandlerGenerator;
use Prooph\Cli\Code\Generator\CommandHandlerFactory as CommandHandlerFactoryGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends AbstractGenerateCommand
{
    /**
     * @var CommandGenerator
     */
    private $commandGenerator;

    /**
     * @var CommandHandlerGenerator
     */
    private $commandHandlerGenerator;

    /**
     * @var CommandHandlerFactoryGenerator
     */
    private $commandHandlerFactoryGenerator;

    /**
     * GenerateCommand constructor.
     * @param CommandGenerator $generator
     * @param CommandHandlerGenerator $handlerGenerator
     * @param CommandHandlerFactoryGenerator $factoryGenerator
     */
    public function __construct(
        CommandGenerator $generator,
        CommandHandlerGenerator $handlerGenerator,
        CommandHandlerFactoryGenerator $factoryGenerator)
    {
        $this->commandGenerator = $generator;
        $this->commandHandlerGenerator = $handlerGenerator;
        $this->commandHandlerFactoryGenerator = $factoryGenerator;

        parent::__construct();
    }

    /**
     * @interitdoc
     */
    protected function configure()
    {
        $this
            ->setName('prooph:generate:command')
            ->setDescription('Generates a command, command handler and command handler factory class')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'What is the name of the command class?'
            )
            ->addArgument(
                'path',
                InputArgument::OPTIONAL,
                'Path to store the file. Starts from configured source folder path.'
            )
            ->addArgument(
                'class-to-extend',
                InputArgument::OPTIONAL,
                'FQCN of the base class , optional',
                '\Prooph\Common\Messaging\Command'
            )
            ->addOption(
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
            ->addOption(
                'disable-type-prefix',
                null,
                InputOption::VALUE_NONE,
                'Use this flag if you not want to put the classes under the "Command" namespace, optional'
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
        if (!$input->getOption('disable-type-prefix')) {
            $input->setArgument('path', $input->getArgument('path') . '/Command');
        }

        $this->generateClass($input, $output, $this->commandGenerator);

        $input->setArgument('class-to-extend', '');

        $this->generateClass($input, $output, $this->commandHandlerGenerator);
        $this->generateClass($input, $output, $this->commandHandlerFactoryGenerator);
    }
}
