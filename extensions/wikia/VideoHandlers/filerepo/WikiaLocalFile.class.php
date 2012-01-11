<?php

class WikiaLocalFile extends LocalFile {
	
	protected $oVideoLogic = null; // Leaf object

	// obligatory contructors

	/**
	 * Create a LocalFile from a title
	 * Do not call this except from inside a repo class.
	 *
	 * Note: $unused param is only here to avoid an E_STRICT
	 */
	static function newFromTitle( $title, $repo, $unused = null ) {
		return new static( $title, $repo );
	}

	/**
	 * Create a LocalFile from a title
	 * Do not call this except from inside a repo class.
	 */
	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->img_name );
		$file = new static( $title, $repo );
		$file->loadFromRow( $row );
		return $file;
	}

	/**
	 * Create a LocalFile from a SHA-1 key
	 * Do not call this except from inside a repo class.
	 */
	static function newFromKey( $sha1, $repo, $timestamp = false ) {
		# Polymorphic function name to distinguish foreign and local fetches
		$fname = get_class( $this ) . '::' . __FUNCTION__;

		$conds = array( 'img_sha1' => $sha1 );
		if( $timestamp ) {
			$conds['img_timestamp'] = $timestamp;
		}
		$row = $dbr->selectRow( 'image', $this->getCacheFields( 'img_' ), $conds, $fname );
		if( $row ) {
			return static::newFromRow( $row, $repo );
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