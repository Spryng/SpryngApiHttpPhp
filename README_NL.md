## Spryng PHP APi Library

Hi, welkom bij de documentatie voor de Spryng PHP Api Library. Deze handleiding bied praktische informatie over het integreren van de library. Voor meer informatie kunt u gebruik maken van de PHPDoc [in deze repository](https://github.com/Spryng/SpryngApiHttpPhpDocs).

### Installatie en initialisatie

__Met Composer__

We raden u aan de library te installeren met Composer. Dit kan op de volgende manier:

```
composer require spryng/spryng-api-http-php
```

Wanneer de installatie voltooid is, kunt u Spryng op de volgende manier initialiseren:

```php
require ( 'vendor/autoload.php' );

use SpryngApiHttpPhp\Client;

$spryng = new Client('gebruikersnaam', 'wachtwoord', 'Uw Bedrijf');
```

__Zonder Composer__

__Installatie zonder Composer wordt niet aangeraden! De library maakt gebruik van enkele dependencies, zoals GuzzleHttp, die niet kunnen worden geïnstalleerd met een autoloader.__

Als u geen gebruik maakt van Composer, bijvoorbeeld door technische beperkingen, kunt u gebruik maken van de autoloader om alle klassen in te laden.

```php
$ git clone https://github.com/spryng/SpryngApiHttpPhp.git
```

```
require ( 'SpryngApiHttpPhp/src/Spryng/Api/Autoloader.php' );

use SpryngApiHttpPhp\Client;

$spryng = new Client( 'gebruikersnaam', 'wachtwoord', 'Uw Bedrijf' );
```

### Een SMS versturen

U kunt SMS berichten versturen met de methode `Client $spryng->sms->send()`. Deze methode heeft de volgende argumenten:

* `$recipient` Het telefoonnummer waar u een SMS naar wilt versturen.
* `$body` Het SMS bericht.
* `$options` Verdere opties zoals `allowlong` en `route`

__Opties__

Er zijn enkele opties die u kunt specificeren bij het versturen van een SMS bericht. De restricties voor deze opties zijn te vinden in de algemene beschrijving van de Spryng SMS Api. 

* `route` De route die u wilt gebruiken. Deze wordt u aangeleverd.
* `reference` Een optionele referentie voor uw bericht. Deze kunt u gebruiken om delivery reports te ontvangen.
* `allowlong` Boolean waarde waarmee u aangeeft of berichten langer dan 160 tekens in verschillende berichten verzonden mogen worden.
* `rawencoding` Boolean waarde voor ISO/UTF encoding

__Volledig voorbeeld__

```php
require ( 'vendor/autoload.php' );

use SpryngApiHttpPhp\Client;
use SpryngApiHttpPhp\Exception\InvalidRequestException;

$spryng = new Client('gebruikersnaam', 'wachtwoord', 'Uw Bedrijf' );

try
{
	$spryng->sms->send('31612345678', 'Een voorbeeld bericht!', array(
		'route'		=> 'business',
		'allowlong'	=> true,
		'reference'	=> 'ABC123456789'
		'rawencoding'   => false)
	);
}
catch (InvalidRequestException $e)
{
	echo $e->getMessage();
}
```

### Aanvragen credit balans

Naast het versturen van SMS berichten, is het ook mogelijk om uw credit balans op te vragen. Deze methode heeft geen extra argumenten nodig en kan als volgt worden geïmplementeerd:

```php
require ( 'SpryngApiHttpPhp/src/Spryng/Api/Autoloader.php' );

use SpryngApiHttpPhp\Client;

$spryng = new Client( 'gebruikersnaam', 'wachtwoord', 'Uw Bedrijf' );

echo 'Huidige balans: ' . $spryng->sms->checkBalance();
```