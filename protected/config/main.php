<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Diário',
    'theme' => 'bootstrap',
    'language'=>'pt',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.document.*',
        'application.extensions.CJuiDateTimePicker.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'bootstrap.gii',
            ),
        ),
    ),
    // 'aliases' => array(
        // // yiistrap configuration
        // // 'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change if necessary
        // // yiiwheels configuration
        // 'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'), // change if necessary
    // ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        // 'bootstrap-calendar' => array(
            // 'class' => 'bootstrap-calendar.BootstrapCalendar',
        // ),
        'authManager'=>array(
		    'class'=>'CPhpAuthManager',
		    // 'defaultRoles'=>array('authenticated'),
		),
        'helper' => array(
		            'class' => 'application.components.Helper',
		),
		// 'clientScript' => array(
            // 'class' => 'ext.yii-less-extension.components.YiiLessCClientScript',
            // 'cache' => true, // Optional parameter to enable or disable LESS File Caching
        // ),
		'format'=>array(
	        'class'=>'application.components.Formatter',
	    ),
		'doc'=>array(
	        'class'=>'application.components.document.DocumentHelper',
	    ),
	    'ePdf' => array(
	        'class'         => 'ext.yii-pdf.EYiiPdf',
	        'params'        => array(
	            'mpdf'     => array(
	                'librarySourcePath' => 'application.vendor.mpdf.*',
	                'constants'         => array(
	                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
	                ),
	                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
	                'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
	                    'mode'              => '', //  This parameter specifies the mode of the new document.
	                    'format'            => 'A4', // format A4, A5, ...
	                    'default_font_size' => 0, // Sets the default document font size in points (pt)
	                    'default_font'      => 'Arial', // Sets the default font-family for the new document.
	                    'mgl'               => 30, // margin_left. Sets the page margins for the new document.
	                    'mgr'               => 20, // margin_right
	                    'mgt'               => 47, // margin_top
	                    'mgb'               => 27, // margin_bottom
	                    'mgh'               => 10, // margin_header
	                    'mgf'               => 10, // margin_footer
	                    'orientation'       => 'P', // landscape or portrait orientation
	                )
	            ),
	            'HTML2PDF' => array(
	                'librarySourcePath' => 'application.vendor.html2pdf.*',
	                'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
	                /*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
	                    'orientation' => 'P', // landscape or portrait orientation
	                    'format'      => 'A4', // format A4, A5, ...
	                    'language'    => 'en', // language: fr, en, it ...
	                    'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
	                    'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
	                    'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
	                )*/
	            )
	        ),
	    ),
        // yiiwheels configuration
        // 'yiiwheels' => array(
            // 'class' => 'yiiwheels.YiiWheels',   
        // ),
        // uncomment the following to enable URLs in path-format
        /*
          'urlManager'=>array(
          'urlFormat'=>'path',
          'rules'=>array(
          '<controller:\w+>/<id:\d+>'=>'<controller>/view',
          '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
          '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
          ),
          ),
         */
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=diario',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'enableParamLogging' => true,
        ),
		// 'db' => array(
            // 'connectionString' => 'mysql:host=localhost;dbname=tarpor5_ei',
            // 'emulatePrepare' => true,
            // 'username' => 'tarpor5_ei',
            // 'password' => '4470887',
            // 'charset' => 'utf8',
        // ),
		// 'db' => array(
            // 'connectionString' => 'mysql:host=localhost;dbname=tarli826_diario',
            // 'emulatePrepare' => true,
            // 'username' => 'tarli826_root',
            // 'password' => '9pBKPDO5fCo4',
            // 'charset' => 'utf8',
            // // FTP:
            // // Usuário/Senha:	tarli826 / 4YH2xyc13n
        // ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
		            'class'=>'CFileLogRoute',
		            'levels'=>'trace, info, error, warning, vardump',
		        ),
		        array(
		            'class'=>'CWebLogRoute',
		            'enabled' => YII_DEBUG,
		            'levels'=>'error, warning, trace, log, vardump',
		            'categories' => 'application,vardump',
		            'showInFireBug'=>YII_DEBUG,
		        ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'tarlis.portela@ifpr.edu.br',
		'tablePrefix' => '',
		'logo' => 'icon-2.ico',
		// 'logo' => 'icon.ico',
    ),
);
