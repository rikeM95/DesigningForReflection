<?php

defined( 'ABSPATH' ) || exit;

return [

	'include' => [
		'type'    => 'select',
		'name'    => '[include]',
		'title'   => __( 'Type', 'wpcoder' ),
		'options' => [ 'css' => 'css', 'js' => 'js' ],
		'class' => 'display-option',
	],

	'include_file' => [
		'type'  => 'url',
		'name'  => '[include_file]',
		'title' => __( 'URL', 'wpcoder' ),
	],

	'js_attr' => [
		'type'  => 'select',
		'name'  => '[file_js_att]',
		'title' => __( 'Attribute', 'wpcoder' ),
		'options' => [
			0       => 'none',
			'defer' => 'defer',
			'async' => 'async'
		],
		'class' => 'js-attr',
	],

	'dequeue' => [
		'type'    => 'select',
		'name'    => '[dequeue]',
		'title'   => __( 'Type', 'wpcoder' ),
		'options' => [ 'css' => 'css', 'js' => 'js' ],
		'class' => 'display-option',
	],

	'handle' => [
		'type'  => 'text',
		'name'  => '[handle]',
		'title' => __( 'ID', 'wpcoder' ),
	],


];