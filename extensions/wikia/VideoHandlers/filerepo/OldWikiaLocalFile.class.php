<?php

class OldWikiaLocalFile extends OldLocalFile {

	protected $oLocalFileLogic = null; // Leaf object

	/* obligatory constructors */

	/* @param Title $title
	 * @param FileRepo $repo
	 * @param string $time Timestamp or null to load by archive name
	 * @param string $archiveName Archive name or null to load by timestamp
	 */
	
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

		wfProfileIn( __METHOD__ );

		# Polymorphic function name to distinguish foreign and local fetches

		$dbr = $repo->getSlaveDB();
		$conds = array( 'oi_sha1' => $sha1 );
		if( $timestamp ) {
			$conds['oi_timestamp'] = $timestamp;
		}
		$row = $dbr->selectRow( 'oldimage', self::getCacheFields( 'oi_' ), $conds, __METHOD__ );

		wfProfileOut( __METHOD__ );

		if( $row ) {
			return self::newFromRow( $row, $repo );
		} else {
			return false;
		}
	}

	/* Composite/Leaf interface
	 *
	 * if no method of var found in current object tries to get it from $this->oLocalFileLogic
	 */

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
			$this->oLocalFileLogic = new WikiaLocalFileShared( $this );
		}
		return $this->oLocalFileLogic;
	}

	/*
	 * No everything can be transparent, because __CALL skips already defined methods.
	 * These methods work as a layer of communication between this class and SharedLogic
	 */

	function getHandler(){
		wfProfileIn( __METHOD__ );
		parent::getHandler();
		$this->getLocalFileLogic()->afterGetHandler($this->handler);
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
