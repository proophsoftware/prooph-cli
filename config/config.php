<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\Glob;

/**
 * Configuration files are loaded in a specific order. First ``global.php``, then ``*.global.php``.
 * then ``local.php`` and finally ``*.local.php``. This way local settings overwrite global settings.
 */

$config = [
    'doctrine' => [
        'connection' => [
            'default' => [
                'driverClass' => getenv('DOCTRINE_DBAL_DRIVER') ?: 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'host' => getenv('DB_HOST') ?: 'localhost',
                'port' => '3306',
                'user' => getenv('DB_USERNAME') ?: 'root',
                'password' => getenv('DB_PASSWORD') ?: '',
                'dbname' => getenv('DB_DATABASE') ?: 'prooph',
                'charset' => 'utf8',
                'driverOptions' => [
                    1002 => "SET NAMES 'UTF8'"
                ],
            ],
        ],
    ],
];

// Load configuration from autoload path
foreach (Glob::glob('config/autoload/{{,*.}global,{,*.}local}.php', Glob::GLOB_BRACE) as $file) {
    $config = ArrayUtils::merge($config, include $file);
}

return $config;
