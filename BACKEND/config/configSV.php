<?php
return [
    'database' => [
        'host' => '50.21.176.211',
        'port' => '3309',
        'database' => 'InterlaboratoriosIRAM',
        'username' => 'InterIRAM',
        'password' => '1nter1r4m'
    ],
    'authentication' => [
        'session'  => [
	        'timeout' => 60 // minutos
	    ],
	    'activation' => [
	    	'timeout' => 2880 // minutos
	    ]
	],
	'notifications' => [
        'email'  => [
	        'smtp' => [
	        	'host' => '',
	        	'port' => '',
	        	'username' => '',
	        	'password' => ''
	        ]
	    ]
	],
	'storage' => [
		'series' => [
			'informe' => [
				'path' => 'C:\sandroUploadInformes'
			]
		]
	]
];