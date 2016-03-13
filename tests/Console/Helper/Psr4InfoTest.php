<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/proophsoftware/prooph-cli for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/proophsoftware/prooph-cli/blob/master/LICENSE.md New BSD License
 */

namespace ProophTest\Cli\Console\Helper;

use PHPUnit_Framework_TestCase as TestCase;
use Prooph\Cli\Console\Helper\Psr4Info;

class Psr4InfoTest extends TestCase
{
    /**
     * @test
     * @dataProvider providerForGetClassNamespace
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::__construct
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::getClassNamespace
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::filterDirectoryToNamespace
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::normalizeNamespace
     */
    public function it_returns_class_namespace_from_path($expected, $sourceFolder, $packagePrefix, $path)
    {
        $psr4Info = new Psr4Info($sourceFolder, $packagePrefix);

        self::assertSame($expected, $psr4Info->getClassNamespace($path));
    }

    /**
     * Values are expected, sourceFolder, packagePrefix and path
     *
     * @return array
     */
    public function providerForGetClassNamespace()
    {
        return [
            [
                'MyVendor\MyPackage\ModelPath\UserPath',
                'src',
                '\MyVendor\MyPackage\\',
                'ModelPath/UserPath',
            ],
            [
                'MyVendor\MyPackage\ModelPath\UserPath',
                'src',
                '\\MyVendor\\MyPackage\\',
                '/ModelPath/UserPath/',
            ],
            [
                'Vendor\Package\Model\User',
                'src',
                'vendor\package',
                'model/user/',
            ],
            [
                'Vendor\Package',
                'src',
                'vendor\package',
                '',
            ],
            [
                'Vendor',
                'src',
                'vendor',
                '',
            ],
            [
                '',
                'src',
                '',
                '',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider providerForGetPath
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::__construct
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::getPath
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::filterNamespaceToDirectory
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::normalizeNamespace
     */
    public function it_returns_path_from_namespace($expected, $sourceFolder, $packagePrefix, $fcqn)
    {
        $psr4Info = new Psr4Info($sourceFolder, $packagePrefix);

        self::assertSame($expected, $psr4Info->getPath($fcqn));
    }

    /**
     * Values are expected, sourceFolder, packagePrefix and fcqn
     *
     * @return array
     */
    public function providerForGetPath()
    {
        return [
            [
                'ModelPath/UserPath',
                'src',
                '\MyVendor\MyPackage\\',
                '\MyVendor\MyPackage\ModelPath\UserPath\User',
            ],
            [
                'ModelPath/UserPath',
                'src',
                '\\MyVendor\\MyPackage\\',
                '\\MyVendor\\MyPackage\\ModelPath\\UserPath\\User',
            ],
            [
                '',
                'src',
                'MyVendor\MyPackage',
                'MyVendor\MyPackage\User',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider providerForGetFilename
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::__construct
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::getFilename
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::normalizePath
     */
    public function it_returns_filename($expected, $sourceFolder, $packagePrefix, $path, $name)
    {
        $psr4Info = new Psr4Info($sourceFolder, $packagePrefix);

        self::assertSame($expected, $psr4Info->getFilename($path, $name));
    }

    /**
     * Values are expected, sourceFolder, packagePrefix, path and name
     *
     * @return array
     */
    public function providerForGetFilename()
    {
        return [
            [
                'src/ModelPath/UserPath/User.php',
                'src',
                '\MyVendor\MyPackage\\',
                'ModelPath/UserPath',
                'User'
            ],
            [
                'src/ModelPath/UserPath/User.php',
                'src',
                '\\MyVendor\\MyPackage\\',
                'ModelPath/UserPath/',
                'User'
            ],
            [
                'src/Model/User.php',
                'src',
                'vendor\package',
                '/model/',
                'user'
            ],
            [
                '/src/User.php',
                '/src/',
                'vendor\package',
                '',
                'user'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider providerForGetClassName
     * @covers       Prooph\Cli\Console\Helper\Psr4Info::getClassName
     */
    public function it_returns_class_name($expected, $sourceFolder, $packagePrefix, $fqcn)
    {
        $psr4Info = new Psr4Info($sourceFolder, $packagePrefix);

        self::assertSame($expected, $psr4Info->getClassName($fqcn));
    }

    /**
     * Values are expected, sourceFolder, packagePrefix and FQCN
     *
     * @return array
     */
    public function providerForGetClassName()
    {
        return [
            [
                'User',
                'src',
                '\MyVendor\MyPackage\\',
                '\MyVendor\MyPackage\ModelPath\UserPath\User',
            ],
            [
                'User',
                'src',
                '\\MyVendor\\MyPackage\\',
                '\\MyVendor\\MyPackage\\ModelPath\\UserPath\\User',
            ],
            [
                'User',
                'src',
                '',
                'MyVendor\MyPackage\User',
            ],
        ];
    }
}
