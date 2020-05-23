# This version of the SDK is deprecated. Please head over to [this repository](https://github.com/spryng/rest-api-php/) for the REST API SDK, which supports many more features and makes use of our new REST API. This repository will be archived soon.

## Spryng PHP API Library

Hi, welcome to the documentation for the Spryng PHP API Library. This guide contains practical information on how to use the library. Full PHPDOC can be found [in this repository](https://github.com/Spryng/SpryngApiHttpPhpDocs).

### Installation and initialization

__Using composer__

The easiest way to install the libary is using composer:

```
composer require spryng/spryng-api-http-php
```

When the installation is complete, you can initialize Spryng like so:

```php
require( 'vendor/autoload.php');

use SpryngApiHttpPhp\Client;

$spryng = new Client('username', 'password', 'My Company');
```

__Without composer__

If you're not yet using composer, you can use the autoloader:

```php
require ('SpryngApiHttpPhp/src/Spryng/Api/Autoloader.php');

$spryng = new Client('username', 'password', 'My Company');
```

### Sending a SMS

To send an SMS, you should use the `Client::sms->send()` method. It takes the following parameters:

* `$recipient` Phone number you're sending the sms to
* `$body` Body of the sms
* `$options` Additional parameters like `allowlong` and `route`

__Options__

There are a number of options you can specify with your request. The requirements for these options are available in the general documentation.

* `route` Enter your assigned route.
* `reference` An optional reference for delivery reports.
* `allowlong` Weather you want to allow Long SMS or not. Should be `true` or `false`.
* `rawencoding` ISO/UTF encoding

__Full example__

```php
require( 'vendor/autoload.php')

use SpryngApiHttpPhp\Client;

$spryng = new Client('username', 'password', 'My Company');

try 
{
    $spryng->sms->send('31612345678', 'A sample message!', array(
        'route'     => 'business',
         'allowlong' => true
         'reference' => 'ABC123456789'
         'rawencoding' => false)
    );
}
catch (InvalidRequestException $e)
{
    echo $e->getMessage();
}
```

### Requesting credit balance

Alongside the ability to send SMS messages, it's also possible to request your current credit balance. This method does not require any parameters and can be used like this:

```php
require( 'vendor/autoload.php')

use SpryngApiHttpPhp\Client;

$spryng = new Client('username', 'password', 'My Company');

echo 'Current credit balance: ' . $spryng->sms->checkBalance();
```
