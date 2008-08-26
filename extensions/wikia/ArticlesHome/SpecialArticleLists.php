<?php

$wgExtensionFunctions[] = 'wfSpecialArticleLists';

function wfSpecialArticleLists(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class ArticleLists extends SpecialPage {

	
	function ArticleLists(){
		UnlistedSpecialPage::UnlistedSpecialPage("ArticleLists");
	}
	
	 
	
	function execute($featured){
		global $wgUser, $wgRequest, $IP, $wgOut;
		require_once ("$IP/extensions/wikia/ListPages/ListPagesClass.php");
		
		if(!$featured)$featured = "popular";
		
		$sk =& $wgUser->getSkin();
		
		$dates_array = get_dates_from_elapsed_days(2);
		$date_categories = "";
		foreach ($dates_array as $key => $value) {
			if($date_categories)$date_categories .=",";
			$date_categories .= str_replace(",","\,",$key);
		}
		
		$wgOut->setHTMLTitle( wfMsg( 'pagetitle', "New Articles" ) );
	
	
			$output .= '<div class="left-articles">';
				$output .= '<h2>New Articles</h2>';
				
				$list = new ListPages();
				$list->setCategory("News, Opinions, Questions, Articles");
				$list->setShowCount(25);
				$list->setOrder("New");
				$list->setShowPublished("No");
				$list->setShowBlurb("300");
				$list->setBool("ShowVoteBox","NO");
				$list->setBool("ShowDate","NO");
				$list->setBool("ShowStats","YES");
				$list->setBool("ShowCtg","NO");
				$list->setBool("ShowNav","YES");
				$list->setBool("ShowPicture","YES");
			
			$output .= $list->DisplayList();
				
			$output .= "</div>";
		
		
		
		$wgOut->addHTML($output);
	
	}
  
 
	
}

SpecialPage::addPage( new ArticleLists );

 


}

?>