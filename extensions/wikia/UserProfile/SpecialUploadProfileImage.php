<?php
/**
 * See skin.txt
 *
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die();
	
/**
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */  

 function get_dates_from_elapsed_days($number_of_days){
	$dates[date("F j, Y", time() )] = 1; //gets today's date string
	for($x=1;$x<=$number_of_days;$x++){
		$time_ago = time() - (60 * 60 * 24 * $x);
		$date_string = date("F j, Y", $time_ago);
		$dates[$date_string] = 1;
	}
	return $dates;
}  

class SkinSports extends Skin {
	
  #set stylesheet
  function getStylesheet() {
    return "common/Sports.css";
  }
  
  #set skinname
  function getSkinName() {
    return "Sports";
  }
  
	
  	/**
	 * Return html code that include User stylesheets
	 */
	function getUserStyles() {
		$s = "<style type='text/css'>\n";
		$s .= "/*/*/ /*<![CDATA[*/\n"; # <-- Hide the styles from Netscape 4 without hiding them from IE/Mac
		$s .= $this->getUserStylesheet();
		$s .= "/*]]>*/ /* */\n";
		$s .= "</style>\n";
		
		$s .= "<!--[if IE]><style type=\"text/css\" media=\"all\">@import \"skins/common/commonie.css\";</style><![endif]-->\n";
		return $s;
	}
	
  #main page before wiki content
  function doBeforeContent() {
	
  ##global variables
  global $wgOut, $wgTitle, $wgUser, $wgLang, $wgContLang, $wgEnableUploads, $wgRequest, $wgSiteView;	

  $li = $wgContLang->specialPage("Userlogin");
  $lo = $wgContLang->specialPage("Userlogout");  
  $tns=$wgTitle->getNamespace();
  
  $s = '';
  $s .= '<div id="container">';
    if (!($wgUser->isLoggedIn())) {  
    $s .= '<div id="topad">';
        $s .= '<script type="text/javascript"><!--' . "\n";
	$s .= 'google_ad_client = "pub-2291439177915740";' . "\n";
	$s .= 'google_ad_width = 728;' . "\n";
	$s .= 'google_ad_height = 90;' . "\n";
	$s .= 'google_ad_format = "728x90_as";' . "\n";
	$s .= 'google_ad_type = "image";' . "\n";
	$s .= '//2006-12-04: wiki' . "\n";
	$s .= 'google_ad_channel = "8721043353+0098152242+0152562336+4900065124";' . "\n";
	$s .= 'google_color_border = "ffffff";' . "\n";
	$s .= 'google_color_bg = "FFFFFF";' . "\n";
	$s .= 'google_color_link = "' . $wgSiteView->view_border_color_1 . '";' . "\n";
	$s .= 'google_color_text = "000000";' . "\n";
	$s .= 'google_color_url = "' . $wgSiteView->view_border_color_2 . '";' . "\n";
	$s .= '//--></script>' . "\n";
	$s .= '<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">' . "\n";
	$s .= '</script>' . "\n";
       $s .= '</div>';
    }
       $s .= '<div id="login">';
	  if ( $wgUser->isLoggedIn() ) {
	  $s .= $this->makeKnownLink( $lo, "Log-out", $q );
	  } else {
	  $s .= '<a href="javascript:Login()">Log-in</a>';
	  }
	$s .= '</div>'; #end login
	
	$s .= '<div id="top">';
          $s .= '<div id="logo">';
            $s .= '<a href="index.php?title=Main_Page"><img src="images/sports/logo.png" alt="logo" border="0"/></a>';
          $s .= '</div>';
          $s .= '<div id="toplinks">';
            $s .= '<a href="index.php?title=Main_Page">home</a> - <a href="index.php?title=Special:Recentchanges">recent changes</a> - <a href="index.php?title=Special:SiteScout">site scout</a> - ';
	    $s .= '<a href="index.php?title=Help">help</a>';
          $s .= '</div>';
          $s .= '<div id="search">';
            $s .= $this->searchForm();
          $s .= '</div>';
	  $s .= '<div class="cleared"></div>';
        $s .= '</div>'; #end top
    
	$s .= '<div id="navbar">';
          $s .= '<div id="leftNavLeft">';
            $s .= '<img src="images/sports/leftNavLeft.png" alt="logo" border="0"/>';
          $s .= '</div>';
          $s .= '<div id="leftNavMiddle">';
            $s .= '<ul>';
	      $s .= '<li><a href="index.php?title=MLB">MLB</a></li>';
	      $s .= '<li><a href="index.php?title=NFL">NFL</a></li>';
	      $s .= '<li><a href="index.php?title=NBA">NBA</a></li>';
	      $s .= '<li><a href="index.php?title=NHL">NHL</a></li>';
	      $s .= '<li><a href="index.php?title=CBB">College Basketball</a></li>';
	      $s .= '<li><a href="index.php?title=CFB">College Football</a></li>';
	      $s .= '<li><a href="index.php?title=Soccer">European Football</a></li>';
	      $s .= '<li><a href="index.php?title=Nascar">NASCAR</a></li>';
	      
	      $s .= '<li><a href="index.php?title=Other">Other</a></li>';
            $s .= '<ul>';
         $s .= '</div>';
         $s .= '<div id="leftNavRight">';
           $s .= '<img src="images/sports/leftNavRight.png" alt="logo" border="0"/>';
         $s .= '</div>';
         $s .= '<div id="rightNav">';
	    $s .= '<img src="images/common/pencilnav.gif" alt="logo" border="0"/> <a href="index.php?title=Create_Opinion">write an article</a>';
          $s .= '</div>';
	  $s .= '<div class="cleared"></div>';
        $s .= '</div>';  #end navbar
    
	if ($wgOut->getPageTitle() !== 'Main Page') {
	  $type = "sub";
	  $s .= '<div id="side">';
	  if ( $wgUser->isLoggedIn() ) {
  	  $s .= '<div id="topside"><div class="usertitle">'. $wgUser->mName .'</div></div>';
	  $s .= '<div id="userside">';
	      $avatar = new wAvatar($wgUser->mId,"l");
	      $s .= '<p class="userimage">';
              $s .= $this->makeKnownLinkObj( $wgUser->getUserPage(), '<img src=images/avatars/' . $avatar->getAvatarImage() . '/>');
	      $s .= '</p>';
	      $s .= '<p><img src="images/common/userpageIcon.png" alt="userpage icon" border="0"/> '.$this->makeKnownLinkObj( $wgUser->getUserPage(), "your userpage").'</p>';
	      $s .= '<p>';
	      $s .= '<img src="images/common/emailIcon.png" alt="email icon" border="0"/> ';
	      if ( $wgUser->getNewtalk() ) {
	        $s .= '<span class=\"profile-on\">' . $this->makeKnownLinkObj($wgUser->getTalkPage(), "new message!") . '</span>';
	      } else {
		$s .= $this->makeKnownLinkObj($wgUser->getTalkPage(), "no new messages");
	      }
	      $s .= '</p>';
	      
	      $s .= '<p>';
	      $s .= '<img src="images/common/challengeIcon.png" alt="challenge icon" border="0"/> ';
	      $dbr =& wfGetDB( DB_SLAVE );
	      $challenge = $dbr->selectRow( '`challenge`', array( 'challenge_id'),
	      array( 'challenge_user_id_2' => $wgUser->mId , 'challenge_status' => 0), "" );
	      if ( $challenge > 0 ) {
		      $s .= '<span class=\"profile-on\">' . "<a href=index.php?title=Special:ChallengeHistory&user=" . $title1->getDbKey() . "&status=0  style='color:#990000;font-weight:bold'>new challenge</a></span>";
	      }else{
		      $s .= '<a href="index.php?title=Special:ChallengeHistory">no new challenges</a>';
	      }
	      $s .= '</p>';
	      $s .= '<p><img src="images/common/watchlistIcon.png" alt="watchlist icon" border="0"/> '.$this->specialLink( "watchlist" ).'</p>';
		  
	      if (strpos($avatar->getAvatarImage(), 'default_') !== false) {
	        $s .= '<p class="avatarline"><a href=index.php?title=Profile_Image>(add your own image)</a></p>';
	      } else {
		$s .= '<p class="avatarline"><a href=index.php?title=Profile_Image>(update your image)</a></p>';      
	      }
	      $s .= '</div>';
	      $s .= '<div id="bottomside"></div>';
	  }
	  
	  if ( $wgOut->isArticle() ) {
	    $s .= '<div id="topside"><div class="sidetitle">this page</div></div>';
	    $s .= '<div id="middleside">';
	      $s .= '<p><img src="images/common/pagehistoryIcon.png" alt="page history icon" border="0"/> ' . $this->historyLink() . '</p>';
	      if ( $wgTitle->userCanMove() ) {
	        $s .= '<p><img src="images/common/moveIcon.png" alt="move icon" border="0"/> ' . $this->moveThisPage() . '</p>';
	      }
	      $s .= '<p><img src="images/common/whatlinkshereIcon.png" alt="what links here icon" border="0"/> ' . $this->whatLinksHere() . '</p>';
              if ( $wgUser->isAllowed('protect') && NS_SPECIAL !== $wgTitle->getNamespace() && $wgTitle->exists() ) {
                $s .= '<p><img src="images/common/protectIcon.png" alt="protect icon" border="0"/> ' . $this->protectThisPage() . '</p>';
              }
	      if ( $wgUser->isAllowed('delete') && NS_SPECIAL !== $wgTitle->getNamespace() && $wgTitle->exists()) {
		$s .= '<p><img src="images/common/deleteIcon.png" alt="delete icon" border="0"/> ' . $this->deleteThisPage() . '</p>';
	      }
	      if ( $wgUser->isLoggedIn() ) {
	        $s .= '<p><img src="images/common/addtowatchlistIcon.png" alt="watchlist" border="0"/> ' . $this->watchThisPage() . '</p>';
	      }
	    $s .= '</div>';
	    $s .= '<div id="bottomside"></div>';
	  }
	  
	  if ( $wgUser->isLoggedIn() ) {
	    $s .= '<div id="topside"><div class="sidetitle">wikia spotlight</div></div>';
	    $s .= '<div id="middleside">';
	    $s .= '<ul>';
	    $s .= '<li><a href="http://www.tunes.wikia.com"><span style="color:#6699FF;">tunes.</span><span style="color:#595959;font-weight:bold;">wikia</span></a></li>';
	    $s .= '<li><a href="http://www.cars.wikia.com"><span style="color:#60C40F;">cars.</span><span style="color:#0B254C;">wikia</span></a></li>';
	    $s .= '<li><a href="http://www.politics.wikia.com"><span style="color:#FF0000;">politics.</span><span style="color:#436882;">wikia</span></a></li>';
	    $s .= '</ul>';
	    $s .= '</div>';
	    $s .= '<div id="bottomside"></div>';
	  }
	  
	    $s .= '<div id="topside"><div class="sidetitle">share this</div></div>';
	    $s .= '<div id="middleside">';
	      $s .= "<p><script>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><style> html .fb_share_link { padding:2px 0 0 20px; height:16px; background:url(http://static.ak.facebook.com/images/share/facebook_share_icon.gif?6:26981) no-repeat top left; }</style><a href=\"http://www.facebook.com/share.php?u=<url>\" onclick=\"return fbs_click()\" target=\"_blank\" class=\"fb_share_link\">facebook</a></p>";
	      $s .= '<p><a href="http://digg.com/submit?phase=2&url='.$wgTitle->getFullURL().'&title='.$wgTitle->getText().'"><img src="images/common/diggIcon.png" alt="digg icon" border="0"/> digg</a></p>';
	      $s .= '<p><a href="http://del.icio.us/post"><img src="images/common/deliciousIcon.png" alt="delicious icon" border="0"/> delicious</a></p>';
	      $s .= '<p><a href="http://reddit.com/submit?url='.$wgTitle->getFullURL().'&title='.$wgTitle->getText().'""><img src="images/common/redditIcon.png" alt="reddit icon" border="0"/> reddit</a></p>';
	    $s .= '</div>';
	    $s .= '<div id="bottomside"></div>';
	  
	  
	  if (!($wgUser->isLoggedIn())) {
	  $s .= '<div id="sideads">';
	    $s .= '<script type="text/javascript"><!--' . "\n";
	    $s .= 'google_ad_client = "pub-2291439177915740";' . "\n";
	    $s .= 'google_ad_width = 120;' . "\n";
            $s .= 'google_ad_height = 600;' . "\n";
	    $s .= 'google_ad_format = "120x600_as";' . "\n";
	    $s .= 'google_ad_type = "text";' . "\n";
	    $s .= '//2006-12-04: wiki' . "\n";
	    $s .= 'google_ad_channel = "8721043353+0098152242+0152562336+4900065124";' . "\n";
	    $s .= 'google_color_border = "ffffff";' . "\n";
	    $s .= 'google_color_bg = "FFFFFF";' . "\n";
	    $s .= 'google_color_link = "' . $wgSiteView->view_border_color_1 . '";' . "\n";
	    $s .= 'google_color_text = "000000";' . "\n";
	    $s .= 'google_color_url = "' . $wgSiteView->view_border_color_2 . '";' . "\n";
	    $s .= '//--></script>' . "\n";
	    $s .= '<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">' . "\n";
	    $s .= '</script>' . "\n";
	  $s .= '</div>';
	  }
	  
	$s .= '</div>'; #end side
	} else {
	  $type = "main";
	}
	
      $s .= '<div id="main">';
     
      if ($tns == NS_USER || $tns == NS_USER_TALK) {
	    $id=User::idFromName($wgTitle->getText());
	    $s .= '<div id="top'. $type .'">';
	      $s .= '<div id="userpageAvatar">';
	        $avatar = new wAvatar($id,"l");
		$s .= "<img src='images/avatars/" . $avatar->getAvatarImage() . "'/>";
	      $s .= '</div>';
	      $s .= '<div id="userpageTop">';
	        $s .= $this->pageTitle();
		$s .= '<span class="edit"><a href="' . $wgTitle->getFullURL() . '&action=edit"><img src="images/common/editicon.png" alt="logo" border="0"/> edit</a></span>';
		$s .= '<div id="usertoplinks">';
	          if ( NS_SPECIAL !== $wgTitle->getNamespace() && (!($wgUser->getName()== $wgTitle->getText()))) {
                    $s .= '<span class="profile-on">' . $this->talkLink() . '</span> - ';
                  }
	          if ($id != 0) {
		    $s .=  $this->userContribsLink();
	          }
	          if( $this->showEmailUser( $id ) && (!($wgUser->getName()== $wgTitle->getText()))) {
		    $s .= ' - ' . $this->emailUserLink();      
	          }
	        $s .= '</div>';
	      $s .= '</div>';
	      $s .= '<div class="cleared"></div>';
	   $s .= '</div>';
	   $s .= '<div class="cleared"></div>';
	
	   
	     
     } else {
       $s .= '<div id="top'. $type .'">';
         if ($wgOut->getPageTitle() !== 'Main Page') {
	   $s .= $this->pageTitle();
	   $s .= '<p class="subtitle">'.$wgOut->getSubtitle().$this->subPageSubtitle().'</p>';
	 }
	 if (($wgOut->isArticle()) && ($wgOut->getPageTitle() !== 'Main Page')) {
	   $s .= '<span class="edit"><a href="' . $wgTitle->getFullURL() . '&action=edit"><img src="images/common/editicon.png" alt="logo" border="0"/> edit</a></span>';
	 }
	 $s .= '</div>';      
     }
     
     $s .= '<div id="middle'. $type .'">';
     
  return $s;
  
}
 
 function doAfterContent() {
 
  global $wgOut, $wgUser;
  
  if ($wgOut->getPageTitle() !== 'Main Page') {
	  $type = "sub";
	} else {
	  $type = "main";
	}
     $cat = $this->getCategoryLinks();
     if( $cat ) $s .= "<div id=\"categories\">$cat</div>";
     $s .= '</div>'; #end middle
     $s .= '<div id="bottom'. $type .'"></div>';
     $s .= '<div id="footer'. $type .'">';
       $s .= '<p>';
         $s .= '<a href="index.php?title=Main_Page">home</a>';
         $s .= '<a href="index.php?title=About">about</a>';
         $s .= '<a href="index.php?title=Special:Specialpages">special pages</a>';
	 $s .= '<a href="index.php?title=Help">help</a>';
         $s .= '<a href="http://www.wikia.com/wiki/Terms_of_use">terms of use</a>';
         $s .= '<a href="http://www.federatedmedia.net/authors/wikia">advertise</a>';
       $s .= '</p>';
       $s .= '<p>';
         $s .= 'Wikia is a service mark of Wikia, Inc. All rights reserved.';
       $s .= '</p>';
       $s .= '<p>';
         $s .= '<a href="http://www.gnu.org/copyleft/fdl.html"><img src="images/common/gnu-fdl.png" alt="GNU-FDL" border="0"/></a>';
         $s .= '<a href="http://www.mediawiki.org"><img src="images/common/poweredby_mediawiki_88x31.png" alt="powered by mediawiki" border="0"/></a>';
       $s .= '</p>';
     $s .= '</div>';
     
     if ( $wgOut->isArticle() ) {
       $s .= '<div id="top'. $type .'"></div>';
       $s .= '<div id="rssfooter'. $type .'">';
       $s .= rsspagefooter();
       $s .= '</div>';
       $s .= '<div id="bottom'. $type .'"></div>';
     }
     
   $s .= '</div>'; #end main
   
  $s .=  '</div>'; #end container
   
  return $s;

 }
 
 function getMainPage(){
   
  global $wgUser, $IP;
	 
  require_once ("$IP/extensions/ListPagesClass.php");
  $output = "";
  $dates_array = get_dates_from_elapsed_days(2);
  $date_categories = "";
  foreach ($dates_array as $key => $value) {
	if($date_categories)$date_categories .=",";
	$date_categories .= str_replace(",","\,",$key);
  }
  
  if (!($wgUser->isLoggedIn())) {
  $output .= '<div class="welcomeMessage">';
  $output .= '<h1>what\'s Wikia?</h1>';
  $output .= '<p><b>Wikia</b> is a user powered community.  Our community talks about every topic imaginable, writes about every topic imaginable, and contributes to the growing Wikia library.</p>';
  $output .= '<input type="button" value="join" onclick="Register();"/> ';
  $output .= '<input type="button" value="log-in" onclick="Login();"/> ';
  $output .= '</div>';
  } else {
  $output .= '<div class="profilebox">';
  $output .= '<h1> '. wgGetWelcomeMessage() .'</h1>';
  $avatar = new wAvatar($wgUser->mId,"l");
  $output .= '<div id="profileboximage">';
  if (strpos($avatar->getAvatarImage(), 'default_') !== false) {
    $output .= '<p>' . $this->makeKnownLinkObj( $wgUser->getUserPage(), '<img src=images/avatars/' . $avatar->getAvatarImage() . ' width="50" height="50"/>').'</p>';
  } else {
    $output .= '<p>' . $this->makeKnownLinkObj( $wgUser->getUserPage(), '<img src=images/avatars/' . $avatar->getAvatarImage() . '/>') . '</p>';
  }
  $output .= '</div>';
  $output .= '<div id="profileboxlinks">';
  $output .= '<p><img src="images/common/userpageIcon.png" alt="userpage icon" border="0"/> '.$this->makeKnownLinkObj( $wgUser->getUserPage(), "your userpage").'</p>';
  $output .= '<p><img src="images/common/emailIcon.png" alt="email icon" border="0"/> ';
    if ( $wgUser->getNewtalk() ) {
      $output .= "<span class=\"profile-on\">" . $this->makeKnownLinkObj($wgUser->getTalkPage(), "new message!") . "</span>";
    } else {
      $output .= $this->makeKnownLinkObj($wgUser->getTalkPage(), "no new messages");
    }
  $output .= '</p>';
  $output .= '<p>';
  $output .= '<img src="images/common/challengeIcon.png" alt="challenge icon" border="0"/> ';
    $dbr =& wfGetDB( DB_SLAVE );
    $challenge = $dbr->selectRow( '`challenge`', array( 'challenge_id'),
    array( 'challenge_user_id_2' => $wgUser->mId , 'challenge_status' => 0), "" );
    if ( $challenge > 0 ) {
      $output .= '<span class=\"profile-on\">' . "<a href=index.php?title=Special:ChallengeHistory&user=" . $title1->getDbKey() . "&status=0  style='color:#990000;font-weight:bold'>new challenge</a></span>";
    }else{
      $output .= '<a href="index.php?title=Special:ChallengeHistory">no new challenges</a>';
    }
  $output .= '</p>';
  if (strpos($avatar->getAvatarImage(), 'default_') !== false) {
    $output .= '<p><a href=index.php?title=Profile_Image>add a profile image</a></p>';
  }
  $output .= '</div>';
  $output .= '<div class="cleared"></div>';
  $output .= '</div>';
  }
  
  $output .= '<div id="buttons">';
  $output .= '<p><a href="index.php?title=Create_Opinion"><img src="images/sports/createicon.png" alt="icon" border="0"/> write an article</a></p>';
  $output .= '<p><a href="index.php?title=Sports_Encyclopedia"><img src="images/sports/encyclopediaicon.png" alt="icon" border="0"/> add to our sports encyclopedia</a></p>';
  $output .= '<p><a href="index.php?title=Special:ChallengeHistory"><img src="images/sports/competeicon.png" alt="icon" border="0"/> compete against others</a></p>';
  $output .= '</div>';
  
  $list = new ListPages();
  $list->setCategory("News, Opinions,Questions");
  $list->setShowCount(10);
  $list->setOrder("New");
  $list->setShowPublished("NO");
  $list->setBool("ShowVoteBox","yes");
  $list->setBool("ShowDate","NO");
  $list->setBool("ShowStats","NO");
  
  $output .= '<div class="smallList">';
  $output .= '<h1>just created</h1>';
  $output .= $list->DisplayList();
  $output .= '</div>';
  
  $list = new ListPages();
  $list->setCategory($date_categories);
  $list->setShowCount(5);
  $list->setOrder("Comments");
  $list->setShowPublished("Yes");
  $list->setBool("ShowNav","No");
  $list->setBool("ShowCommentBox","yes");
  $list->setBool("ShowDate","NO");
  $list->setBool("ShowStats","NO");
  $list->setLevel(1);

  #top recent comments
  $output .= '<div class="smallList">';
  $output .= '<h1>what people are talking about</h1>';
  $output .= $list->DisplayList();
  $output .= '</div>';

  $sql = "SELECT Comment_Username,comment_ip, comment_text,comment_date,Comment_user_id,
				CommentID,IFNULL(Comment_Plus_Count - Comment_Minus_Count,0) as Comment_Score,
				Comment_Plus_Count as CommentVotePlus, 
				Comment_Minus_Count as CommentVoteMinus,
				Comment_Parent_ID, page_title, page_namespace
				FROM Comments c, page p where c.comment_page_id=page_id 
				AND UNIX_TIMESTAMP(comment_date) > " . ( time() - (60 * 60 * 24 ) ) . "
				ORDER BY (Comment_Plus_Count - Comment_Minus_Count) DESC LIMIT 0,5";

  $comments = "";
  $dbr =& wfGetDB( DB_MASTER );
  $res = $dbr->query($sql);
  while ($row = $dbr->fetchObject( $res ) ) {
	$title2 = Title::makeTitle( $row->page_namespace, $row->page_title);

	if($row->Comment_user_id!=0){
		$title = Title::makeTitle( 2, $row->Comment_Username);
		$CommentPoster_Display = $row->Comment_Username;
		$CommentPoster = '<a href="' . $title->getFullURL() . '" title="' . $title->getText() . '">' . $row->Comment_Username . '</a>';
		$avatar = new wAvatar($row->Comment_user_id,"s");
		$CommentIcon = $avatar->getAvatarImage();
	}else{
		$CommentPoster_Display = "Anonymous Fanatic";
		$CommentPoster = "Anonymous Fanatic";
		$CommentIcon = "af_s.gif";
	}
	$comment_text = substr($row->comment_text,0,55 - strlen($CommentPoster_Display) );
	if($comment_text != $row->comment_text){
		$comment_text .= "...";
	}
	$comments .= "<div class=\"cod\">";
	$comments .=  "<span class=\"cod-score\">+" . $row->Comment_Score . '</span> <img src="images/avatars/' . $CommentIcon . '" alt="" align="middle" style="margin-bottom:8px;" border="0"/> <span class="cod-poster">' . $CommentPoster . "</span>";
	$comments .= "<span class=\"cod-comment\"><a href=\"" . $title2->getFullURL() . "#comment-" . $row->CommentID . "\" title=\"" . $title2->getText() . "\" >" . $comment_text . "</a></span>";
	$comments .= "</div>";
  }

  $output .= '<div class="smallList">';
  $output .= '<h1>comments of the day <span class="grey">(last 24 hours)</span></h1>';
  $output .= $comments;
  $output .= '</div>';
  
  $list = new ListPages();
  $list->setCategory("Lockerroom");
  $list->setShowCount(5);
  $list->setOrder("New");
  $list->setShowPublished("NO");
  $list->setBool("ShowVoteBox","No");
  $list->setBool("ShowDate","NO");
  $list->setBool("ShowStats","NO");
  
  $output .= '<div class="smallList">';
  $output .= '<h1>latest open discussions</h1>';
  $output .= $list->DisplayList();
  $output .= '</div>';
  
  
  return $output;

 }
 
   function searchForm( $label = "" ) {
    global $wgRequest;
  
    $search = $wgRequest->getText( 'search' );
    $action = $this->escapeSearchLink();
  
    $s = "<form id=\"search\" method=\"get\" class=\"inline\" action=\"$action\">";
  
    if ( "" != $label ) { $s .= "{$label}: "; }
    $s .= "<div id='searchbutton'>";
    $s .= "<input class='button' type='image' src='../images/common/search.gif' value=\"" . htmlspecialchars( wfMsg( "go" ) ) . "\" />";
    $s .= "</div>";
    $s .= "<div style='float:right;'>";
    $s .= "<input type='text' name=\"search\" size='18' value=\"" . htmlspecialchars(substr($search,0,256)) . "\" /> ";
    $s .= '</div>';
    $s .= "</form>";
  
    return $s;
  }
 
}

?>
