<?php
/**
 * @author ADi
 */
class SDParserTagPropertyPath {

	private $elementHash = null;
	private $elementType = null;
	private $elementName = null;
	private $chain = array();

	public function __construct( $pathString ) {
		$this->processPathString( $pathString );
	}

	private function processPathString( $pathString ) {
		$pathParts = explode( '/', $pathString );
		if( count( $pathParts ) >= 2 ) {
			if( strpos( $pathParts[0], '#') === 0 ) {
				$this->elementHash = substr( $pathParts[0], 1 );
				$this->chain = array_slice( $pathParts, 1, count($pathParts) );
			}
			else {
				$this->elementType = $pathParts[0];
				$this->elementName = $pathParts[1];
				$this->chain = array_slice( $pathParts, 2, count($pathParts) );
			}
		}
	}

	public function getElementId() {
		return $this->hasElementHash() ? $this->elementHash : ( $this->elementType . '/' . $this->elementName );
	}

	public function getElementHash() {
		return $this->elementHash;
	}

	public function hasElementHash() {
		return ( !empty( $this->elementHash ) ? true : false );
	}

	public function getElementName() {
		return $this->elementName;
	}

	public function getElementType() {
		return $this->elementType;
	}


}
