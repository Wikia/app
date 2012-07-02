<?php
#
# The Link class represents internal links of the form [[x::y|z]] (x and z being optional)
#
require_once( 'Util.php' );

class POMLink extends POMElement {
	protected $destination;
	protected $properties = array();
	protected $display = null;

	public function POMLink( $text ) {
		$this->children = null; // forcefully ignore children

		# Remove braces at the beginning and at the end
		$text = substr( $text, 2, strlen( $text ) - 4 );

		# Split by pipe
		$parts = explode( '|', $text );
		if ( count( $parts ) > 2 ) {
			die( "[ERROR] Parsing a link with more than one pipe character: [[" . $text . "]]\n" );
		}
		if ( count( $parts ) == 2 ) {
			$this->display = $parts[1];
		}
		# Split first part by ::
		$moreparts = explode( "::", $parts[0] );
		$this->destination = new POMUtilTrimTriple( $moreparts[count( $moreparts ) - 1] );
		if ( count( $moreparts ) > 1 ) {
			for ( $i = 0; $i < count( $moreparts ) - 1; $i++ ) {
				$this->properties[] = new POMUtilTrimTriple( $moreparts[$i] );
			}
		}
	}
	
	public function getDestination() {
		return $this->destination->trimmed;
	}

	public function getProperties() {
		$return = array();
		foreach ( $this->properties as $property ) $return[] = $property->trimmed;
		return $return;
	}
	
	public function removePropertyByNumber( $i ) {
		if ( $i < 0 ) return;
		if ( $i >= count( $this->properties ) ) return;
		unset( $this->properties[$i] );
	}
	
	public function getDisplay() {
		return $this->display;
	}

	public function asString() {
		if ( $this->hidden() ) return "";
		$text = '[[';
		foreach ( $this->properties as $property ) $text .= $property->toString() . '::';
		$text .= $this->destination->toString();
		if ( !is_null( $this->display ) ) $text .= '|' . $this->display;
		$text .= ']]';
		return $text;
	}
}
