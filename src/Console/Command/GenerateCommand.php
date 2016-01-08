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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
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

    public function __construct(
        CommandGenerator $commandGenerator,
        CommandHandlerGenerator $handlerGenerator,
        CommandHandlerFactoryGenerator $factoryGenerator)
    {
        $this->commandGenerator = $commandGenerator;
        $this->commandHandlerGenerator = $handlerGenerator;
        $this->commandHandlerFactoryGenerator = $factoryGenerator;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('prooph:command')
            ->setDescription('Generates a command, command handler and command handler factory class')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'What is the name of the command class?'
            )
            ->addArgument(
                'path',
                InputArgument::OPTIONAL,
                'The path where to save the classes. Starts from configured source folder path.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
    }
}
