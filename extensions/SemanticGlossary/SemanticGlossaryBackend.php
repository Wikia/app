<?php

/**
 * File holding the SemanticGlossaryBackend class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticGlossary
 */
if ( !defined( 'SG_VERSION' ) ) {
	die( 'This file is part of the SemanticGlossary extension, it is not a valid entry point.' );
}

/**
 * The SemanticGlossaryBackend class.
 *
 * @ingroup SemanticGlossary
 */
class SemanticGlossaryBackend extends LingoBackend {

	protected $mQueryResult;

	public function __construct( LingoMessageLog &$messages = null ) {

		parent::__construct( $messages );

		// get the store
		$store = smwfGetStore();

		// Create query
		$desc = new SMWSomeProperty( new SMWDIProperty( '___glt' ), new SMWThingDescription() );
		$desc->addPrintRequest( new SMWPrintRequest( SMWPrintRequest::PRINT_PROP, null, SMWPropertyValue::makeProperty( '___glt' ) ) );
		$desc->addPrintRequest( new SMWPrintRequest( SMWPrintRequest::PRINT_PROP, null, SMWPropertyValue::makeProperty( '___gld' ) ) );
		$desc->addPrintRequest( new SMWPrintRequest( SMWPrintRequest::PRINT_PROP, null, SMWPropertyValue::makeProperty( '___gll' ) ) );

		$query = new SMWQuery( $desc, false, false );
		$query->sort = true;
		$query->sortkeys['___glt'] = 'ASC';

		// get the query result
		$this->mQueryResult = $store->getQueryResult( $query );
	}

	/**
	 * This function returns the next element. The element is an array of four
	 * strings: Term, Definition, Link, Source. If there is no next element the
	 * function returns null.
	 *
	 * @return the next element or null
	 */
	public function next() {

		$ret = null;

		// find next line
		while ( !$ret && ( $resultline = $this->mQueryResult->getNext() ) ) {

			$term = $resultline[0]->getNextText( SMW_OUTPUT_WIKI );
			$definition = $resultline[1]->getNextText( SMW_OUTPUT_WIKI );
			$link = $resultline[2]->getNextText( SMW_OUTPUT_WIKI );

			// FIXME: By not checking for 2nd term defined on the same page some
			// time could be saved. However, no message could then be generated.
			// Introduce a setting?
			$nextTerm = $resultline[0]->getNextText( SMW_OUTPUT_WIKI );
			$nextDefinition = $resultline[1]->getNextText( SMW_OUTPUT_WIKI );
			$nextLink = $resultline[2]->getNextText( SMW_OUTPUT_WIKI );


			// FIXME: SMW has a bug that right after storing data this data
			// might be available twice. The workaround here is to compare the
			// first and second result and if they are identical assume that
			// it is because of the bug. (2nd condition in the if below)
			// skip if more then one term or more than one definition present
			if ( ( $nextTerm || $nextDefinition || $nextLink ) &&
				!( $nextTerm == $term && $nextDefinition == $definition && $nextLink == $link ) ) {

				if ( $ml = $this->getMessageLog() ) {
					$ml->addMessage(
						wfMsg( 'semanticglossary-termdefinedtwice',
							array($resultline[0]->getResultSubject()->getTitle()->getPrefixedText()) ),
							LingoMessageLog::MESSAGE_WARNING );
				}

				continue;
			}

			$ret = array(
				LingoElement::ELEMENT_TERM => $term,
				LingoElement::ELEMENT_DEFINITION => $definition,
				LingoElement::ELEMENT_LINK => $link,
				LingoElement::ELEMENT_SOURCE => $resultline[0]->getResultSubject()
			);
		}

		return $ret;
	}

}
