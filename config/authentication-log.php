<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notify New Device
    |--------------------------------------------------------------------------
    |
    | Here you define whether to receive notifications when logging from a new device.
    |
    */

    'notify' => env('AUTHENTICATION_LOG_NOTIFY', true),

    /*
    |--------------------------------------------------------------------------
    | Old Logs Clear
    |--------------------------------------------------------------------------
    |
    | When the clean-command is executed, all authentication logs older than
    | the number of days specified here will be deleted.
    |
    */

    'older' => 365,

    /*
    |--------------------------------------------------------------------------
    | Geolocation timeout
    |--------------------------------------------------------------------------
    |
    | Set the amount of time in seconds to wait for geolocation, if it exceeds
    | this then we ignore the location for performance reasons.
    |
    */

    'geolocation_timeout' => 2,
    
    /*
    |--------------------------------------------------------------------------
    | Email account validation
    |--------------------------------------------------------------------------
    |
    | checks if the user has email validation and if its been validated
    |
    */
    'has-email-validation' => false,

    /*
    |--------------------------------------------------------------------------
    | Email view path
    |--------------------------------------------------------------------------
    |
    | In case you want use custom Email Design
    |
    */
	'email-view' => 'authentication-log::emails.new',

    /*
    |--------------------------------------------------------------------------
    | Translation Keys
    |--------------------------------------------------------------------------
    |
    | Translation keys to customize text in Notifications
    | @param app = app.name
    |
    */
	'email-subject' => 'authentication-log::messages.subject',
	'message-content' => 'authentication-log::messages.content',


];
