<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Details
    |--------------------------------------------------------------------------
    */

    'name' => 'CryptEx - Ultimate Peer to Peer Cryptocurrency Exchange Platform',

    'link' => '',

    'documentation' => 'https://www.fiverr.com/ixenox',

    'thumbnail' => 'http://oluwatosin.me/cdn/images/cryptoexchange/logo.png',

    /*
    |--------------------------------------------------------------------------
    | Author Details
    |--------------------------------------------------------------------------
    */
    'author' => [
        'name' => 'HolluwaTosin360',

        'portfolio' => 'https://www.fiverr.com/ixenox',

        'avatar' => 'http://oluwatosin.me/avatar.jpg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Envato Access Token
    |--------------------------------------------------------------------------
    */
    'access_token' => 'pegn28gwx2gm6i7z1wcyw07nf3zye5qs',

    /*
    |--------------------------------------------------------------------------
    | License Endpoint
    |--------------------------------------------------------------------------
    */
    'license_endpoint' => 'http://oluwatosin.herokuapp.com/api/licenses',

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel server requirements, you can add as many
    | as your application require, we check if the extension is enabled
    | by looping through the array and run "extension_loaded" on it.
    |
    */

    'core' => [
        'minPhpVersion' => '7.1.0'
    ],

    'requirements' => [
        'php' => [
            'mysqli',
            'gmp',
            'bcmath',
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
            'gd',
            'fileinfo',
            'zip'
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions' => [
        'storage/framework/'     => '775',
        'storage/logs/'          => '775',
        'bootstrap/cache/'       => '775'
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Form Wizard Validation Rules & Messages
    |--------------------------------------------------------------------------
    |
    | This are the default form field validation rules. Available Rules:
    | https://laravel.com/docs/5.4/validation#available-validation-rules
    |
    */
    'environment' => [
        'app' => [
            'APP_NAME' => [
                'label' => 'Application Name',
                'hint' => 'Set your website name',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string|max:50'
            ],

            'APP_TIMEZONE' => [
                'label' => 'Application Timezone',
                'hint' => 'This is used by default to process time',
                'type' => 'select',
                'options' => getTimeZones(),
                'placeholder' => '',
                'rules' => 'required|string|max:50'
            ],

            'APP_URL' => [
                'label' => 'Application URL',
                'hint' => 'Set your website link. Ensure this is an active domain',
                'type' => 'text',
                'placeholder' => '(e.g http:// or https://example.com/)',
                'rules' => 'required|url'
            ],

            'APP_REDIRECT_HTTPS' => [
                'label' => 'Force SSL',
                'hint' => 'This will force your domain to be redirected to https',
                'type' => 'select',
                'options' => [
                    'true' => 'Yes',
                    'false' => 'No'
                ],
                'placeholder' => 'Select',
                'rules' => 'required|url'
            ],
        ],

        'db' => [
            'DB_HOST' => [
                'label' => 'Database Host',
                'hint' => 'Leave as localhost if your database is on the same server as this script.',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string|max:50'
            ],
            'DB_PORT' => [
                'label' => 'Database Port',
                'hint' => 'This is usually 3306. Please specify if it is otherwise.',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|numeric'
            ],
            'DB_DATABASE' => [
                'label' => 'Database Name',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string'
            ],
            'DB_USERNAME' => [
                'label' => 'Database Username',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string'
            ],
            'DB_PASSWORD' => [
                'label' => 'Database Password',
                'hint' => 'The password to your database server.',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string'
            ],
        ],

        'broadcast' => [
            'PUSHER_APP_ID' => [
                'label' => 'Pusher ID',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string'
            ],

            'PUSHER_APP_KEY' => [
                'label' => 'Pusher Key',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string'
            ],

            'PUSHER_APP_SECRET' => [
                'label' => 'Pusher Secret',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string'
            ],
        ],

        'mail' => [
            'MAIL_DRIVER' => [
                'label' => 'Mail Driver',
                'hint' => 'Set the medium to be used to send emails',
                'type' => 'select',
                'options' => [
                    'smtp' => 'SMTP',
                    'sendmail' => 'SENDMAIL'
                ],
                'placeholder' => '',
                'rules' => 'required'
            ],
            'MAIL_HOST' => [
                'label' => 'Mail Host',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string|max:50'
            ],
            'MAIL_PORT'=> [
                'label' => 'Mail Port',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string|max:50'
            ],
            'MAIL_USERNAME' => [
                'label' => 'Mail Username',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string|max:50'
            ],
            'MAIL_PASSWORD' => [
                'label' => 'Mail Password',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string|max:50'
            ],
            'MAIL_ENCRYPTION' => [
                'label' => 'Mail Encryption',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string|max:50'
            ]
        ],

        'extras' => [
            'BLOCKCYPHER_TOKEN' => [
                'label' => 'BlockCypher Token',
                'hint' => '',
                'type' => 'text',
                'placeholder' => '',
                'rules' => 'required|string'
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Installed Middlware Options
    |--------------------------------------------------------------------------
    | Different available status switch configuration for the
    | canInstall middleware located in `CanInstall.php`.
    |
    */
    'installed_action' => [
        'default' => 'abort',

        'options' => [
            'route' => [
                'name' => '',
            ],
            'abort' => [
                'type' => '404',
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Updater Enabled
    |--------------------------------------------------------------------------
    | Can the application run the '/update' route with the migrations.
    | The default option is set to False if none is present.
    | Boolean value
    |
    */
    'enabled_update' => true,
];
