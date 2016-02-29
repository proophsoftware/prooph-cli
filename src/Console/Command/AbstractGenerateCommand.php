<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Command;

use Prooph\Cli\Code\Generator\Generator;
use Prooph\Cli\Code\Generator\ReflectionGenerator;
use Prooph\Cli\Console\Helper\ClassInfo;
use Prooph\Cli\Exception\FileExistsException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;

abstract class AbstractGenerateCommand extends Command
{
    protected function generateClass(InputInterface $input, OutputInterface $output, Generator $generator)
    {
        $name = $input->getArgument('name');
        $path = $input->getArgument('path');
        $classToExtend = $input->getArgument('class-to-extend');

        /* @var $classInfo ClassInfo */
        $classInfo = $this->getHelper(ClassInfo::class);

        if ($input->getOption('source-folder')) {
            $classInfo->setSourceFolder($input->getOption('source-folder'));
        }
        if ($input->getOption('package-prefix')) {
            $classInfo->setPackagePrefix($input->getOption('package-prefix'));
        }
        if ($input->getOption('file-doc-block')) {
            $classInfo->setFileDocBlock($input->getOption('file-doc-block'));
        }

        switch (get_class($generator)) {
            case 'Prooph\Cli\Code\Generator\CommandHandler':
                $className = $name . 'Handler';
                break;
            case 'Prooph\Cli\Code\Generator\CommandHandlerFactory':
                $className = $name . 'HandlerFactory';
                break;
            default:
                $className = $name;
                break;
        }

        $filename = $classInfo->getFilename($path, $className);

        if (file_exists($filename) && !$input->getOption('force')) {
            throw new FileExistsException(
                sprintf('File "%s" already exists, use --force option to overwrite this file.', $filename)
            );
        }
        /* @var $fileGenerator FileGenerator */
        $fileGenerator = $generator(
            $name, $classInfo->getClassNamespace($path), $classToExtend, $classInfo->getFileDocBlock()
        );

        if ($input->getOption('not-final')) {
            $fileGenerator->getClass()->removeFlag(ClassGenerator::FLAG_FINAL);
        }

        $generator->writeClass($filename, $fileGenerator);
        $output->writeln('<info>Generated file ' . $filename, '</info>');
    }

    /**
     * @param string $fcqn
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param ReflectionGenerator $generator
     */
    protected function updateExistingClass(
        $fcqn, InputInterface $input, OutputInterface $output, ReflectionGenerator $generator
    ) {
        // don't break code generation, this is only a benefit
        if (!class_exists($fcqn)) {
            $output->writeln(
                sprintf('<comment>Event method was not added to the aggregate. Class "%s" not found.</comment>', $fcqn)
            );
            return;
        }

        /* @var $classInfo ClassInfo */
        $classInfo = $this->getHelper(ClassInfo::class);
        $path = $input->getArgument('path');

        /* @var $fileGenerator FileGenerator */
        $fileGenerator = $generator($fcqn, $classInfo->getClassNamespace($path), $input->getArgument('name'));

        $generator->writeClass($fileGenerator);
        $output->writeln('<info>Updated file ' . $fileGenerator->getFilename() . '</info>');
    }
}
