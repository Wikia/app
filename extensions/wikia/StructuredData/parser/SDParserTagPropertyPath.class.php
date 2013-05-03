<?php
/**
 * @author ADi
 */
class SDParserTagPropertyPath {

	private $elementHash = null;
	private $elementType = null;
	private $elementName = null;
	private $chain = array();
	private $position = -1;

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

	/**
	 * get next property from path
	 * @param SDElement $element
	 * @return SDParserTagProperty
	 */
	public function next(SDElement $element) {
		if( $this->hasNext() ) {
			$this->position++;
			$propName = $this->chain[$this->position];
			$valueIndex = null;

			$matches = array();
			preg_match('/([a-z,0-9,:,_]{1,})\[(\d{1,})\]/i', $propName, $matches);
			if(count($matches) == 3) {
				$propName = $matches[1];
				$valueIndex = $matches[2];
			}

			return new SDParserTagProperty( $propName, $element->getProperty( $propName ), $valueIndex );
		}
		return false;
	}

	public function hasNext() {
		return isset($this->chain[$this->position+1]);
	}

	public function rewind() {
		$this->position = -1;
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
