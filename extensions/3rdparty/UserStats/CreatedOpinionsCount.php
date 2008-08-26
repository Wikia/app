<?php
$wgHooks['ArticleSaveComplete'][] = 'updateCreatedOpinionsCount';
$wgHooks['ArticleSave'][] = 'updateCreatedOpinionsCount';

function updateCreatedOpinionsCount() {
	global $wgOut, $wgTitle;
	$dbr =& wfGetDB( DB_SLAVE );
	$sql = "SELECT cl_to FROM " . $dbr->tableName( 'categorylinks' ) . "  WHERE cl_from=" . $wgTitle->mArticleID;
	
	$res = $dbr->query($sql);
	while ($row = $dbr->fetchObject( $res ) ) {
		$ctg = Title::makeTitle( 14, $row->cl_to);
		$ctgname = $ctg->getText();
		if( strpos(  strtoupper($ctgname),'OPINIONS BY USER' ) !== false ) {
			$user_name = trim(str_replace("Opinions by User","",$ctgname));
			$u = User::idFromName($user_name);
			if($u){
				$stats = new UserStatsTrack(1,$u, $user_name);
				$stats->updateCreatedOpinionsCount();
			}
		}
	}
	return true;
}

?>