<?php
$wgExtensionFunctions[] = "wfViewMain";

function wfViewMain() {
    global $wgParser;
    $wgParser->setHook( "viewmain", "viewMain" );
}
 
function viewMain( $input ){
	global $wgSiteView;
	require_once ('ListPagesClass.php');
	
	$CategoriesStr = "";
	$aCat = explode(",",$wgSiteView->getCategories());
	foreach($aCat as $sCat){
		if($sCat!=""){
			if($CategoriesStr!=""){
				$CategoriesStr .= ",";
			}
			$CategoriesStr .= $sCat . " Opinions";
		}
	 }
		
	$list = new ListPagesView();
	$list->setCategory($CategoriesStr);
	$list->setShowCount(6);
	$list->setPageNo(1);
	$list->setOrder("PublishedDate");
	$list->setLevel(1);
	$list->setBool("showVoteBoxInTitle","Yes");
	$list->setShowPublished(1);
	$list->setBool("ShowCtg",1);
	$list->setBool("ShowPic",1);
	$list->setShowBlurb(300);
	$list->setBlurbFontSize("small");
	$list->setBool("isViewMain",1);
	$list->setHash($wgSiteView->getCategories() . "main");
	$list->setBool("useCache",1);
	$out = $list->DisplayList();
	return "<div class=\"mainListPages\">" . $out . "</div>";
}
?>