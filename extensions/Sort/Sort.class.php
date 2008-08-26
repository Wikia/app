<?php

/**
 * Parser hook extension adds a <sort> tag to wiki markup
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006-2007 Rob Church
 * @licence GNU General Public Licence 2.0
 */
class Sorter {

	private $parser = null;
	
	private $order = 'asc';
	private $class = 'ul';

	/**
	 * Constructor
	 *
	 * @param Parser $parser Parent parser
	 */
	public function __construct( $parser ) {
		$this->parser = $parser;
		$this->order = 'asc';
		$this->class = 'ul';
	}

	/**
	 * Load settings for this sort operation
	 *
	 * @param array $settings Tag arguments
	 */
	public function loadSettings( $settings ) {
		foreach( $settings as $name => $value ) {
			$value = strtolower( $value );
			switch( $name ) {
				case 'class':
					if( $value == 'ul' || $value == 'ol' )
						$this->class = $value;
					break;
				case 'order':
					$this->order = $value == 'desc'
						? 'desc'
						: 'asc';
			}
		}
	}

	/**
	 * Sort a blob of text by line and return a list
	 * in the desired format
	 *
	 * @param string $text Text to sort
	 * @return string
	 */
	public function sort( $text ) {
		wfProfileIn( __METHOD__ );
		$html = $this->parse( $this->makeList( $this->internalSort( $text ) ) );
		wfProfileOut( __METHOD__ );
		return $html;
	}

	/**
	 * Perform an alphanumeric sort of a blob of text,
	 * returning a sorted array containing each line
	 *
	 * @param string $text Text to sort
	 * @return string
	 */
	protected function internalSort( $text ) {
		wfProfileIn( __METHOD__ );
		$lines = array();
		foreach( explode( "\n", $text ) as $line ) {
			$line = ltrim( $line, '*# ' );
			$lines[ $line ] = $this->stripWikiTokens( $line );
		}
		natsort( $lines );
		if( $this->order == 'desc' )
			$lines = array_reverse( $lines, true );
		wfProfileOut( __METHOD__ );
		return array_keys( $lines );
	}

	/**
	 * Strip braces and brackets from the text
	 *
	 * @param string $text Text to transform
	 * @return string
	 */
	protected function stripWikiTokens( $text ) {
		$find = array( '[', '{', '\'', '}', ']' );
		return str_replace( $find, '', $text );
	}

	/**
	 * Build a wiki text list of sorted lines
	 *
	 * @param array $lines List items, sorted
	 * @return string
	 */
	protected function makeList( $lines ) {
		$list = array();
		$token = $this->class == 'ul' ? '*' : '#';
		foreach( $lines as $line )
			if( strlen( $line ) > 0 )
				$list[] = "{$token} {$line}";
		return trim( implode( "\n", $list ) );
	}

	/**
	 * Parse text and return the result
	 *
	 * @param string $text Text to parse
	 * @return string
	 */
	protected function parse( $text ) {
		wfProfileIn( __METHOD__ );
		$output = $this->parser->parse( $text, $this->parser->mTitle,
			$this->parser->mOptions, true, false );
		wfProfileOut( __METHOD__ );
		return $output->getText();
	}

}