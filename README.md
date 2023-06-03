# OTP Mangement Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/egate/egate-otp.svg?style=flat-square)](https://packagist.org/packages/egate/egate-otp)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/egate/egate-otp/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/egate/egate-otp/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/egate/egate-otp/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/egate/egate-otp/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/egate/egate-otp.svg?style=flat-square)](https://packagist.org/packages/egate/egate-otp)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/egate-otp.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/egate-otp)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require egate/egate-otp
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="egate-otp-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="egate-otp-config"
```

This is the contents of the published config file:

```php
return [

    'app_name' => env('APP_NAME'), // this will be used for the title of the authenticator account
    
     'default_identifier_attribute' => 'identifier', // the default attribute to be used as the identifier to be added to the authenticator account

    'otp_length' => 6, // the length of the generated otp it is 6 by default

    'otp_expires_in' => 5,// the minutes before the otp expires

   

];
```

## Usage

### Add the trait to your User model(s) or any other model you want to use for OTP's

```php

use Egate\EgateOtp\Traits\HasEgateOtp;

````

#### Once the trait is used in the model you can use the following methods ( example below is for User model )


- Generate New OTP : this will generate a new otp

```php

$otp = $user->generateOtp();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Salah Elabbar](https://github.com/egate)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
