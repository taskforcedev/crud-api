<?php

return [
    /*
     * Please choose which framework should be used for the CRUD ui.
     * Valid options:
     *  'bs3': Bootstrap 3
     *  'bs4': Bootstrap 4
     *  'f6':  Foundation 6
     *  'mdl': Material Design (getmdl.io) // Note for dialog support a polyfill is required, see mdl docs online.
     */
    'framework' => 'bs4',

    'pagination' => [
        'enabled' => true,
        'perPage' => 25,
    ],

    'models' => [

        'fields' => [

            /*
             * The default field to display when showing crud forms,
             * Should be model agnostic and available on
             * all models unless overridden below.
             */
            'default' => 'name',

            'primary' => [
                /*
                 * If you use forename,surname / first_name,last_name, change below
                 * comma seperated values will be appended with spaces, eg
                 * 'User' => 'forename,surname' would display the users forename and surname.
                 */
                'User' => 'name'
            ],
        ],

        'excluded' => [

        ]
    ],
];
