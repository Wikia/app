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
	global $wgUser, $wgTitle, $wgNamespacesForEditPoints;
	
	//only keep tally for allowable namespaces
	if( !is_array($wgNamespacesForEditPoints) || in_array( $wgTitle->getNamespace(), $wgNamespacesForEditPoints ) ){
	
		$dbr = wfGetDB( DB_MASTER );
		$sql = "select rev_user_text, rev_user,  count(*) as the_count from revision where rev_page = {$article->getID()} and rev_user <> 0  group by rev_user_text";
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
	global $wgUser, $wgNamespacesForEditPoints;
	
	//only keep tally for allowable namespaces
	if( !is_array($wgNamespacesForEditPoints) || in_array( $title->getNamespace(), $wgNamespacesForEditPoints ) ){
	
		$dbr = wfGetDB( DB_MASTER );
		$sql = "select rev_user_text, rev_user,  count(*) as the_count from revision where rev_page = {$title->getArticleID()} and rev_user <> 0  group by rev_user_text";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$stats = new UserStatsTrack( $row->rev_user , $row->rev_user_text );
			$stats->incStatField("edit", $row->the_count );
		}
	}
	return true;
}

?>