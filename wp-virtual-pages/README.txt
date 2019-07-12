=== WordPress Virtual Pages ===
Contributors: farbodghasemi
Tags: virtual,page,fake page,virtual page
Requires at least: 4.4
Tested up to: 5.3
Requires PHP: 5.6
Stable tag: trunk

Creates Virtual Pages that don\'t show up in the Pages menu inside the Dashboard

== Description ==
Ever wanted to have some Static pages that require no content or featured image or anything, but don\'t want them to stick around in your Pages menu inside the WordPress Dashboard? 
like Login/Register Pages, Forgot/Reset Password Page, etc.

== Installation ==
best practice is to just place the `wp-virtual-pages.php` file in the  `mu-plugins` folder.
if you don\'t have a `mu-plugins` folder, you can create one in  the `wp-content` folder and place the file in there. ( _mu-plugins_ folder is for plugins that will be automatically activated across all of your themes. the __mu__ stands for ***Must Use***)
but you can install the plugin from inside the dashboard or copying the folder inside the plugins folder.

== Create a Virtual Page ==

It\'s simple, you need to create an object of the VirtualPage class. just follow the syntax below:

    $PAGE_NAME_HERE = new VirtualPage(\'PAGE_SLUG_HERE\',\'PATH_TO_TEMPLATE_FILE\', ARRAY_OF_SCRIPTS);


The third parameter(scripts Array) is optional, so if you don\'t want to load any scripts or styles, just don\'t pass it in, it\'ll work just fine.

Initialize the page like below:

    $PAGE_NAME_HERE->init();

== Example ==

here\'s an example to create a virtual login page. just place the code below into your `functions.php` file.

`$loginRegisterScripts = [
	    \'login-js\' => [
	        \'url\'      => get_template_directory_uri().\'/js/login.js\', // path to the script
	        \'dependencies\'  => [\'jquery\'], // scripts to be enqueued before this script
	        \'localize\' => [ // javascript data to pass into the page
	            \'name\' => \'data\', 
	            \'data\' => [ // array elements below will be available in the global variable data
	                \'ajax_url\' => admin_url( \'admin-ajax.php\' ),
	                \'login_now_text\' => __(\'Login Now\') ,
	                \'register_now_text\' => __(\'Register Now\'),
	                \'send_now_text\' => __(\'Send Now\'),
	            ]
	        ]
	    ],
	    \'recaptcha\' => [ // you can enqueue files from other valid urls
	        \'url\' => \'https://www.google.com/recaptcha/api.js\'
	    ]
	];
/**
 * Create an object of the VirtualPage Class and pass in the Parameters
 */
$loginpage = new VirtualPage(\'login\',\'login.php\', $loginRegisterScripts);

/**
 * Initialize the VirtualPage
 */
$loginpage->init(); `


This will create a Virtual Login page you can access in this url: `YOUR_SITE_URL/login`

Simple, Right?