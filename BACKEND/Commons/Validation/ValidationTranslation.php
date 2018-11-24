<?php

class ValidationTranslation {
	public static function translate($message) {
		//Para saber si me falta una validación debo hacer die(print_r($message));
		//die(print_r($message));
	    $messages = [
	        '{{name}} must not be empty' => 'El campo {{name}} es requerido',
	        'All of the required rules must pass for {{name}}' => 'Valor incorrecto para el campo {{name}}',
	        '{{name}} must be valid email' => 'El campo {{name}} tiene formato inválido',
	        'Attribute {{name}} must be present' => 'El atributo {{name}} debe estar presente',
	        'Key {{name}} must be present' => 'El campo {{name}} es requerido',
	        'Key {{name}} must be valid' => 'El campo {{name}} es inválido',
	        'These rules must pass for {{name}}' => 'El campo {{name}} es inválido',
	        '{{name}} must be an integer number' => 'El campo {{name}} debe ser un número entero',
	        'No items were found for key chain {{name}}' => 'El campo {{name}} es requerido',
	        'Key chain {{name}} is not valid' => 'El campo {{name}} es inválido',
	        '{{name}} must be a boolean' => 'El campo {{name}} debe ser booleano',
	        '{{name}} is not valid' => '{{name}} no es válido',
			'{{name}} must validate against {{regex}}' => 'El campo {{name}} es inválido',
			'{{name}} must be a valid date' => 'El campo {{name}} debe ser una fecha válida',
			'{{name}} must be null' => 'El campo {{name}} debe ser nulo',
			'{{name}} must be of the type float' => 'El campo {{name}} debe ser de tipo Float',
			'{{name}} must be of the type integer' => 'El campo {{name}} debe ser de tipo Entero',
			'{{name}} must be a string' => 'El campo {{name}} debe ser de tipo String'
	    ];
	    return $messages[$message];
	}
}