<?php
$wgExtensionFunctions[] = 'wfSpecialListPagesAction';

function wfSpecialListPagesAction(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");

	class ListPagesAction  extends SpecialPage {
	
	  function ListPagesAction(){
	    UnlistedSpecialPage::UnlistedSpecialPage("ListPagesAction");
	  }
	  
	    function execute(){
			global $wgSiteView, $wgOut, $wgVoteDirectory;

			require_once("$wgVoteDirectory/VoteClass.php");
			require_once("$wgVoteDirectory/Publish.php");
			require_once ('ListPagesClass.php');
		
			$list = new ListPages();
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
			echo $out;
			
			// This line removes the navigation and everything else from the
		 	// page, if you don't set it, you get what looks like a regular wiki
		 	// page, with the body you defined above.
		 	$wgOut->setArticleBodyOnly(true);
		}
	}
	
	SpecialPage::addPage( new ListPagesAction );
 	global $wgMessageCache,$wgOut;
 	$wgMessageCache->addMessage( 'listpagesaction', 'just a test extension' );
}
 
?>