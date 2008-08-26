<?php
$wgHooks['ArticleSaveComplete'][] = 'updateCreatedOpinionsCount';
$wgHooks['ArticleSave'][] = 'updateCreatedOpinionsCount';

function updateCreatedOpinionsCount() {
	global $wgOut, $wgTitle, $wgBlogCategory;
	$dbr =& wfGetDB( DB_SLAVE );
	$sql = "SELECT cl_to FROM " . $dbr->tableName( 'categorylinks' ) . "  WHERE cl_from=" . $wgTitle->mArticleID;
	
	$res = $dbr->query($sql);
	while ($row = $dbr->fetchObject( $res ) ) {
		$ctg = Title::makeTitle( NS_CATEGORY, $row->cl_to);
		$ctgname = $ctg->getText();
		if( strpos(  ($ctgname),"{$wgBlogCategory} by User" ) !== false ) {
			$user_name = trim(str_replace("{$wgBlogCategory} by User","",$ctgname));
			$u = User::idFromName($user_name);
			if($u){
				$stats = new UserStatsTrack($u, $user_name);
				$stats->updateCreatedOpinionsCount();
			}
		}
	}
	return true;
}

?>