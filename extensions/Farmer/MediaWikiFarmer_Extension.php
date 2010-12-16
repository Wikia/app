<?php

/**
 * Represents an extension for MediaWiki
 * Created on Jul 20, 2006
 *
 * @author Gregory Szorc <gregory.szorc@gmail.com>
 */
class MediaWikiFarmer_Extension {
	protected $_name;
	protected $_description;
	protected $_id;

	/**
	 * List of files that need to be included for this extension to work
	 */
	protected $_includeFiles = array();

	public static function newFromRow( $row ) {
		$ext = new self( $row->fe_name, $row->fe_description, $row->fe_path );
		$ext->_id = $row->fe_id;
		return $ext;
	}

	public function __construct( $name, $description, $include ) {
		$this->_name = $name;
		$this->_description = $description;
		$this->_includeFiles[] = $include;
	}

	/**
	 * Magic method so we can access variables directly without accessor
	 * functions
	 */
	public function __get( $key ) {
		$property = '_' . $key;

		return isset( $this->$property ) ? $this->$property : null;
	}

	/**
	 * Sees if extension is valid by looking at included files and attempting to
	 * open them
	 */
	public function isValid() {
		foreach ( $this->_includeFiles as $file ) {
			$result = @fopen( $file, 'r', true );

			if ( $result === false ) return false;

			fclose( $result );
		}

		return true;
	}
}
