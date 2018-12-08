<?php
return [
    'database' => [
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'central_esterilizacion',
        'username' => 'root',
        'password' => 's4ndr0i99i'
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