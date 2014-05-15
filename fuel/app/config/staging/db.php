<?php
/**
 * The staging database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=http://ec2-54-201-182-243.us-west-2.compute.amazonaws.com;dbname=marketing_quiz',
			'username'   => 'ytk',
			'password'   => 'ytk',
		),
	),
);
