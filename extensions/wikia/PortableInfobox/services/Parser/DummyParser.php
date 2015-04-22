<?php

namespace Wikia\PortableInfobox\Parser;

class DummyParser implements \Wikia\PortableInfobox\Parser\ExternalParser {
	public function parse( $text ) {
		return "parse($text)";
	}

	public function parseRecursive( $text ) {
		return "parseRecursive($text)";
	}
}
