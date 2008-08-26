<?php
/*
 * Ajax Functions used by Wikia extensions
 */
 
$wgAjaxExportList [] = 'wfGetListPages';
function wfGetListPages($page_id, $parent_id, $comment_text, $sid, $mk){
	global $wgSiteView, $wgOut, $wgVoteDirectory;
	
	require_once("$wgVoteDirectory/VoteClass.php");
	require_once("$wgVoteDirectory/Publish.php");
	require_once ('ListPagesClass.php');
	if($_POST["vm"]==0){
		$list = new ListPages();
	}else{
		$list = new ListPagesView();
	}
	$list->setCategory(str_replace ("|", ",",$_POST["ctg"]));
	$list->setShowCount($_POST["shw"]);
	$list->setPageNo($_POST["pg"]);
	$list->setOrder(urldecode($_POST["ord"]));
	$list->setSortBy($_POST["srt"]);
	$list->setLevel($_POST["lv"]);
	$list->setShowDetails($_POST["det"]);
	$list->setShowPublished($_POST["pub"]);
	$list->setBool("ShowCtg",$_POST["shwctg"]);
	$list->setBool("ShowPic",$_POST["shwpic"]);
	$list->setShowBlurb($_POST["shwb"]);
	$list->setBlurbFontSize($_POST["bfs"]);
	$list->setBool("ShowStats",$_POST["shwst"]);
	$list->setBool("ShowDate",$_POST["shwdt"]);
	$list->setBool("ShowRating",$_POST["shwrt"]);
	$list->setBool("ShowVoteBox",$_POST["shwvb"]);
	$list->setRatingMin($_POST["rtmin"]);
	//echo "date:" . $list->ShowDate;
	$out = $list->DisplayList();
	return $out;
}



?>