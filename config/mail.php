<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses",
    |            "postmark", "log", "array", "failover"
    |
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],
        'P3C' => [
            'transport' => 'smtp',
            'driver' => env('MAIL_DRIVER_P3C', 'smtp'),
            'host' => env('MAIL_HOST_P3C', 'mail.ptduta.com'),
            'port' => env('MAIL_PORT_P3C', 587),
            'encryption' => env('MAIL_ENCRYPTION_P3C', 'tls'),
            'username' => env('MAIL_USERNAME_P3C', 'rinaseptiani@ptduta.com'),
            'password' => env('MAIL_PASSWORD_P3C', 'r0409'),
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS_P3C', 'notification-p3c@ptduta.com'),
                'name' => env('MAIL_FROM_NAME_P3C', 'P3C Notification'),
            ],
        ],
        'PRODUKSI' => [
            'transport' => 'smtp',
            'driver' => env('MAIL_DRIVER_PRODUKSI', 'smtp'),
            'host' => env('MAIL_HOST_PRODUKSI', 'mail.ptduta.com'),
            'port' => env('MAIL_PORT_PRODUKSI', 587),
            'encryption' => env('MAIL_ENCRYPTION_PRODUKSI', 'tls'),
            'username' => env('MAIL_USERNAME_PRODUKSI', 'adminproduksi@ptduta.com'),
            'password' => env('MAIL_PASSWORD_PRODUKSI', 'ap0604PTDUTA'),
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS_PRODUKSI', 'notification-produksi@ptduta.com'),
                'name' => env('MAIL_FROM_NAME_PRODUKSI', 'PRODUKSI Notification'),
            ],
        ],
        'QC' => [
            'transport' => 'smtp',
            'driver' => env('MAIL_DRIVER_QC', 'smtp'),
            'host' => env('MAIL_HOST_QC', 'mail.ptduta.com'),
            'port' => env('MAIL_PORT_QC', 587),
            'encryption' => env('MAIL_ENCRYPTION_QC', 'tls'),
            'username' => env('MAIL_USERNAME_QC', 'surasmi@ptduta.com'),
            'password' => env('MAIL_PASSWORD_QC', 's1704PTDUTA'),
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS_QC', 'notification-qc@ptduta.com'),
                'name' => env('MAIL_FROM_NAME_QC', 'QC Notification'),
            ],
        ],
        'ENG' => [
            'transport' => 'smtp',
            'driver' => env('MAIL_DRIVER_ENG', 'smtp'),
            'host' => env('MAIL_HOST_ENG', 'mail.ptduta.com'),
            'port' => env('MAIL_PORT_ENG', 587),
            'encryption' => env('MAIL_ENCRYPTION_ENG', 'tls'),
            'username' => env('MAIL_USERNAME_ENG', 'hendrarudianto@ptduta.com'),
            'password' => env('MAIL_PASSWORD_ENG', 'h1105ptduta'),
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS_ENG', 'notification-engineering@ptduta.com'),
                'name' => env('MAIL_FROM_NAME_ENG', 'ENG Notification'),
            ],
        ],
        'IT' => [
            'transport' => 'smtp',
            'driver' => env('MAIL_DRIVER_IT', 'smtp'),
            'host' => env('MAIL_HOST_IT', 'mail.ptuta.com'),
            'port' => env('MAIL_PORT_IT', 587),
            'encryption' => env('MAIL_ENCRYPTION_IT', 'tls'),
            'username' => env('MAIL_USERNAME_IT', 'wahyu@ptduta.com'),
            'password' => env('MAIL_PASSWORD_IT', 'w2503dlgp'),
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'notification-no-reply@ptduta.com'),
                'name' => env('MAIL_FROM_NAME', 'IT Notification'),
            ],
        ],
        'ses' => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
        ],

        'postmark' => [
            'transport' => 'postmark',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -t -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
