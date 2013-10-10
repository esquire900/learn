<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Learn',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
                'gii'=>array(
		    'class'=>'system.gii.GiiModule',
		    'password'=>'pass',
		    // If removed, Gii defaults to localhost only. Edit carefully to taste.
		    'ipFilters'=>array('127.0.0.1','::1'),
		),
                'rights'=>array(
                    'install'=>false,
                ),
                
                'user'=>array(
                    # encrypting method (php hash function)
                    'hash' => 'md5',
         
                    # send activation email
                    'sendActivationMail' => false,
         
                    # allow access for non-activated users
                    'loginNotActiv' => false,
         
                    # activate user on registration (only sendActivationMail = false)
                    'activeAfterRegister' => true,
         
                    # automatically login from registration
                    'autoLogin' => true,
         
                    # registration path
                    'registrationUrl' => array('/user/registration'),
         
                    # recovery password path
                    'recoveryUrl' => array('/user/recovery'),
         
                    # login form path
                    'loginUrl' => array('/login'),
         
                    # page after login
                    'returnUrl' => array('/overview'),
         
                    # page after logout
                    'returnLogoutUrl' => array('/login'),
                    

                ),
),

	// application components
	'components'=>array(
		'user'=>array(
	            'class'=>'RWebUser',
                // enable cookie-based authentication
                    'allowAutoLogin'=>true,
                    'loginUrl'=>array('/login'),
		),

		'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'home'=>'site/index',
                //'<view>'=>array('site/page'),
                'overview' => 'category/index',
                'overview/<id:\d+>' => 'category/index',
                '<action>' => 'site/<action>',
                '<action>/<id:\d+>' => 'site/<action>',

            ),
        ),
        'authManager'=>array(
            'class'=>'RDbAuthManager',
            'connectionID'=>'db',
            'defaultRoles'=>array('Authenticated', 'Guest'),
        ),


		'db'=>array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=learn',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'bodyBackgroundClass' => 'greyBackground'
	),
	'sourceLanguage'=>'en',
);