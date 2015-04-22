<?php
namespace Wikia\CollectionView\Parser;

interface ExternalParser {
	public function parse( $text );
}