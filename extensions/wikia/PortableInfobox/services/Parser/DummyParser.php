<?php

namespace Wikia\PortableInfobox\Parser;

class DummyParser implements ExternalParser {
	public function parse( $text ) {
		return "parse($text)";
	}

	public function parseRecursive( $text ) {
		return "parseRecursive($text)";
	}

	public function replaceVariables( $text ) {
		return "replaceVariables($text)";
	}
}
