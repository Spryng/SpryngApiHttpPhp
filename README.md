## Spryng PHP API Library

Hi, welcome to the documentation for the Spryng PHP API Library. This guide contains practical information on how to use the library. Full PHPDOC can be found in the repository.

### Installation and initialization

** Using composer **

The easiest way to install the libary is using composer:

```
composer require spryng/SpryngApiPhp
```

When the installation is complete, you can initialize Spryng like so:

```
require( 'vendor/autoload.php')

use SpryngApiPhp\Spryng_Api_Client;

$spryng = new Spryng_Api_Client('username', 'password');
```

** Without composer **

If you're not yet using composer, you can use the autoloader:

```
require ('SpryngApiPhp/src/Spryng/Api/Autoloader.php');

$spryng = new Spryng_Api_Client('username', 'password');
```

### Sending a SMS

To send an SMS, you should use the `Client::sms->send()` method. It takes the following parameters:

* `$recipient` Phone number you're sending the sms to
* `$body` Body of the sms
* `$options` Additional parameters like `sender` and `route`

** Options **

There are a number of options you can specify with your request. The requirements for these options are available in the general documentation.

* `sender` Originator address, like your company name.
* `route` To select Spryng Business or Spryng Economy. Can either be `business` or `economy`
* `reference` An optional reference for delivery reports.
* `allowlong` Weither you want to allow Long SMS or not. Should be `true` or `false`.

** Full example **

```
require( 'vendor/autoload.php')

use SpryngApiPhp\Spryng_Api_Client;

$spryng = new Spryng_Api_Client('username', 'password');

try 
{
	$spryng->sms->send('31612345678', 'A sample message!', array(
										'sender'    => 'Your Company',
										'route'     => 'business',
										'allowlong' => true
										'reference' => 'ABC123456789'));
}
catch (Spryng_Api_Exception_InvalidRequestException $e)
{
	echo $e->getMessage();
}
```

### Requesting credit balance

Alongside the ability to send SMS messages, it's also possible to request your current credit balance. This method does not require any parameters and can be used like this:

```
require( 'vendor/autoload.php')

use SpryngApiPhp\Spryng_Api_Client;

$spryng = new Spryng_Api_Client('username', 'password');

echo 'Current credit balance: ' . $spryng->sms->checkBalance();
```