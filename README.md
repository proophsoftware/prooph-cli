# prooph Command Line Interface

## Overview
The prooph command line interface generates classes to increase development speed. For available commands run

```bash
$ php bin/prooph-cli list
```

Here is an example output:
```shell
Available commands:
  help              Displays help for a command
  list              Lists commands
 prooph
  prooph:generate:aggregate  Generates an aggregate class
  prooph:generate:all        Generates an aggregate, command, command handler, command handler factory and event class.
  prooph:generate:command    Generates a command, command handler and command handler factory class
  prooph:generate:event      Generates an event class
```

There are available environment variables (see `bin/prooph-cli`) for bash scripts to configure
`\Prooph\Cli\Console\Helper\Psr4Info` for your class meta data.

## Installation

You can install prooph/prooph-cli via composer by adding `"proophsoftware/prooph-cli": "^0.1"` as requirement to your composer.json.

## Configuration
This tool checks if a [container-interop](https://github.com/container-interop/container-interop) instance is returned
from file `config/container.php`. You can configure the class info metadata by registering an instance with name
`\Prooph\Cli\Console\Helper\ClassInfo` like `\Prooph\Cli\Console\Helper\Psr4Info` to the container.

Another option is to use environment variables to configure your class metadata:

**env variables:**

* `PROOPHCLI_SOURCE_FOLDER`: path to src folder, default current working dir + 'src'
* `PROOPHCLI_PACKAGE_PREFIX`: namespace of package, default ''
* `PROOPHCLI_FILE_DOC_BLOCk`: file doc block, default ''

## Support

- Ask questions on [prooph-users](https://groups.google.com/forum/?hl=de#!forum/prooph) mailing list.
- File issues at [https://github.com/proophsoftware/prooph-cli/issues](https://github.com/proophsoftware/prooph-cli/issues).
- Say hello in the [prooph gitter](https://gitter.im/prooph/improoph) chat.

## Contribute

Please feel free to fork and extend existing or add new plugins and send a pull request with your changes!
To establish a consistent code quality, please provide unit tests for all your changes and may adapt the documentation.

## License

Released under the [New BSD License](LICENSE).
