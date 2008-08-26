<?php
$wgHooks['ArticleSave'][] = 'incEditCount';

function incEditCount(&$article, &$user, &$text, &$summary, $minor, $watch, $sectionanchor, &$flags) {
	global $wgUser, $wgTitle, $wgNamespacesForEditPoints;

	//only keep tally for allowable namespaces
	if( !is_array($wgNamespacesForEditPoints) || in_array( $wgTitle->getNamespace(), $wgNamespacesForEditPoints ) ){
		$stats = new UserStatsTrack($wgUser->getID(), $wgUser->getName());
		$stats->incStatField("edit");
	}
	return true;
}

$wgHooks['ArticleDelete'][] = 'removeDeletedEdits';

function removeDeletedEdits(&$article, &$user, &$reason){
	global $wgUser, $wgTitle, $wgDBprefix, $wgNamespacesForEditPoints;

	//only keep tally for allowable namespaces
	if( !is_array($wgNamespacesForEditPoints) || in_array( $wgTitle->getNamespace(), $wgNamespacesForEditPoints ) ){

		$dbr = wfGetDB( DB_MASTER );
		$sql = "SELECT rev_user_text, rev_user,  count(*) AS the_count FROM ".$wgDBprefix."revision WHERE rev_page = {$article->getID()} AND rev_user <> 0  GROUP BY rev_user_text";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$stats = new UserStatsTrack( $row->rev_user , $row->rev_user_text );
			$stats->decStatField("edit", $row->the_count );
		}
	}
	return true;
}

$wgHooks['ArticleUndelete'][] = 'restoreDeletedEdits';

function restoreDeletedEdits(&$title, $new){
	global $wgUser, $wgDBprefix, $wgNamespacesForEditPoints;

	//only keep tally for allowable namespaces
	if( !is_array($wgNamespacesForEditPoints) || in_array( $title->getNamespace(), $wgNamespacesForEditPoints ) ){

		$dbr = wfGetDB( DB_MASTER );
		$sql = "SELECT rev_user_text, rev_user,  count(*) AS the_count FROM ".$wgDBprefix."revision WHERE rev_page = {$title->getArticleID()} AND rev_user <> 0  GROUP BY rev_user_text";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$stats = new UserStatsTrack( $row->rev_user, $row->rev_user_text );
			$stats->incStatField("edit", $row->the_count );
		}
	}
	return true;
}
