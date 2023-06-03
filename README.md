# OTP Mangement Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/egate/egate-otp.svg?style=flat-square)](https://packagist.org/packages/egate/egate-otp)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/egate/egate-otp/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/egate/egate-otp/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/egate/egate-otp/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/egate/egate-otp/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/egate/egate-otp.svg?style=flat-square)](https://packagist.org/packages/egate/egate-otp)

This package is used to generate and manage OTP's for users, it can be used to generate OTP's for any model you want.
The special feature of this package is that the OTP generated by extending  google2fa, this means that the OTP generated by this package can be used with any authenticator app.
Yyou can use any authenticator app to scan the QR code generated by this package and use it to validate OTP's for your users, the same way you use google2fa you can use this package.
Since we can generate the OTP's for any model you want, you can send the OTP generated by SMS or Email to your users. and they can use it to validate their accounts.
This is very handy if you want to use OTP's for your users but you don't want to use the authenticator app. Or give your users the option to use authenticator or receive the OTP in sms.

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
