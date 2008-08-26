<?php
$wgExtensionFunctions[] = 'wfSpecialExternalListPages';


function wfSpecialExternalListPages(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class ExternalListPages extends SpecialPage {

  function ExternalListPages(){
    UnlistedSpecialPage::UnlistedSpecialPage("ExternalListPages");
  }

  function execute(){
	global $wgUser, $wgOut; 
	require_once ('ListPagesClass.php');

	$list = new ListPages();
	$list->setCategory(str_replace ("|", ",",$_GET["ctg"]));
	$list->setShowCount($_GET["shw"]);
	$list->setPageNo($_GET["pg"]);
	$list->setOrder($_GET["ord"]);
	$list->setLevel($_GET["lv"]);
	$list->setShowDetails($_GET["det"]);
	$list->setShowPublished($_GET["pub"]);
	$list->setBool("ShowNav",$_GET["nav"]);
	$list->setBool("ShowDate",$_GET["shwdt"]);
	$list->setBool("ShowStats",$_GET["shwst"]);
	$out = $list->DisplayList();
	
	$out =  str_replace ("'", "\'",$out);
	$out =  str_replace (chr(10), "');document.write('",$out);

	$wgOut->addHTML( "document.write ('" .   $out  . "')");
	$wgOut->setArticleBodyOnly(true);
  }

}

	SpecialPage::addPage( new ExternalListPages );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'externallistpages', 'just a test extension' );
}

?>