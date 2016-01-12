<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Prooph\Cli\Code\Generator\Event as EventGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateEvent extends AbstractCommand
{
    /**
     * @var EventGenerator
     */
    private $generator;

    /**
     * GenerateEvent constructor.
     * @param EventGenerator $generator
     */
    public function __construct(EventGenerator $generator)
    {
        $this->generator = $generator;

        parent::__construct();
    }

    /**
     * @interitdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->generateClass($input, $output, $this->generator);
    }

    /**
     * @interitdoc
     */
    protected function configure()
    {
        $this
            ->setName('prooph:generate:event')
            ->setDescription('Generates an event class')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'What is the name of the event?'
            )
            ->addArgument(
                'path',
                InputArgument::OPTIONAL,
                'Path to store the file. Starts from configured source folder path.',
                'Event'
            )
            ->addArgument(
                'class-to-extend',
                InputArgument::OPTIONAL,
                'FCQN of the base class , optional',
                '\Prooph\EventSourcing\AggregateChanged'
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
        ;
    }
}
