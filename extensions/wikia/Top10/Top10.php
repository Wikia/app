<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

	/* WIKIA */
	$wgSpecialPages['Top10'] = array('SpecialPage','Top10');
	/* WIKIA */
	
	/* MEDIA WIKI */
	#require_once($IP . '/includes/SpecialPage.php');
	#SpecialPage::AddPage(new SpecialPage('Top10'));
	/* MEDIA WIKI */

function wfSpecialTop10() {
	global $wgRequest, $wgUser, $wgOut, $wgTitle, $wgTopVoted;

	$wgOut->setPagetitle( wfMsg( "top10" ) );
	$pages = $wgTopVoted ? getLastVoted() : getTop10();
	$pages = count($pages) ? $pages : array(0);
	$pages = implode( ',', $pages);
	$dbr = & wfGetDB( DB_SLAVE);
	$query = "select page_id,page_title from page where page_id in ($pages)";
	$pages = '';
	$res = $dbr->query($query);
	while( $row = $dbr->fetchObject($res) )
	{
		$vres = $dbr->query("select coalesce(sum(vote),0) as votessum from votecounter where article_id=$row->page_id;");
		$vrow = $dbr->fetchObject($vres);
		$votessum = $vrow->votessum;
		$dbr->freeResult($vres);
		$title = Title::makeTitleSafe( NS_MAIN, $row->page_title );
		# Catch dud titles and return to the main page
		if( is_null( $title ) )
			$title = Title::newFromText( wfMsg( 'mainpage' ) );
		$pages .= '<a href="' . $title->getFullUrl( 'redirect=no' ) . '">' . $row->page_title . ' - ' . $votessum . ' vote(s)</a><br/>';
	}
	$dbr->freeResult($res);
	$wgOut->addHtml( $pages);
}

function getTop($query) {
	$dbr = & wfGetDB( DB_SLAVE);
	$query = $dbr->limitResult( $query, 10, 0 );
	$res = $dbr->query($query);
	$pages = array();
	while( $row = $dbr->fetchObject($res) )
	{
		$pages[] = $row->article_id;
	}
	$dbr->freeResult($res);
	return $pages;
}

function getTop10() {
	return getTop("select article_id from votecounter order by vote desc");
}

function getLastVoted() {
	return getTop("select article_id from votecounter order by time desc");
}

?>
