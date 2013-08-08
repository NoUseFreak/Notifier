Notifier
========

[![Build Status](https://secure.travis-ci.org/NoUseFreak/Notifier.png)](https://travis-ci.org/NoUseFreak/Notifier)

Notifier acts as a notification center.

Recipients will only receive the messages they signed up for.

## Usage
```php
<?php

$notifier = new Notifier\Notifier();
$notifier->pushProcessor(function($message) {
    $recipients = $message->getRecipients();
    // only set the filters just before sending.
    foreach ($recipients as &$recipient) {
        if ($recipient->getData() == 'Dries') {
            $recipient->addType('test', 'var_dump');
        }
    }
    return $message;
});
$notifier->pushHandler(new Notifier\Handler\VarDumpHandler(array('test', 'mailing')));

$message = new Notifier\Message\Message('test');
$message->addRecipient(new Notifier\Recipient\Recipient('Dries'));

$notifier->sendMessage($message);
```

## Current state

The project is still in development and is not yet suited for production environments.

## Handlers

Notifier is stripped of most handlers. You can find a [list of all available handler](http://github.com/Notifier).

## Contributing

> All code contributions - including those of people having commit access - must
> go through a pull request and approved by a core developer before being
> merged. This is to ensure proper review of all the code.
>
> Fork the project, create a feature branch, and send us a pull request.
>
> To ensure a consistent code base, you should make sure the code follows
> the [Coding Standards](http://symfony.com/doc/2.0/contributing/code/standards.html)
> which we borrowed from Symfony.
> Make sure to check out [php-cs-fixer](https://github.com/fabpot/PHP-CS-Fixer) as this will help you a lot.

If you would like to help take a look at the [list of issues](http://github.com/Notifier/Notifier/issues).

## Requirements

PHP 5.3.2 or above

## Author and contributors

Dries De Peuter - <dries@nousefreak.be> - <http://nousefreak.be>

See also the list of [contributors](https://github.com/Notifier/Notifier/contributors) who participated in this project.

## License

Notifier is licensed under the MIT license.
