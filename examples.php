<?php 

/**
 * You can either require the VirtualPage Class in your functions.php file
 * or you can add it as a plugin by moving the VirtualPage.php file in
 * your mu-plugins in the wp-content folder
 */
require_once __DIR__ . '/VirtualPage.php';


/**
 * create an array of the scripts and styles you want to enqueue
 */
$loginRegisterScripts = [
    'util-js' => [ // the handle name
        'url' => get_template_directory_uri() . '/js/util.js', // path to the script
        'dependencies' => ['jquery'], // scripts to be enqueued before this script
    ],
    'login-js' => [
        'url'      => get_template_directory_uri().'/js/login.js',
        'dependencies'  => ['jquery'],
        'localize' => [
            'name' => 'alaan',
            'data' => [
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'login_now_text' => __('Login Now') ,
                'register_now_text' => __('Register Now'),
                'send_now_text' => __('Send Now'),
            ]
        ]
    ],
    'recaptcha' => [
        'url' => 'https://www.google.com/recaptcha/api.js'
    ]
];

/**
 * Create an object of the VirtualPage Class and pass in the Parameters
 */
$loginpage = new VirtualPage('login','login.php', $loginRegisterScripts);

/**
 * Initialize the VirtualPage
 */
$loginpage->init();