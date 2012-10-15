<?php

/**
 * Class for logging changes to objects managed by the Education Program extension. 
 *
 * @since 0.1
 *
 * @file EPLogFormatter.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPLogFormatter extends LogFormatter {

	/**
	 * (non-PHPdoc)
	 * @see LogFormatter::makePageLink()
	 * 
	 * @since 0.1
	 * 
	 * This is overridden to change the link text to only include the name of the object,
	 * rather then the full name of it's page.
	 */
	protected function makePageLink( Title $title = null, $parameters = array() ) {
		if ( !$title instanceof Title ) {
			throw new MWException( "Expected title, got null" );
		}
		
		$text = explode( '/', $title->getText(), 2 );
		$text = $text[count( $text ) - 1];
		
		if ( !$this->plaintext ) {
			$link = Linker::link( $title, htmlspecialchars( $text ), array(), $parameters );
		} else {

			$link = '[[' . $title->getPrefixedText() . '|' . $text . ']]';
		}
		return $link;
	}
	
}
