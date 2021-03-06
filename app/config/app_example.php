<?php

return [
	
    /**
     *  @csrf is used to blocking csrf attack from users,
     *  if this variable is set to true, you need to add for very form
     *  twig variable like {{ form.csrf('Controller@acion') }}
     */
    'csrf' => true,

    /**
     *  @dev here tou can set developer mode to true or false, if developer mode
     *  is set to true on page have all bugs, if not all logs send to
     *  storage/private/logs like php or sql log.
     **/
    'dev' => true,

    /**
     *  @url this is a framework url, default u can set '/' if framework exist
     *  in any sub folder need to add this path there to good working
     **/
    'url' => '/',
    
    /**
     *  @cache_view disable or enable view caching
     **/
    'cache_view' => false,
    
    /**
     *  @mail configuration using in framework to send mails.
     *  If array values are empty mail are not configured.
     **/
    'mail' => [
        'smtp' => '',
        'user' => '',
        'password' => '',
        'port' => '',
        'from' => '',
        'fromName' => ''
    ],
    
    /**
     *  @model-provider its a defined namespace to all used models for
     *  dynamic function used model with full path
     **/
    'model-provider' => 'App\\Model\\',
    
    /**
     *  @Always loaded libraries css / js from main css / js directory
     *
     **/
    'is_loaded' => [
        'css' => [
            'bootstrap', 'slim-select', 'loader', 'font-awesome.min'
        ],
        
        'js' => [
            'App', 'bootstrap', 'slim-select', 'table-sort'
        ]
    ],
	
    /**
     * @Security used for header Content-Security-Policy
     *
     **/
	'security' => [
		'enabled' => true,
		'protection' =>
			"default-src 'self'; style-src 'self' 'unsafe-inline' fonts.googleapis.com; font-src 'self' fonts.gstatic.com; img-src 'self' data:"
		
	],
	
	'ots' => [
		'image_path' => storage_path('private/cache/images'),
		'items_path' => storage_path('private/cache/ots/items.xml')
	]
];
