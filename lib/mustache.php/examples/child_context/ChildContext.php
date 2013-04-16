<?php

class ChildContext extends MustachePHP {
	public $parent = array(
		'child' => 'child works',
	);
	
	public $grandparent = array(
		'parent' => array(
			'child' => 'grandchild works',
		),
	);
}