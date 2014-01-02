<?php

/**
 * Class WikiaForeignDBFile
 *
 * Wikia wrapper on ForeignDBFile.
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
	 *
	 * @param object $row A result row object
	 * @param string $repo The repository name
	 * @return WikiaForeignDBFile
	 */
	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->img_name );
		/* @var $file WikiaForeignDBFile */
		$file = new static( $title, $repo );
		$file->loadFromRow( $row );
		return $file;
	}

	/**
	 * Composite/Leaf interface
	 * If no method of var found in current object tries to get it from $this->oLocalFileLogic
	 * @param false|string|Title $title
	 * @param false|FileRepo $repo
	 */
	function __construct( $title, $repo ) {
		parent::__construct( $title, $repo );
		
	}

	function  __call( $name, $arguments ) {
		if ( method_exists( $this->getLocalFileLogic(), $name ) ) {
			return call_user_func_array( array( $this->getLocalFileLogic(), $name ), $arguments );
		} else {
			throw new Exception( 'Method ' .get_class( $this->getLocalFileLogic() ).'::' . $name . ' does not extist' );
		}
	}

	function __set( $name, $value ) {
		if ( !isset( $this->$name ) && isset( $this->getLocalFileLogic()->$name ) ) {
			$this->getLocalFileLogic()->$name = $value;
		} else {
			$this->$name = $value;
		}
	}

	function __get( $name ) {
		if ( !isset( $this->$name ) ) {
			return $this->getLocalFileLogic()->$name;
		} else {
			return $this->$name;
		}
	}

	protected function getLocalFileLogic() {
		if ( empty( $this->oLocalFileLogic ) ) {
			$this->oLocalFileLogic = new WikiaLocalFileShared( $this );
		}
		return $this->oLocalFileLogic;
	}

	// Not everything can be transparent, because __call skips already defined methods.
	// These methods work as a layer of communication between this class and SharedLogic

	/**
	 * Override the getUser method for foreign files to return the user that originally added the
	 * video rather than the one who uploaded it to the foreign repo
	 * @param string $type
	 * @return int|string
	 */
	public function getUser( $type = 'text' ) {
		// Try to get video info for this file
		$info = VideoInfo::newFromTitle( $this->getName() );
		if ( !empty($info) ) {
			$addedBy = $info->getAddedBy();
		}

		// If we got an addedBy user ID, use that otherwise fall back to the parent method
		if ( !empty($addedBy) ) {
			if ( $type == 'text' ) {
				$user = User::newFromId( $addedBy );
				if ( $user instanceof User ) {
					return $user->getName();
				}
			} else {
				return $addedBy;
			}
		}

		return parent::getUser( $type );
	}

	function getHandler() {
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

	public function getMetaDescription () {
		$meta = unserialize($this->getMetadata());
		return empty($meta['description']) ? '' : $meta['description'];
	}
}