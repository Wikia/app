<?php
/** \file
* \brief Contains code for the StalePages Class (extends QueryPage).
*/

///Class for the Stale Pages extension
/**
 * Special page that generates a list of pages that have
 * not been edited in a given timeframe.
 *
 * @ingroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 */
class Stalepages extends QueryPage
{
	public function __construct( $name = 'StalePages' ) {
		parent::__construct( $name );
	}

	function isExpensive() {
		return true;
	}

	function getPageHeader() {
		global $wgStalePagesDays;
		return wfMsgExt( 'stalepages-summary', array( 'parse' ), $wgStalePagesDays );
	}

	function isSyndicated() { return false; }

	function getQueryInfo() {
		global $wgStalePagesDays;
		$date = mktime() - ( 60 * 60 * 24 * $wgStalePagesDays ); //randomish
		$db = wfGetDB( DB_SLAVE );
		$dateString = $db->timestamp($date);
		return array(
			'tables' => array( 'page', 'revision' ),
			'fields' => array( 'page_namespace AS namespace', 'page_title AS title', 'rev_timestamp AS value' ),
			'conds' => array( 'page_latest=rev_id',
				'page_namespace' => NS_MAIN,
				'page_is_redirect=0',
				'rev_timestamp < ' . $db->addQuotes( $dateString ) ,
			)
		);
	}

	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang;

		$d = $wgLang->timeanddate( wfTimestamp( TS_MW, $result->value ), true );
		$title = Title::makeTitle( $result->namespace, $result->title );
		$link = $skin->makeKnownLinkObj( $title, htmlspecialchars( $wgContLang->convert( $title->getPrefixedText() ) ) );
		return $wgLang->specialList( $link, $d );
	}
}
