<?php

class TestSpecialPage extends SpecialPage {

		protected $out;

		function __construct() {
			$this->out = F::app()->getGlobal('wgOut');
			parent::__construct( 'Test', 'special-test-title' );
		}

	function execute( $par ) {
		return ;
	}

}
