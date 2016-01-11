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
use Prooph\Cli\Console\Helper\ClassInfo;
use Prooph\Cli\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\Code\Generator\ClassGenerator;

abstract class AbstractCommand extends Command
{
    /**
     * @return AbstractGenerator
     */
    abstract protected function getGenerator();

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

        $fileGenerator = $this->getGenerator()->__invoke(
            $name, $classInfo->getClassNamespace($path, $name), $classToExtend, $classInfo->getFileDocBlock()
        );

        if ($input->getOption('not-final')) {
            $fileGenerator->getClass()->removeFlag(ClassGenerator::FLAG_FINAL);
        }

        $this->getGenerator()->writeClass($filename, $fileGenerator);
        $output->writeln('Generated file ' . $filename);
    }
}
