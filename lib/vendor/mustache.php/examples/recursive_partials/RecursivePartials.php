<?php

class RecursivePartials extends MustachePHP {
	protected $_partials = array(
		'child' => " > {{ name }}{{#child}}{{>child}}{{/child}}",
	);

	public $name  = 'George';
	public $child = array(
		'name'  => 'Dan',
		'child' => array(
			'name'  => 'Justin',
			'child' => false,
		)
	);
}