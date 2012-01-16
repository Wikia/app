<?php
/**
 * Lite Semantics Pull Parser
 * @author Federico "Lox" Lucignano
 * @see http://www.codem.com.au/streams/2009/web-development/consuming-xml-fast-with-php-and-xmlreader.html
 */

 //test http://codepad.org/xKYZa2RQ
 
class LiteSemanticsParser {
	const DATA_TAG_OPENING = '<data';
	const DATA_TAG_CLOSING = '</data>';

	protected $xmlReader = null;
	protected $dataItems = null;

	function __construct(){
		$this->xmlReader = new XMLReader();
		$this->dataItems = new LiteSemanticsCollection();
	}

	public function parse( $document ){
		$prevIndex = 0;
		$closingLength = strlen( self::DATA_TAG_CLOSING );
		$counter = 0;
		
		while ( ( $startIndex = strpos( $document, '<data', $prevIndex ) ) !== false ) {
			$endIndex = strpos( $document, '</data>', $startIndex );

			if ( $endIndex === false ) {
				throw new LiteSemanticsParserException( $startIndex, substr( $document, $startIndex ) );
			} else {
				$endIndex += $closingLength;
			}

			$markup = substr( $document, $startIndex, $endIndex - $startIndex );
			
			if (
				$this->xmlReader->xml( $markup ) &&
				$this->xmlReader->read() &&
				$this->xmlReader->name == 'data'
			) {
				$data = new LiteSemanticsData( $this->xmlReader->readInnerXML(), $startIndex, $endIndex );

				while ( $this->xmlReader->moveToNextAttribute() ) {
					$data->setAttribute( $this->xmlReader->name, $this->xmlReader->value );
				}
				
				
				while (
					$this->xmlReader->read()
				){
					if(
						$this->xmlReader->nodeType == XMLReader::ELEMENT &&
						$this->xmlReader->name == 'prop'
					){//cannot be checked together with read() in a subtree :(
						$property = new LiteSemanticsProperty( $this->xmlReader->readInnerXML() );//value won't work here as it's embedded in a text node
						$type = null;

						while ( $this->xmlReader->moveToNextAttribute() ) {
							echo($this->xmlReader->name);
							echo('---');
							if ( $this->xmlReader->name == 'type' ) {
								$property->setType( $type = $this->xmlReader->value );
							} else {
								$property->setAttribute( $this->xmlReader->name, $this->xmlReader->value );
							}
						}

						if ( $type !== null && $type !== '' ){
							$data->setProperty( $type, $property);
						} else {
							//TODO: decide if warning, parser exception or specific kind of exception
						}
					}
				}

				$this->dataItems->storeItem( $counter, $data );
			} else {
				throw new LiteSemanticsParserException( $startIndex, $markup );
			}

			$prevIndex = $endIndex;
			$counter++;
		}
	}

	//TODO: implement a LiteSemanticsDocument class as a DTO, which will get data
	public function getData(){
		return $this->dataItems;
	}
}

class LiteSemanticsEntity {
	protected $name = null;
	protected $value = null;

	function __construct( $name, $value = null ){
		$this->name = $name;
		$this->value = $value;
	}

	public function getName(){
		return $this->name;
	}

	public function setName( $name ){
		$this->name = $name;
	}

	public function getValue(){
		return $this->value;
	}

	public function setValue( $value ){
		$this->value = $value;
	}
}

class LiteSemanticsAttribute extends LiteSemanticsEntity{
	function __construct( $name, $value = null){
		parent::__construct( $name, $value );
	}

	function __toString(){
		return $this->name . ( $value !== null ) ? '="' . str_replace( '"', '\"', $value ) . '"' : '';
	}
}

class LiteSemanticsProperty extends LiteSemanticsEntity{
	protected $attributes = null;
	
	function __construct( $value = null ){
		parent::__construct( __CLASS__, $value );
		$this->attributes = new LiteSemanticsCollection();
	}

	public function getType(){
		return $this->name;
	}

	public function setType( $type ){
		$this->name = $type;
	}

	public function hasAttributes(){
		return $this->attributes->count() != 0;
	}

	public function getAttribute( $name ){
		return $this->attributes->getItem( $name );
	}

	public function setAttribute( $name, $value ){
		$this->attributes->storeItem( $name, new LiteSemanticsAttribute( $name, $value ) );	
	}
}

class LiteSemanticsCollection{
	protected $items = null;

	function __construct(){/* ... */}

	public function exists( $name ){
		return $this->items !== null && array_key_exists( $name, $this->items );
	}

	public function storeItem( $name, LiteSemanticsEntity $item ){
		if( $this->items === null ) {
			$this->items = array();
		}

		$this->items[$name] = $item;
	}

	public function getItem( $name ){
		return ( $this->exists( $name ) ) ? $this->items[$name] : null;
	}

	public function removeItem( $name ){
		if ( $this->exists( $name ) ) {
			unset( $this->items[$name] );
		}
	}

	public function count(){
		return ( $this->items !== null ) ? count( $this->items ) : 0;
	}

	public function rewind(){
		reset( $this->items );
    }

    public function current(){
		return current( $this->items );
    }

    public function key(){
		return key( $this->items );
    }

    public function next(){
		return next( $this->items );
    }

    public function valid(){
        $key = key( $this->items );
		return ( $key !== NULL && $key !== FALSE );
    }
}

class LiteSemanticsData extends LiteSemanticsEntity{
	protected $attributes = null;
	protected $properties = null;
	protected $startIndex = null;
	protected $endIndex = null;
	
	function __construct( $content = null, $startIndex = null, $endIndex = null ){
		parent::__construct( /*uniqid(*/__CLASS__/*)*/, $content );
		$this->attributes = new LiteSemanticsCollection();
		$this->properties = new LiteSemanticsCollection();
		$this->startIndex = $startIndex;
		$this->endIndex = $endIndex;
	}
	
	public function hasAttributes(){
		return $this->attributes->count() != 0;
	}

	public function getAttribute( $name ){
		return $this->attributes->getItem( $name );
	}

	public function setAttribute( $name, $value ){
		$this->attributes->storeItem( $name, ( $value instanceof LiteSemanticsAttribute ) ? $value : new LiteSemanticsAttribute( $name, $value ) );	
	}

	public function hasProperties(){
		return $this->properties->count() != 0;
	}

	public function getProperty( $name ){
		return $this->properties->getItem( $name );
	}

	public function setProperty( $name, $value ){
		$this->properties->storeItem( $name, ( $value instanceof LiteSemanticsProperty ) ? $value : new LiteSemanticsProperty( $name, $value ) );	
	}
}

class LiteSemanticsParserException extends Exception{
	function __construct( $index, $invalidMarkup = null ){
		parent::__construct( "Invalid Lite Semantics markup at index {$index}" . ( !empty( $invalidMarkup ) ) ? ": <pre>{$invalidMarkup}</pre>" : '' );
	}
}
?>