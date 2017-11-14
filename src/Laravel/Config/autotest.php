<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AutoTest Configuration
    |--------------------------------------------------------------------------
    |
    | The following are custom configuration options for the stekel:AutoTest
    | laravel command.
    |
    */
    
    /*
    |--------------------------------------------------------------------------
    | Ignored Paths
    |--------------------------------------------------------------------------
    |
    | Define paths within your project to be ignored by the running entr
    | process. This is an array of paths relative to your project root.
    |
    | Example: 'vendor/*''
    |
    */
   
    'ignoredPaths' => [
        'vendor/*',
        'storage/*'
    ],

    'fancyTest' => [
        'simplifyProjectPath' => true,
        'simplifyLaravelPipeline' => true,
    ],
];
