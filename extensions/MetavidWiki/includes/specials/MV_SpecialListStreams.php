<?php
/*
 * MV_SpecialListStreams.php Created on Apr 24, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
  
if (!defined('MEDIAWIKI')) die();


function doSpecialListStreams($par = null) {
	list( $limit, $offset ) = wfCheckLimits();
	$rep = new MV_SpecialListStreams();
	return $rep->doQuery( $offset, $limit );
}

SpecialPage::addPage( new SpecialPage('Mv_List_Streams','',true,'doSpecialListStreams',false) );

class MV_SpecialListStreams extends QueryPage {

	function getName() {
		return "MV_List_Streams";
	}

	function isExpensive() {
		return false;
	}

	function isSyndicated() { return true; }

	function getPageHeader() {		
		return '<p>' . wfMsg('mv_list_streams_docu') . "</p><br />\n";
	}
	function getSQL() {
		global $mvStreamTable;
		$dbr =& wfGetDB( DB_SLAVE );
		//$relations = $dbr->tableName( 'smw_relations' );
		//$NSrel = SMW_NS_RELATION;
		# QueryPage uses the value from this SQL in an ORDER clause.
		/*return "SELECT 'Relations' as type,
					{$NSrel} as namespace,
					relation_title as title,
					relation_title as value,
					COUNT(*) as count
					FROM $relations
					GROUP BY relation_title";*/
		$mv_streams_table = $dbr->tableName( $mvStreamTable );
		/* @@todo replace with query that displays more info
		 * such as 
		 * date modified 
		 * stream length
		 * formats available
		 * number of associative metadata chunks */
		return "SELECT
				`id` as `stream_id`,
				`name` as title,
				`name` as value " . 
				"FROM $mv_streams_table ";
				
	}
	function getOrder() {
		return ' ORDER BY `mv_streams`.`date_start_time` DESC ';
			//($this->sortDescending() ? 'DESC' : '');
	}
	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		global $wgUser, $wgLang, $mvImageArchive;
		
		#make sure the first letter is upper case (makeTitle() should do that)		
		$result->title = strtoupper($result->title[0]) . substr($result->title, 1);		
		$img_url = $mvImageArchive . $result->title . '?size=icon&time=0:00:00';
		$img_url = MV_StreamImage::getStreamImageURL($result->stream_id, '0:00:00', 'icon', true);
		$img_html = '<img src="'.$img_url . '" width="80" height="60">';
		
				
		$title = Title::makeTitle( MV_NS_STREAM, $result->title  );
		$rlink = $skin->makeLinkObj( $title,  $img_html . ' '. $title->getText()  );		
		//if admin expose an edit link
		if( $wgUser->isAllowed('delete') ){
			$rlink.=' '.$skin->makeKnownLinkObj( Title::makeTitle(MV_NS_STREAM, $title->getText()),
						'edit', 'action=edit' );
		}
		return $rlink;
	}
}

?>
