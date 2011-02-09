<?php
class WikiaSpecialPageController extends WikiaController {
	protected $specialPage = null;

	public function __construct( $name = '', $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		$this->specialPage = SF::build( 'SpecialPage', array( $name, $restriction, $listed, $function, $file, $includable ) );
	}

	public function execute() {
		SF::build('App')->dispatch( ( array( 'controller' => substr( get_class( $this ), 0, -10 ) ) + $_POST + $_GET ) );
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->specialPage, $method ), $args );
	}

}
