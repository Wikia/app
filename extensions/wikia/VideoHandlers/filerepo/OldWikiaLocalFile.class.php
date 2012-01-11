<?php

class OldWikiaLocalFile extends OldLocalFile {

	protected $oVideoLogic = null; // Leaf object

	/* obligatory constructors */

	function __construct( $title, $repo ){
		parent::__construct( $title, $repo );
	}
	
	static function newFromTitle( $title, $repo, $time = null ) {
		# The null default value is only here to avoid an E_STRICT
		if( $time === null )
			throw new MWException( __METHOD__.' got null for $time parameter' );
		return new self( $title, $repo, $time, null );
	}

	static function newFromArchiveName( $title, $repo, $archiveName ) {
		return new self( $title, $repo, null, $archiveName );
	}

	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->oi_name );
		$file = new self( $title, $repo, null, $row->oi_archive_name );
		$file->loadFromRow( $row, 'oi_' );
		return $file;
	}

	static function newFromKey( $sha1, $repo, $timestamp = false ) {
		# Polymorphic function name to distinguish foreign and local fetches
		$fname = get_class( $this ) . '::' . __FUNCTION__;

		$conds = array( 'oi_sha1' => $sha1 );
		if( $timestamp ) {
			$conds['oi_timestamp'] = $timestamp;
		}
		$row = $dbr->selectRow( 'oldimage', $this->getCacheFields( 'oi_' ), $conds, $fname );
		if( $row ) {
			return self::newFromRow( $row, $repo );
		} else {
			return false;
		}
	}

	// Composite/Leaf interface

	function __construct( $title, $repo ){
		parent::__construct( $title, $repo );

	}

	function  __call( $name, $arguments ){
		if ( method_exists( $this->getVideoLogic(), $name ) ){
			return call_user_func_array( array( $this->getVideoLogic(), $name ), $arguments );
		} else {
			throw new Exception( 'Method ' .get_class( $this->getVideoLogic() ).'::' . $name . ' does not extist' );
		}
	}

	function __set( $name, $value ){
		if ( !isset( $this->$name ) && isset( $this->getVideoLogic()->$name ) ){
			$this->getVideoLogic()->$name = $value;
		} else {
			$this->$name = $value;
		}
	}

	function __get( $name ){
		if ( !isset( $this->$name ) ) {
			return $this->getVideoLogic()->$name;
		} else {
			return $this->$name;
		}
	}

	protected function getVideoLogic() {
		if ( empty( $this->oVideoLogic ) ){
			$this->oVideoLogic = F::build( 'WikiaVideoLogic', array( $this ) );
		}
		return $this->oVideoLogic;
	}

	// Make parent methods accesible to Leaf

	function getHandler(){
		parent::getHandler();
		$this->getVideoLogic()->afterGetHandler();
		return $this->handler;
	}

	function setProps( $info ) {
		parent::setProps( $info );
		$this->getVideoLogic()->afterSetProps();
	}

	function loadFromFile() {
		$this->getVideoLogic()->beforeLoadFromFile();
		parent::loadFromFile();
		$this->getVideoLogic()->afterLoadFromFile();
	}
}
