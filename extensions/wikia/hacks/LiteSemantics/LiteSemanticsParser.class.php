<?php
/**
 * Lite Semantics Pull Parser
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @see http://www.codem.com.au/streams/2009/web-development/consuming-xml-fast-with-php-and-xmlreader.html
 */

 //test http://codepad.org/xKYZa2RQ

class LiteSemanticsParser extends WikiaObject{
	const DATA_TAG_OPENING = '<data';
	const DATA_TAG_CLOSING = '</data>';

	protected $xmlReader = null;

	function __construct(){
		$this->xmlReader = new XMLReader();
	}

	public function parse( $text, Title $title = null ){
		$document = new LiteSemanticsDocument( $text, $title, true );
		$prevIndex = 0;
		$closingLength = strlen( self::DATA_TAG_CLOSING );

		while ( ( $startIndex = strpos( $text, '<data', $prevIndex ) ) !== false ) {
			$endIndex = strpos( $text, '</data>', $startIndex );

			if ( $endIndex === false ) {
				throw new LiteSemanticsParserException( $startIndex, $title, substr( $text, $startIndex ) );
			} else {
				$endIndex += $closingLength;
			}

			$markup = substr( $text, $startIndex, $endIndex - $startIndex );

			if (
				$this->xmlReader->xml( $markup ) &&
				$this->xmlReader->read() &&
				$this->xmlReader->name == 'data'
			) {
				$data = new LiteSemanticsData( $this->xmlReader->readInnerXML(), $startIndex, $endIndex );

				while ( $this->xmlReader->moveToNextAttribute() ) {
					$data->setAttribute( new LiteSemanticsAttribute( $this->xmlReader->name, $this->xmlReader->value ) );
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
							if ( $this->xmlReader->name == 'type' ) {
								$property->setType( $type = $this->xmlReader->value );
							} else {
								$property->setAttribute( new LiteSemanticsAttribute( $this->xmlReader->name, $this->xmlReader->value ) );
							}
						}

						if ( $type !== null && $type !== '' ){
							$data->setProperty( $type, $property);
						} else {
							//TODO: decide if warning, parser exception or specific kind of exception
						}
					}
				}

				$document->addItem( $data );
			} else {
				throw new LiteSemanticsParserException( $startIndex, $title, $markup );
			}

			$prevIndex = $endIndex;
		}

		return $document;
	}
}

class LiteSemanticsParserException extends Exception{
	function __construct( $index, Title $title = null, $invalidMarkup = null ){
		parent::__construct( "Invalid Lite Semantics markup at index {$index}" . ( !empty( $invalidMarkup ) ) ? ": <pre>{$invalidMarkup}</pre>" : '' . ( $title instanceof Title ) ? ' (URL: ' . $title->getFullUrl() . ')' : '' );
	}
}
