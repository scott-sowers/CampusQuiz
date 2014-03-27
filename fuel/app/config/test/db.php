<?php
/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=http://ec2-54-201-182-243.us-west-2.compute.amazonaws.com;dbname=ciscoquizss',
			'username'   => 'ytk',
			'password'   => 'ytk',
		),
	),
);
