<?php
namespace Wikia\PortableInfobox\Parser;

class SimpleParser implements ExternalParser {
	public function parse( $text ) {
		return $text;
	}

	public function parseRecursive( $text ) {
		return $this->parse( $text );
	}

}