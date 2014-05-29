<?php

/**
 * File holding the LingoElement class.
 *
 * @author Stephan Gambke
 *
 * @file
 * @ingroup Lingo
 */
if ( !defined( 'LINGO_VERSION' ) ) {
	die( 'This file is part of the Lingo extension, it is not a valid entry point.' );
}

/**
 * This class represents a term-definition pair.
 * One term may be related to several definitions.
 *
 * @ingroup Lingo
 */
class LingoElement {
	const ELEMENT_TERM = 0;
	const ELEMENT_DEFINITION = 1;
	const ELEMENT_SOURCE = 2;
	const ELEMENT_LINK = 3;

	private $mFullDefinition = null;
	private $mDefinitions = array();
	private $mTerm = null;
	private $mHasBeenDisplayed = false;

	static private $mLinkTemplate = null;

	public function __construct( &$term, &$definition = null ) {

		$this->mTerm = $term;

		if ( $definition ) {
			$this->addDefinition( $definition );
		}
	}

	public function addDefinition( &$definition ) {
		$this->mDefinitions[] = $definition;
	}

	public function getFullDefinition( DOMDocument &$doc ) {

		global $wgexLingoDisplayOnce;

		wfProfileIn( __METHOD__ );
		
		// return textnode if
		if ( $wgexLingoDisplayOnce && $this->mHasBeenDisplayed ) {
			wfProfileOut( __METHOD__ );
			return $doc->createTextNode($this->mTerm);
		}
		
		// only create if not yet created
		if ( $this->mFullDefinition == null || $this->mFullDefinition->ownerDocument !== $doc ) {

			// Wrap term and definition in <span> tags
			$span = $doc->createElement( 'span' );
			$span->setAttribute( 'class', 'tooltip' );

			// Wrap term in <span> tag, hidden
			wfSuppressWarnings();
			$spanTerm = $doc->createElement( 'span', htmlentities( $this->mTerm, ENT_COMPAT, 'UTF-8' ) );
			wfRestoreWarnings();
			$spanTerm->setAttribute( 'class', 'tooltip_abbr' );

			// Wrap definition in two <span> tags
			$spanDefinitionOuter = $doc->createElement( 'span' );
			$spanDefinitionOuter->setAttribute( 'class', 'tooltip_tipwrapper' );

			$spanDefinitionInner = $doc->createElement( 'span' );
			$spanDefinitionInner->setAttribute( 'class', 'tooltip_tip' );

			foreach ( $this->mDefinitions as $definition ) {
				wfSuppressWarnings();
				$element = $doc->createElement( 'span', htmlentities( $definition[self::ELEMENT_DEFINITION], ENT_COMPAT, 'UTF-8' ) );
				wfRestoreWarnings();
				if ( $definition[self::ELEMENT_LINK] ) {
					$linkedTitle = Title::newFromText( $definition[self::ELEMENT_LINK] );
					if ( $linkedTitle ) {
						$link = $this->getLinkTemplate( $doc );
						$link->setAttribute( 'href', $linkedTitle->getFullURL() );
						$element->appendChild( $link );
					}
				}
				$spanDefinitionInner->appendChild( $element );
			}

			// insert term and definition
			$span->appendChild( $spanTerm );
			$span->appendChild( $spanDefinitionOuter );
			$spanDefinitionOuter->appendChild( $spanDefinitionInner );

			$this->mFullDefinition = $span;
			$this->mHasBeenDisplayed = true;
		}

		wfProfileOut( __METHOD__ );
		
		return $this->mFullDefinition->cloneNode( true );
	}

	public function getCurrentKey() {
		return key( $this->mDefinitions );
	}

	public function getTerm( $key ) {
		return $this->mDefinitions[$key][self::ELEMENT_TERM];
	}

	public function getSource( &$key ) {
		return $this->mDefinitions[$key][self::ELEMENT_SOURCE];
	}

	public function getDefinition( &$key ) {
		return $this->mDefinitions[$key][self::ELEMENT_DEFINITION];
	}

	public function getLink( &$key ) {
		return $this->mDefinitions[$key][self::ELEMENT_LINK];
	}

	public function next() {
		next( $this->mDefinitions );
	}

	private function getLinkTemplate( DOMDocument &$doc ) {
		// create template if it does not yet exist
		if ( !self::$mLinkTemplate || ( self::$mLinkTemplate->ownerDocument !== $doc ) ) {
			global $wgScriptPath;

			$linkimage = $doc->createElement( 'img' );
			$linkimage->setAttribute( 'src', $wgScriptPath . '/extensions/Lingo/skins/linkicon.png' );

			self::$mLinkTemplate = $doc->createElement( 'a' );
			self::$mLinkTemplate->appendChild( $linkimage );
		}

		return self::$mLinkTemplate->cloneNode( true );
	}

}
