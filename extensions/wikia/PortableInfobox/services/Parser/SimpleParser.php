<?php
namespace Wikia\PortableInfobox\Parser;

class SimpleParser implements ExternalParser {
	public function parseRecursive( $text ) {
		return $text;
	}

	public function replaceVariables( $text ) {
		return $text;
	}

	public function addImage( $title ) {
		//do nothing
	}
}
