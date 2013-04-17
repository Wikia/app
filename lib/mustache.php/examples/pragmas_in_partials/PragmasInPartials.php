<?php

class PragmasInPartials extends MustachePHP {
	public $say = '< RAWR!! >';
	protected $_partials = array(
		'dinosaur' => '{{say}}'
	);
}