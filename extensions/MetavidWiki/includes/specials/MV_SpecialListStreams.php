<?php
/**
 * MV_SpecialListStreams.php Created on Apr 24, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class MV_SpecialListStreams extends SpecialPage {
	public function __construct() {
		parent::__construct( 'Mv_List_Streams' );
	}
	function execute( $par ) {
		list( $limit, $offset ) = wfCheckLimits();
		$rep = new MV_SpecialQueryStreams();
		return $rep->doQuery( $offset, $limit );
	}
}
class MV_SpecialListStreams extends QueryPage {
	public function __construct( $name = 'Mv_List_Streams' ) {
		parent::__construct( $name );
	}

	function isExpensive() {
		return false;
	}

	function isSyndicated() { return true; }

	function getPageHeader() {
		return '<p>' . wfMsg( 'mv_list_streams_docu' ) . "</p><br />\n";
	}

	function getQueryInfo() {
		// $relations = $dbr->tableName( 'smw_relations' );
		// $NSrel = SMW_NS_RELATION;
		# QueryPage uses the value from this SQL in an ORDER clause.
		/*return "SELECT 'Relations' as type,
					{$NSrel} as namespace,
					relation_title as title,
					relation_title as value,
					COUNT(*) as count
					FROM $relations
					GROUP BY relation_title";*/
		/* @@todo replace with query that displays more info
		 * such as
		 * date modified
		 * stream length
		 * formats available
		 * number of associative metadata chunks */

		return array(
			'tables' => array( 'mv_streams' ),
			'fields' => array( 'id AS stream_id', 'name AS title', 'name AS value' )
		);
	}

	function getOrder() {
		return ' ORDER BY date_start_time DESC ';
			// ($this->sortDescending() ? 'DESC' : '');
	}

	function getOrderFields() {
		return array( 'date_start_time' );
	}

	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		global $wgUser, $wgLang, $mvImageArchive;

		# make sure the first letter is upper case (makeTitle() should do that)
		$result->title = strtoupper( $result->title[0] ) . substr( $result->title, 1 );
		$img_url = $mvImageArchive . $result->title . '?size=icon&time=0:00:00';
		$img_url = MV_StreamImage::getStreamImageURL( $result->stream_id, '0:00:10', 'icon', true );
		$img_html = '<img src="' . htmlspecialchars( $img_url ) . '" width="80" height="60">';


		$title = Title::makeTitle( MV_NS_STREAM, $result->title  );
		$rlink = $skin->makeLinkObj( $title,  $img_html . ' ' . htmlspecialchars( $title->getText() )  );
		// if admin expose an edit link
		if ( $wgUser->isAllowed( 'delete' ) ) {
			$rlink .= ' ' . $skin->makeKnownLinkObj( Title::makeTitle( MV_NS_STREAM, $title->getText() ),
						'edit', 'action=edit' );
		}
		return $rlink;
	}
}
