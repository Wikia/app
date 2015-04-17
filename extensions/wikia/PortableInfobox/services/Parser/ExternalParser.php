<?php
namespace Wikia\PortableInfobox\Parser;

interface ExternalParser {
	public function parse( $text );
}
