<?php
class Weinre extends WikiaObject {
	static protected $initialized = false;

	function __construct(){
		parent::__construct();

		if ( !self::$initialized ) {
			//singleton
			F::setInstance( __CLASS__, $this );
			self::$initialized = true;
		}
	}

	public function isEnabled(){
		$val = $this->wg->request->getText( 'weinre' );
		return ( !empty( $val ) );
	}

	public function getRequestedHost(){
		$val = $this->wg->request->getText( 'weinre' );
		return ( !empty( $val ) && $val != '1' && $val != 'true' ) ? $val : null;
	}
}