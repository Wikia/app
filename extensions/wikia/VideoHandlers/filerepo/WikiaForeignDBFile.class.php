<?php

/* Wikia wrapper on ForeignDBFile.
 * Alter some functionality allow using thumbnails as a representative of videos in file structure.
 * Works as interface, logic should go to WikiaLocalFileShared
 */

class WikiaForeignDBFile extends ForeignDBFile {
	
	protected $oLocalFileLogic = null; // Leaf object

	static function newFromTitle( $title, $repo, $unused = null ) {
		return new static( $title, $repo );
	}

	/**
	 * Create a WikiaForeignDBFile from a title
	 * Do not call this except from inside a repo class.
	 */
	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->img_name );
		$file = new static( $title, $repo );
		$file->loadFromRow( $row );
		return $file;
	}

	/* Composite/Leaf interface
	 * 
	 * if no method of var found in current object tries to get it from $this->oLocalFileLogic
	 */

	function __construct( $title, $repo ){
		parent::__construct( $title, $repo );
		
	}

	function  __call( $name, $arguments ){
		if ( method_exists( $this->getLocalFileLogic(), $name ) ){
			return call_user_func_array( array( $this->getLocalFileLogic(), $name ), $arguments );
		} else {
			throw new Exception( 'Method ' .get_class( $this->getLocalFileLogic() ).'::' . $name . ' does not extist' );
		}
	}

	function __set( $name, $value ){
		if ( !isset( $this->$name ) && isset( $this->getLocalFileLogic()->$name ) ){
			$this->getLocalFileLogic()->$name = $value;
		} else {
			$this->$name = $value;
		}
	}

	function __get( $name ){
		if ( !isset( $this->$name ) ) {
			return $this->getLocalFileLogic()->$name;
		} else {
			return $this->$name;
		}
	}

	protected function getLocalFileLogic() {
		if ( empty( $this->oLocalFileLogic ) ){
			$this->oLocalFileLogic = F::build( 'WikiaLocalFileShared', array( $this ) );
		}
		return $this->oLocalFileLogic;
	}

	// No everything can be transparent, because __CALL skips already defined methods.
	// These methods work as a layer of communication between this class and SharedLogic

	function getHandler(){
		wfProfileIn( __METHOD__ );
		if ( !isset( $this->handler ) ) {
			parent::getHandler();
			$this->getLocalFileLogic()->afterGetHandler($this->handler);
		}
		wfProfileOut( __METHOD__ );
		return $this->handler;
	}

	function setProps( $info ) {
		wfProfileIn( __METHOD__ );
		parent::setProps( $info );
		$this->getLocalFileLogic()->afterSetProps();
		wfProfileOut( __METHOD__ );
	}

	function loadFromFile() {
		wfProfileIn( __METHOD__ );
		$this->getLocalFileLogic()->beforeLoadFromFile();
		parent::loadFromFile();
		$this->getLocalFileLogic()->afterLoadFromFile();
		wfProfileOut( __METHOD__ );
	}	
}