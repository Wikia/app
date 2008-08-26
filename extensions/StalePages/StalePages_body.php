<?php
/** \file
* \brief Contains code for the StalePages Class (extends QueryPage).
*/

///Class for the Stale Pages extension
/**
 * Special page that generates a list of pages that have
 * not been edited in a given timeframe.
 *
 * @addtogroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 */

class Stalepages extends SpecialPage
{
	///StalePages Class Constructor
	public function __construct() {
		SpecialPage::SpecialPage( 'Stalepages' );
	}

	function getDescription() {
		return wfMsg( 'stalepages' );
	}

	function execute( $parameters ) {
		global $wgVersion;
		if( version_compare( $wgVersion, '1.11', '>=' ) )
			wfLoadExtensionMessages( 'Stalepages' );

		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();

		$sp = new StalepagesPage();

		$sp->doQuery( $offset, $limit );
	}
}

class StalepagesPage extends QueryPage
{
	function getName() {
		return "Stalepages";
	}

	function isExpensive() {
		return true;
	}

	function getPageHeader() {
		global $wgOut;
		return $wgOut->parse( wfMsg( 'stalepages-summary', 270) );
	}

	function isSyndicated() { return false; }

	function getSQL() {
		global $wgDBtype;
		$db = wfGetDB( DB_SLAVE );
		$page = $db->tableName( 'page' );
		$revision = $db->tableName( 'revision' );
		$epoch = $wgDBtype == 'mysql' ? 'UNIX_TIMESTAMP(rev_timestamp)' :
			'EXTRACT(epoch FROM rev_timestamp)';

		$date = mktime() - (60*60*24*270);	//ranomish
		$dateString = $db->timestamp($date);

		return
			"SELECT 'Stalepages' as type,
			page_namespace as namespace,
			page_title as title,
			$epoch as value
			FROM $page, $revision
			WHERE page_latest=rev_id
			AND page_namespace=" . NS_MAIN . "
			AND page_is_redirect=0
			AND rev_timestamp < '$dateString'";
	}

	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang;

		$d = $wgLang->timeanddate( wfTimestamp( TS_MW, $result->value ), true );
		$title = Title::makeTitle( $result->namespace, $result->title );
		$link = $skin->makeKnownLinkObj( $title, htmlspecialchars( $wgContLang->convert( $title->getPrefixedText() ) ) );
		return wfSpecialList($link, $d);
	}
}
