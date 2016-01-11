<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Command;

use Prooph\Cli\Code\Generator\AbstractGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Prooph\Cli\Code\Generator\Event as EventGenerator;
use Symfony\Component\Console\Input\InputOption;

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
     * @inheritDoc
     */
    protected function getGenerator()
    {
        return $this->generator;
    }

    /**
     * @interitdoc
     */
    protected function configure()
    {
        $this
            ->setName('prooph:event')
            ->setDescription('Generates an event class')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'What is the name of the event?'
            )
            ->addArgument(
                'path',
                InputArgument::OPTIONAL,
                'Path to store the file',
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
