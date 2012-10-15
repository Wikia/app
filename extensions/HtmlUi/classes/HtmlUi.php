<?php

abstract class HtmlUi {
	
	/* Static Methods */
	
	public static function createForm( array $elements = array() ) {
		foreach ( $elements as $path => $options ) {
			$id = end( explode( '/', $path ) );
			// Build out a structured form from a flat list of elements
		}
	}
}
