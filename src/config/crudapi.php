<?php

return [
    /**
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
        'perPage' => 25
    ],

    /**
     * Configuration relating to the admin crud area
     */
    'admin' => [
        // Whether or not to show timestamps in the crud display
        'showTimestamps' => false,

        // Whether to show id's next to each item.
        'showIds' => false,
    ]
];
