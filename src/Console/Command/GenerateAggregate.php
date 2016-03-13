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
use Prooph\Cli\Code\Generator\Aggregate as AggregateGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateAggregate extends AbstractGenerateCommand
{
    /**
     * @var AggregateGenerator
     */
    private $generator;

    /**
     * GenerateEvent constructor.
     * @param AggregateGenerator $generator
     */
    public function __construct(AggregateGenerator $generator)
    {
        $this->generator = $generator;

        parent::__construct();
    }

    /**
     * @interitdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getOption('disable-type-prefix')) {
            $input->setArgument('path', $input->getArgument('path') . '/Aggregate');
        }

        $this->generateClass($input, $output, $this->generator);
    }

    protected function configure()
    {
        $this
            ->setName('prooph:generate:aggregate')
            ->setDescription('Generates an aggregate class')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'What is the name of the aggregate class?'
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
                '\Prooph\EventSourcing\AggregateRoot'
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
                'Use this flag if you not want to put the classes under the "Aggregate" namespace, optional'
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
}
