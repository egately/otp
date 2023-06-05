<?php

// config for Egate/EgateOtp
return [

    'app_name' => env('APP_NAME'),

    'otp_length' => 6,

    'default_validation_window' => 5, //minutes

    'default_identifier_attribute' => 'email', //could be email or username or any other unique identifier

];
