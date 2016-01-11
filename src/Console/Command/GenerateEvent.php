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
use Prooph\Cli\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Prooph\Cli\Code\Generator\Event as EventGenerator;

class GenerateEvent extends Command
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
                InputArgument::OPTIONAL,
                'Overwrite file if exists, optional'
            )
        ;
    }

    /**
     * @interitdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $path = $input->getArgument('path');
        $classToExtend = $input->getArgument('class-to-extend');

        /* @var $classInfo ClassInfo */
        $classInfo = $this->getHelper(ClassInfo::class);

        $filename = $classInfo->getFilename($path, $name);

        if (file_exists($filename) && !$input->getOption('force')) {
            throw new RuntimeException(
                sprintf('File "%s" already exists, use --force option to overwrite this file.', $filename)
            );
        }

        $fileGenerator = $this->generator->__invoke(
            $name, $classInfo->getClassNamespace($path, $name), $classToExtend, $classInfo->getFileDocBlock()
        );

        $this->generator->writeClass($filename, $fileGenerator);
        $output->writeln('Generated file ' . $filename);
    }
}
