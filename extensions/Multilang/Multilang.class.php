<?php

class Multilang {

	/**
	 * Alternative text blocks
	 * Index is the language code to which it corresponds
	 */
	private $text = array();
	
	/**
	 * Fallback language
	 */
	private $fallback = '';

	/**
	 * Register a new alternative text block
	 * (Handles the parser hook for <language></language>)
	 *
	 * @param $text Content
	 * @param $args Tag attributes
	 * @param $parser Parent parser
	 * @return string
	 */
	public function languageBlock( $text, $args, &$parser ) {
		if( isset( $args['lang'] ) ) {
			$lang = strtolower( $args['lang'] );
			$this->text[$lang] = $text;
			$this->updateFallback( $lang );
		} else {
			# Disaster! We *have* to know the language code, otherwise
			# we have no idea when to show the text in question
		}
		return '';
	}
	
	/**
	 * Output the appropriate text block
	 * (Handles the parser hook for <multilang />)
	 *
	 * @param $text Content
	 * @param $args Tag attributes
	 * @param $parser Parent parser
	 * @return string
	 */
	public function outputBlock( $text, $args, &$parser ) {
		global $wgLang;
		# Cache is varied according to interface language...
		$lang = $wgLang->getCode();
		$text = $this->getText( $lang );
		$output = $parser->parse( $text, $parser->getTitle(), $parser->getOptions(), true, false );
		return $output->getText();
	}
	
	/**
	 * Get the text block corresponding to the requested language code,
	 * or the fallback if needed
	 *
	 * @param $lang Language code
	 * @return string
	 */
	private function getText( $lang ) {
		return isset( $this->text[$lang] ) ? $this->text[$lang] : $this->getFallback();
	}
	
	/**
	 * Get the fallback text
	 *
	 * @return string
	 */
	private function getFallback() {
		return isset( $this->text[$this->fallback] ) ? $this->text[$this->fallback] : '';
	}
	
	/**
	 * When a new text block is made available, look at the language
	 * code, and see if it's a better fallback than the one we have
	 *
	 * @param $lang Language code
	 */
	private function updateFallback( $lang ) {
		global $wgContLang;
		if( $this->fallback == '' || $lang == $wgContLang->getCode() ) {
			$this->fallback = $lang;
		}
	}
	
	/**
	 * Clear all internal state information
	 */
	public function clearState() {
		$this->text = array();
		$this->fallback = '';
		return true;
	}
	
}


