<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Container;

use Interop\Container\ContainerInterface;
use Prooph\Cli\Console\Command\GenerateCommand;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GenerateCommandFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator);
    }

    /**
     * @param ContainerInterface $container
     * @return GenerateCommand
     */
    public function __invoke(ContainerInterface $container)
    {
        return new GenerateCommand(
            $container->get(\Prooph\Cli\Code\Generator\Command::class),
            $container->get(\Prooph\Cli\Code\Generator\CommandHandler::class),
            $container->get(\Prooph\Cli\Code\Generator\CommandHandlerFactory::class)
        );
    }
}
