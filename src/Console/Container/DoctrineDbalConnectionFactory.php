<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace Prooph\Cli\Console\Container;

use Doctrine\DBAL\DriverManager;
use Interop\Config\ConfigurationTrait;
use Interop\Config\RequiresContainerId;
use Interop\Config\RequiresMandatoryOptions;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Creates a Doctrine DBAL connection
 */
class DoctrineDbalConnectionFactory implements FactoryInterface, RequiresContainerId, RequiresMandatoryOptions
{
    use ConfigurationTrait;

    /**
     * @inheritDoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator);
    }

    /**
     * @param ContainerInterface $container
     * @return \Doctrine\DBAL\Connection
     */
    public function __invoke(ContainerInterface $container)
    {
        return DriverManager::getConnection($this->options($container->get('config')));
    }

    /**
     * @inheritdoc
     */
    public function vendorName()
    {
        return 'doctrine';
    }

    /**
     * @inheritdoc
     */
    public function packageName()
    {
        return 'connection';
    }

    /**
     * @inheritdoc
     */
    public function containerId()
    {
        return 'default';
    }

    /**
     * @inheritdoc
     */
    public function mandatoryOptions()
    {
        return ['driverClass'];
    }
}
