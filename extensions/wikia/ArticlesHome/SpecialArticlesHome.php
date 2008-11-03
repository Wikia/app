<?php

$wgExtensionFunctions[] = 'wfSpecialArticlesHome';
$wgExtensionFunctions[] = 'wfArticlesHomeReadLang';

function wfSpecialArticlesHome(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class ArticlesHome extends SpecialPage {

	
	function ArticlesHome(){
		UnlistedSpecialPage::UnlistedSpecialPage("ArticlesHome");
	}
	
	 
	
	function execute($type){
		global $wgUser, $wgRequest, $IP, $wgOut, $wgStyleVersion, $wgSupressPageTitle, $wgBlogCategory;
		
		$wgSupressPageTitle = true;
		
		require_once ("$IP/extensions/wikia/ListPages/ListPagesClass.php");

		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/ArticlesHome/ArticlesHome.css?{$wgStyleVersion}\"/>\n");
		
		
		if(!$type)$type = "popular";
		
		$sk =& $wgUser->getSkin();
		
		$dates_array = get_dates_from_elapsed_days(2);
		$date_categories = "";
		foreach ($dates_array as $key => $value) {
			if($date_categories)$date_categories .=",";
			$date_categories .= str_replace(",","\,",$key);
		}
		if ($type=="popular") {
			$name = wfMsgForContent( 'ah_popular_articles' );
			$name_right = wfMsgForContent( 'ah_new_articles' );
		} else {
			$name = wfMsgForContent( 'ah_new_articles' );
			$name_right = wfMsgForContent( 'ah_popular_articles' );
		}
		
		$wgOut->setHTMLTitle( wfMsg( 'pagetitle', $name ) );
	
		$output .= "<div class=\"main-page-left\">";
			$output .= '<div class="logged-in-articles">';
				//$output .= '<h2>' . $name . ' <span class="rss-feed"><a href="http://feeds.feedburner.com/Armchairgm"><img src=http://www.armchairgm.com/images/a/a7/Rss-icon.gif border="0"></a> ' . wfMsgForContent( 'ah_rss_feed' ) . '</span></h2>';
				$output .= "<p class=\"main-page-sub-links\"><a href=\"" . Title::MakeTitle(NS_MAIN, "Create_Opinion")->escapeFullUrl() ."\">" . wfMsgForContent( 'ah_write_article' ) . "</a> - <a href=\"" . Title::MakeTitle(NS_CATEGORY, date("F j, Y"))->escapeFullUrl() ."\">" . wfMsgForContent( 'ah_todays_articles' ) . "</a> - <a href=\"" . Title::MakeTitle(NS_MAIN, "Main_Page")->escapeFullUrl() ."\">" . wfMsgForContent( 'ah_main_page' ) . "</a></p>";
				
		if ($type=="popular") {
			$list = new ListPages();
			$list->setCategory("{$wgBlogCategory}");
			$list->setShowCount(25);
			$list->setOrder("PublishedDate");
			$list->setShowPublished("YES");
			$list->setShowBlurb("300");
			$list->setBlurbFontSize("small");
			$list->setBool("ShowVoteBox","NO");
			$list->setBool("ShowDate","YES");
			$list->setBool("ShowStats","YES");
			$list->setBool("ShowCtg","NO");
			$list->setBool("ShowNav","YES");
			$list->setBool("ShowPicture","YES");
			
			$output .= $list->DisplayList();
			
		} else {
			$list = new ListPages();
			$list->setCategory("{$wgBlogCategory}");
			$list->setShowCount(25);
			$list->setOrder("New");
			$list->setShowPublished("No");
			$list->setShowBlurb("300");
			$list->setBlurbFontSize("small");
			$list->setBool("ShowVoteBox","NO");
			$list->setBool("ShowDate","YES");
			$list->setBool("ShowStats","YES");
			$list->setBool("ShowCtg","NO");
			$list->setBool("ShowNav","YES");
			$list->setBool("ShowPicture","YES");
			
			$output .= $list->DisplayList();
		}
				
			$output .= "</div>";
		$output .= "</div>";
		$output .= "<div class=\"main-page-right\">";
			//Main Page User Box
			/*
			$output .= '<div class="profile-box">';
				//$output .= '<h1> '. wgGetWelcomeMessage() .'</h1>';
				$output .=  $sk->getMainPageUserBox($avatar);
			$output .= '</div>';
			*/
			//Side Articles
			$output .= '<div class="side-articles">';
				$output .= '<h2>' . $name_right . '</h2>';
				
				if ($type=="popular") {
					$list = new ListPages();
					$list->setCategory("{$wgBlogCategory}");
					$list->setShowCount(10);
					$list->setOrder("New");
					$list->setShowPublished("NO");
					$list->setBool("ShowVoteBox","YES");
					$list->setBool("ShowDate","NO");
					$list->setBool("ShowStats","NO");
				} else {
					$list = new ListPages();
					$list->setCategory("{$wgBlogCategory}");
					$list->setShowCount(10);
					$list->setOrder("PublishedDate");
					$list->setShowPublished("YES");
					$list->setBool("ShowVoteBox","YES");
					$list->setBool("ShowDate","NO");
					$list->setBool("ShowStats","NO");
				}
				
				$output .= $list->DisplayList();
			$output .= '</div>';
			
			$list = new ListPages();
			wfDebug("date_categories=" . $date_categories . "\n");
			$list->setCategory($date_categories);
			$list->setShowCount(10);
			$list->setOrder("Votes");
			$list->setShowPublished("YES");
			$list->setBool("ShowNav","No");
			$list->setBool("ShowVoteBox","YES");
			$list->setBool("ShowDate","NO");
			$list->setBool("ShowStats","NO");
			$list->setLevel(1);

			//Most Votes
			$output .= '<div class="side-articles">';
				$output .= '<h2>' . wfMsgForContent( 'ah_most_votes' ) . '</h2>';
				$output .= $list->DisplayList();
			$output .= '</div>';

			$list = new ListPages();
			$list->setCategory($date_categories);
			$list->setShowCount(10);
			$list->setOrder("Comments");
			$list->setShowPublished("YES");
			$list->setBool("ShowNav","No");
			$list->setBool("ShowCommentBox","YES");
			$list->setBool("ShowDate","NO");
			$list->setBool("ShowStats","NO");
			$list->setLevel(1);

			//Most Comments
			$output .= '<div class="side-articles">';
				$output .= '<h2>' . wfMsgForContent( 'ah_what_talking_about' ) . '</h2>';
				$output .= $list->DisplayList();
			$output .= '</div>';
		
		$output .= "</div>";
		$output .= "<div class=\"cleared\"></div>";
		
		
		$wgOut->addHTML($output);
	
	}
  
 
	
}

SpecialPage::addPage( new ArticlesHome );

 


}

//read in localisation messages
function wfArticlesHomeReadLang(){
	global $wgMessageCache, $IP;
	require_once ( "ArticlesHome.i18n.php" );
	foreach( efWikiaArticlesHome() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}
?>