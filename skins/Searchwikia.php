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



class SkinSearchwikia extends Skin {
  
  #set stylesheet
  function getStylesheet() {
    return "common/Search_mw.css";
  }
  
  #set skinname
  function getSkinName() {
    return "Searchwikia";
  }
  
  
	function pageTitle() {
		global $wgOut, $wgSupressPageTitle;
		if( !$wgSupressPageTitle ){
			$s = '<h1 class="pagetitle">' . htmlspecialchars( $wgOut->getPageTitle() ) . '</h1>';
			return $s;
		}
	}
	
	
	function getHeadScripts() {
		global $wgStylePath, $wgUser, $wgAllowUserJs, $wgJsMimeType, $wgStyleVersion, $wgServer;

		$r = self::makeGlobalVariablesScript( array( 'skinname' => $this->getSkinName() ) );

		$r .= "<script type=\"{$wgJsMimeType}\" src=\"{$wgStylePath}/common/wikibits.js?$wgStyleVersion\"></script>\n";
		//$r .= "<script type=\"{$wgJsMimeType}\" src=\"http://search1.wikia.nocookie.net/scripts/prototype.js\"></script>\n";
		$r .= "<script src=\"http://re.search.wikia.com/js/prototype.js\" type=\"text/javascript\"></script>";
		$r .= "<script src=\"http://re.search.wikia.com/js/scriptaculous.js\" type=\"text/javascript\"></script>";
		$r .= "<script src=\"http://re.search.wikia.com/js/util.js\" type=\"text/javascript\"></script>";
		$r .= "<script type=\"text/javascript\" src=\"http://re.search.wikia.com/JSON/servertouse.js\"></script>";
		$r .= "<script type=\"text/javascript\" src=\"http://re.search.wikia.com/JSON/serverCall.js\"></script>";
		$r .= "<script type=\"text/javascript\" src=\"http://re.search.wikia.com/JSON/login.js\"></script>";
		$r .= "<!--[if lt IE 7.]>";
		$r .= "<script defer type=\"text/javascript\" src=\"http://re.search.wikia.com/js/pngfix.js\"></script>";
		$r .= "<![endif]-->";
		
		
		$r .= "<link rel=\"stylesheet\" href=\"http://re.search.wikia.com/kt_files/structure.css\">";
		$r .= "<link rel=\"stylesheet\" href=\"http://re.search.wikia.com/kt_files/style.css\">";
		
		//$r .= "<link rel='stylesheet' type='text/css' href=\"http://search1.wikia.nocookie.net/styles/search.css\"/>\n";
		
		global $wgUseSiteJs;
		if ($wgUseSiteJs) {
			if ($wgUser->isLoggedIn()) {
				$r .= "<script type=\"$wgJsMimeType\" src=\"".htmlspecialchars(self::makeUrl('-','action=raw&smaxage=0&gen=js'))."\"><!-- site js --></script>\n";
			} else {
				$r .= "<script type=\"$wgJsMimeType\" src=\"".htmlspecialchars(self::makeUrl('-','action=raw&gen=js'))."\"><!-- site js --></script>\n";
			}
		}
		if( $wgAllowUserJs && $wgUser->isLoggedIn() ) {
			$userpage = $wgUser->getUserPage();
			$userjs = htmlspecialchars( self::makeUrl(
				$userpage->getPrefixedText().'/'.$this->getSkinName().'.js',
				'action=raw&ctype='.$wgJsMimeType));
			$r .= '<script type="'.$wgJsMimeType.'" src="'.$userjs."\"></script>\n";
		}
		return $r;
	}
	function pageSubtitle() {
		return "";
	}
  /**
  * This gets called shortly before the \</body\> tag.
  * @return String HTML-wrapped JS code to be put before \</body\> 
  */
  


function footer() {
	
	global $IP, $wgUser, $wgTitle, $wgOut,$wgUploadPath, $wgMemc;
	
	$footer = "";
	$footer .= "<div id=\"footer-container\">
		<div id=\"footer-logo\"></div>
		<div id=\"footer-links\">
			<a href=\"http://www.wikia.com/wiki/About_Wikia\">About Us</a>
			<a href=\"http://www.wikia.com/wiki/Contact_us\">Contact Us</a>
			<a href=\"http://www.wikia.com/wiki/Terms_of_use\">Terms of Use</a>
			<a href=\"http://www.mediawiki.org/\">MediaWiki</a>
			<a href=\"http://www.wikia.com/wiki/Advertising\">Advertise on Wikia</a>
			<a href=\"http://www.wikia.com/wiki/Terms_of_use#Collection_of_personal_information\">Privacy policy</a>
		</div>
		<div id=\"footer-legal\">
			Wikia® is a registered service mark of Wikia, Inc.  All rights reserved.
		</div>
		<div class=\"cleared\"></div>
	</div>";
	
	return $footer;
}

function header() {
	
	global $wgOut, $wgUser, $wgUser, $wgTitle, $wgRequest;
	
	/*
	$url = "http://alpha.search.wikia.com";
	
	<script>
		function search(){
			window.location='http://re.search.wikia.com/search.html#'+\$('q2').value;
			return false;
		}
	</script>
	*/
	
	$header="
	<div id=\"header\">
		<script type=\"text/javascript\" src=\"http://re.search.wikia.com/header.js\"></script>";
	  
		/*
	
		<div id=\"header-container\">
	    <div id=\"header-logo\">
	      <a href=\"\"><img border=\"0\" alt=\"Search Wikia\" src=\"{$url}/images/wikia/logo_sub.gif\"/></a>
	    </div>
	    <div id=\"header-search-bar\"> 
	      <form onsubmit=\"return search();\">
	      <input type=\"text\" value=\"\" id=\"q2\" class=\"header-search-input\" name=\"q2\"/>
	      <div id=\"header-go-button\">
	      <input type=\"image\" src=\"{$url}/images/wikia/go_button_top.gif\" onclick=\"search();\" />
	      </div>
	      </form>
	    </div>
	    <div id=\"header-li-buttons\">";

	    	$newtalks = $wgUser->getNewMessageLinks();

		if( count( $newtalks ) == 1 && !empty( $wgCityId ) && !empty( $newtalks[$wgCityId] ) ) {
			$usertitle = $wgUser->getUserPage();
			$usertalktitle = $usertitle->getTalkPage();
			if( !$usertalktitle->equals( $wgTitle ) ) {
				$ntl = wfMsg( 'youhavenewmessages',
					$this->makeKnownLinkObj(
						$usertalktitle,
						wfMsgHtml( 'newmessageslink' ),
						'redirect=no'
					),
					$this->makeKnownLinkObj(
						$usertalktitle,
						wfMsgHtml( 'newmessagesdifflink' ),
						'diff=cur'
					)
				);
				# Disable Cache
				$wgOut->setSquidMaxage(0);
				$wgOut->enableClientCache(false);
			}
		} else if (count($newtalks)) {
			$sep = str_replace("_", " ", wfMsgHtml("newtalkseperator"));
			$msgs = array();
			foreach ($newtalks as $newtalk) {
				$msgs[] = wfElement("a",
					array('href' => $newtalk["link"]), $newtalk["wiki"]);
			}
			$parts = implode($sep, $msgs);
			$ntl = wfMsgHtml('youhavenewmessagesmulti', $parts);
			# Disable Cache
			$wgOut->setSquidMaxage(0);
			$wgOut->enableClientCache(false);
		} else {
			$ntl = '';
		}

	       	if ($wgUser->isLoggedIn()) {
			if ($ntl) $ntl = ". <span class=\"new-message-link\">{$ntl}</span>";
			$header .= "<div id=\"li-welcome\">Hello {$wgUser->getName()}{$ntl}</div>
		        <div id=\"li-logout\"><a href=\"{$url}/login/logout.html\">Logout?</a></div>";
			} else {
				if( $ntl ) $ntl = "<span class=\"new-message-link\">$ntl</span>";
				$header .= "{$ntl} <div id=\"lo-register\" class=\"positive-button\"><span><a href=\"{$url}/account/addaccount.html\">Sign Up</a></span></div>
		        <div id=\"lo-login\" class=\"positive-button\"><span><a href=\"{$url}/login/login.html\">Login</a></span></div>";
			}

		//tab info 
		
		if ($wgTitle->getText()=="Preferences") {
			$profile_tab = "tab-off";
			$preferences_tab = "profile-tab-on";
		} else {
			$profile_tab = "tab-on";
			$preferences_tab = "tab-off";
		}
		$bug_tab = "tab-off";
		if( $wgTitle->getText() == "Prealpha bug reports" && $wgRequest->getVal("section") == "new" && $wgRequest->getVal("action") == "edit"){
			$profile_tab = "tab-off";
			$bug_tab = "profile-tab-on";
		}
	    $bug_title = Title::makeTitle(NS_MAIN,"Prealpha bug reports");
	    $header .= "</div>
	    <div id=\"tabs\">

	        <div class=\"{$profile_tab}\"><a href=\"{$url}/profile/profile.html\">Profile</a></div>
	        <div class=\"tab-off\"><a href=\"{$url}/photo/viewalbums.html\">Photos</a></div>
	        <div class=\"tab-off\"><a href=\"{$url}/friend/viewfriends.html\">Friends</a></div>
	        <div class=\"{$preferences_tab}\"><a href=\"{$url}/account/preferences.html\">Preferences</a></div>
	        <div class=\"tab-off\"><a class=\"last\" href=\"{$url}/privacy/settings.html\">Privacy</a></div>
	    </div>
	  </div>
	  */
	$header .= "</div>";
	
	return $header;
	
}

function buildLanguageUrls(){
	global $wgOut, $wgContLang, $wgHideInterlanguageLinks;
	
	# Language links
	$language_urls = array();

	if ( !$wgHideInterlanguageLinks ) {
		foreach( $wgOut->getLanguageLinks() as $l ) {
			$tmp = explode( ':', $l, 2 );
			$class = 'interwiki-' . $tmp[0];
			unset($tmp);
			$nt = Title::newFromText( $l );
			$language_urls[] = array(
				'href' => $nt->getFullURL(),
				'text' => ($wgContLang->getLanguageName( $nt->getInterwiki()) != ''?$wgContLang->getLanguageName( $nt->getInterwiki()) : $l),
				'class' => $class
			);
		}
	}
	return $language_urls;
}

function buildNavUrls() {
	global $wgUseTrackbacks, $wgTitle, $wgArticle;

	$fname = 'SkinTemplate::buildNavUrls';
	wfProfileIn( $fname );

	global $wgUser, $wgRequest;
	global $wgEnableUploads, $wgUploadNavigationUrl;

	$action = $wgRequest->getText( 'action' );
	$oldid = $wgRequest->getVal( 'oldid' );

	$nav_urls = array();
	$nav_urls['mainpage'] = array( 'href' => self::makeMainPageUrl() );
	if( $wgEnableUploads ) {
		if ($wgUploadNavigationUrl) {
			$nav_urls['upload'] = array( 'href' => $wgUploadNavigationUrl );
		} else {
			$nav_urls['upload'] = array( 'href' => self::makeSpecialUrl( 'Upload' ) );
		}
	} else {
		if ($wgUploadNavigationUrl)
			$nav_urls['upload'] = array( 'href' => $wgUploadNavigationUrl );
		else
			$nav_urls['upload'] = false;
	}
	$nav_urls['specialpages'] = array( 'href' => self::makeSpecialUrl( 'Specialpages' ) );

	// default permalink to being off, will override it as required below.
	$nav_urls['permalink'] = false;

	// A print stylesheet is attached to all pages, but nobody ever
	// figures that out. :)  Add a link...
	if( $wgTitle->getNamespace() != NS_SPECIAL && ($action == '' || $action == 'view' || $action == 'purge' ) ) {
		$nav_urls['print'] = array(
			'text' => wfMsg( 'printableversion' ),
			'href' => $wgRequest->appendQuery( 'printable=yes' )
		);

		// Also add a "permalink" while we're at it
		if ( (int)$oldid ) {
			$nav_urls['permalink'] = array(
				'text' => wfMsg( 'permalink' ),
				'href' => ''
			);
		} else {
			$revid = $wgArticle ? $wgArticle->getLatest() : 0;
			if ( !( $revid == 0 )  )
				$nav_urls['permalink'] = array(
					'text' => wfMsg( 'permalink' ),
					'href' => $wgTitle->getLocalURL( "oldid=$revid" )
				);
		}

		wfRunHooks( 'SkinTemplateBuildNavUrlsNav_urlsAfterPermalink', array( &$this, &$nav_urls, &$oldid, &$revid ) );
	}

	if( $wgTitle->getNamespace() != NS_SPECIAL ) {
		$wlhTitle = SpecialPage::getTitleFor( 'Whatlinkshere', $wgTitle->getPrefixedDbKey() );
		$nav_urls['whatlinkshere'] = array(
			'href' => $wlhTitle->getLocalUrl()
		);
		if( $wgTitle->getArticleId() ) {
			$rclTitle = SpecialPage::getTitleFor( 'Recentchangeslinked', $wgTitle->getPrefixedDbKey() );
			$nav_urls['recentchangeslinked'] = array(
				'href' => $rclTitle->getLocalUrl()
			);
		} else {
			$nav_urls['recentchangeslinked'] = false;
		}
		if ($wgUseTrackbacks)
			$nav_urls['trackbacklink'] = array(
				'href' => $wgTitle->trackbackURL()
			);
	}

	if( $wgTitle->getNamespace() == NS_USER || $wgTitle->getNamespace() == NS_USER_TALK ) {
		$id = User::idFromName($wgTitle->getText());
		$ip = User::isIP($wgTitle->getText());
	} else {
		$id = 0;
		$ip = false;
	}

	if($id || $ip) { # both anons and non-anons have contri list
		$nav_urls['contributions'] = array(
			'href' => self::makeSpecialUrlSubpage( 'Contributions', $wgTitle->getText() )
		);
		if ( $wgUser->isAllowed( 'block' ) ) {
			$nav_urls['blockip'] = array(
				'href' => self::makeSpecialUrlSubpage( 'Blockip', $wgTitle->getText() )
			);
		} else {
			$nav_urls['blockip'] = false;
		}
	} else {
		$nav_urls['contributions'] = false;
		$nav_urls['blockip'] = false;
	}
	$nav_urls['emailuser'] = false;
	if( $this->showEmailUser( $id ) ) {
		$nav_urls['emailuser'] = array(
			'href' => self::makeSpecialUrlSubpage( 'Emailuser', $wgTitle->getText() )
		);
	}
	
	if( $wgUser->isLoggedIn() ){
		$nav_urls['watchlist'] = array( 'href' => self::makeSpecialUrl( 'Watchlist' ) );
	}
	wfProfileOut( $fname );
	return $nav_urls;
}

function sideNavigation() {
	global $wgTitle, $wgUser, $wgRequest;
	
	$skin = $wgUser->getSkin();
	$sidebar = GetLinksArrayFromMessage('Sidebar');
	$x = 1;
	$link_count = 1;
	
	$navigation = "";

	//if ($wgTitle->getNamespace()!=NS_MINI) {
	
		$navigation .= "<script>

			function sn_on(el) {
				\$(el).addClassName('sn-hover');
			}

			function sn_off(el) {
				\$(el).removeClassName('sn-hover');
			}
		</script>";

		$navigation .= "<div id=\"side-navigation\">";

		//Navigation Boxes
		foreach($sidebar as $sn_title=>$sn_properties) {

			
			$navigation .= "<div class=\"side-unit\">
				<div class=\"side-unit-title\">".ucfirst($sn_title)."</div>
				<div class=\"side-unit-content\">";

			foreach ($sn_properties as $link) {

				if (count($sn_properties)==$link_count) {
					$border_fix = "border-fix";
				} else {
					$border_fix = "";
				}

				if ($x==1) {
					$hover = "id=\"side-link-{$link_count}\" onmouseover=\"sn_on('side-link-{$link_count}')\" onmouseout=\"sn_off('side-link-{$link_count}')\"";
				} else {
					$hover = "";
				}

				$navigation .= "<div class=\"side-link {$border_fix}\" {$hover}><a href=\"{$link["href"]}\" rel=\"no-follow\">".ucfirst($link["text"])."</a></div>";

				$link_count++;
			}
			
				$navigation .= "</div>
			</div>";

			$x++;

			}

		/**Search Box
		$navigation .= "<div class=\"side-unit\">
			<div class=\"side-unit-title\">" . wfMsg("search") . "</div>
			<div class=\"side-unit-content\">
				<div id=\"searchBody\">
					<form action=\"\" id=\"searchform\">
						<input id=\"searchInput\" name=\"search\" type=\"text\" value=\"" . htmlspecialchars($wgRequest->getVal("search")) . "\">
						<input type=\"submit\" name=\"go\" class=\"searchButton\" id=\"searchGoButton\"	value=\"" . wfMsg('searcharticle') . "\" />&nbsp;
						<input type=\"submit\" name=\"fulltext\" class=\"searchButton\" id=\"mw-searchButton\" value=\"" . wfMsg('searchbutton') . "\" />
					</form>
				</div>
			</div>	
		</div>";
		**/

		//Tool Tips
		$nav_urls = $this->buildNavUrls();
		$navigation .= "<div class=\"side-unit\">
			<div class=\"side-unit-title\">
				".wfmsg('toolbox')."
			</div>
			<div class=\"side-unit-content\">";

				if ($wgTitle->getNamespace() != NS_SPECIAL) {
					$navigation .= "<div class=\"side-link\" id=\"t-whatlinkshere\">
						<a href=\"".htmlspecialchars($nav_urls['whatlinkshere']['href'])."\" ".$skin->tooltipAndAccesskey('t-whatlinkshere').">
							".wfMsg('whatlinkshere')."
						</a>
					</div>";

					if ($nav_urls['recentchangeslinked']) {
						$navigation .= "<div class=\"side-link\" id=\"t-recentchangeslinked\">
							<a href=\"".htmlspecialchars($nav_urls['recentchangeslinked']['href'])."\" ".$skin->tooltipAndAccesskey('t-recentchangeslinked').">
								".wfMsg('recentchangeslinked')."
							</a>
						</div>";
					}
				}

				if (isset($nav_urls['trackbacklink'])) {
					$navigation .= "<div class=\"side-link\" id=\"t-trackbacklink\">
						<a href=\"".htmlspecialchars($nav_urls['trackbacklink']['href'])."\" ".$skin->tooltipAndAccesskey('t-trackbacklink').">
							".wfMsg('trackbacklink')."
						</a>
					</div>";
				}
				if (isset($nav_urls['watchlist'])) {
					$navigation .= "<div class=\"side-link\" id=\"t-watchlist\">
						<a href=\"".htmlspecialchars($nav_urls['watchlist']['href'])."\" ".$skin->tooltipAndAccesskey('t-watchlist').">
							". ucfirst(wfMsg('watchlist')) ."
						</a>
					</div>";
				}
				foreach (array('contributions', 'blockip', 'emailuser', 'upload', 'specialpages') as $special) {

					if ($nav_urls[$special]) {
						$navigation .= "<div class=\"side-link\" id=\"t-{$special}\">
							<a href=\"". htmlspecialchars($nav_urls[$special]['href'])."\"".$skin->tooltipAndAccesskey('t-'.$special).">
								".wfMsg($special)."
							</a>
						</div>";
					}
				}

				if (!empty($nav_urls['print']['href'])) {
					$navigation .= "<div class=\"side-link\" id=\"t-print\">
						<a href=\"".htmlspecialchars($nav_urls['print']['href']) ."\"".$skin->tooltipAndAccesskey('t-print') .">
							".wfMsg('printableversion')."
						</a>
					</div>";
				}

				if (!empty($nav_urls['permalink']['href'])) {
					$navigation .= "<div class=\"side-link\" id=\"t-permalink\">
						<a href=\"".htmlspecialchars($nav_urls['permalink']['href'])."\"" .$skin->tooltipAndAccesskey('t-permalink') .">
							". wfMsg('permalink')."
						</a>
					</div>";

				} else if ($nav_urls['permalink']['href'] === '') {
					$navigation .= "<div class=\"side-link\" id=\"t-ispermalink\" ".$skin->tooltip('t-ispermalink').">
						".wfMsg('permalink')."
					</div>";
				}

			$navigation .= "</div>
		</div>";

		//Language URLS

		$lang_urls = $this->buildLanguageUrls();
		if( $lang_urls ) {
			$navigation .= "<div class=\"side-unit\">
				<div class=\"side-unit-title\">
					".wfMsg('otherlanguages')."
				</div>
				<div class=\"side-unit-content\">";
					foreach( $lang_urls as $langlink) {
						$navigation .= "<div class=\"" . htmlspecialchars($langlink['class']) . " side-link\">
							<a href=\"".htmlspecialchars($langlink['href'])."\">".$langlink['text']."</a>
						</div>";
					}
					$navigation .= "
				</div>
			</div>";
		}

		$navigation .= "</div>";
		
	//}
	
	return $navigation;
}

function isContent(){
	global $wgTitle;
	return ($wgTitle->getNamespace() != NS_SPECIAL );
}

function tabAction( $title, $message, $selected, $query='', $checkEdit=false ) {
	$classes = array();
	if( $selected ) {
		$classes[] = 'selected';
	}	
	if( $checkEdit && $title->getArticleId() == 0 ) {
		$query = 'action=edit';
	}

	$text = wfMsg( $message );
	if ( wfEmptyMsg( $message, $text ) ) {
		global $wgContLang;
		$text = $wgContLang->getFormattedNsText( Namespace::getSubject( $title->getNamespace() ) );
	}

	return array(
		'class' => implode( ' ', $classes ),
		'text' => $text,
		'href' => $title->getLocalUrl( $query ) );
}

function buildActionBar(){
	global $wgRequest, $wgTitle, $wgOut, $wgUser;
	
	$action = $wgRequest->getText( 'action' );
	$section = $wgRequest->getText( 'section' );
	$content_actions = array();
	$prevent_active_tabs = "";
	if( $this->isContent()) {
		$subjpage = $wgTitle->getSubjectPage();
		$talkpage = $wgTitle->getTalkPage();
		$nskey = $wgTitle->getNamespaceKey();
		
		$content_actions[$nskey] = $this->tabAction(
			$subjpage,
			$nskey,
			!$wgTitle->isTalkPage() && !$prevent_active_tabs,
			'', true);

		$content_actions['talk'] = $this->tabAction(
			$talkpage,
			'talk',
			$wgTitle->isTalkPage() && !$prevent_active_tabs,
			'',
			true);
		
		if ( $wgTitle->quickUserCan( 'edit' ) && ( $wgTitle->exists() || $wgTitle->quickUserCan( 'create' ) ) ) {
			$istalk = $wgTitle->isTalkPage();
			$istalkclass = $istalk?' istalk':'';
			$content_actions['edit'] = array(
				'class' => ((($action == 'edit' or $action == 'submit') and $section != 'new') ? 'selected' : '').$istalkclass,
				'text' => wfMsg('edit'),
				'href' => $wgTitle->getLocalUrl( $this->editUrlOptions() )
			);

			if ( $istalk || $wgOut->showNewSectionLink() ) {
				$content_actions['addsection'] = array(
					'class' => $section == 'new'?'selected':false,
					'text' => wfMsg('addsection'),
					'href' => $wgTitle->getLocalUrl( 'action=edit&section=new' )
				);
			}
		} else {
			$content_actions['viewsource'] = array(
				'class' => ($action == 'edit') ? 'selected' : false,
				'text' => wfMsg('viewsource'),
				'href' => $wgTitle->getLocalUrl( $this->editUrlOptions() )
			);
		}
		
		if ( $wgTitle->getArticleId() ) {

			$content_actions['history'] = array(
				'class' => ($action == 'history') ? 'selected' : false,
				'text' => wfMsg('history_short'),
				'href' => $wgTitle->getLocalUrl( 'action=history')
			);

			if ( $wgTitle->getNamespace() !== NS_MEDIAWIKI && $wgUser->isAllowed( 'protect' ) ) {
				if(!$wgTitle->isProtected()){
					$content_actions['protect'] = array(
						'class' => ($action == 'protect') ? 'selected' : false,
						'text' => wfMsg('protect'),
						'href' => $wgTitle->getLocalUrl( 'action=protect' )
					);

				} else {
					$content_actions['unprotect'] = array(
						'class' => ($action == 'unprotect') ? 'selected' : false,
						'text' => wfMsg('unprotect'),
						'href' => $wgTitle->getLocalUrl( 'action=unprotect' )
					);
				}
			}
			if($wgUser->isAllowed('delete')){
				$content_actions['delete'] = array(
					'class' => ($action == 'delete') ? 'selected' : false,
					'text' => wfMsg('delete'),
					'href' => $wgTitle->getLocalUrl( 'action=delete' )
				);
			}
			if ( $wgTitle->quickUserCan( 'move' ) ) {
				$moveTitle = SpecialPage::getTitleFor( 'Movepage', $this->thispage );
				$content_actions['move'] = array(
					'class' => $wgTitle->isSpecial( 'Movepage' ) ? 'selected' : false,
					'text' => wfMsg('move'),
					'href' => $moveTitle->getLocalUrl()
				);
			}
		} else {
			//article doesn't exist or is deleted
			if( $wgUser->isAllowed( 'delete' ) ) {
				if( $n = $wgTitle->isDeleted() ) {
					$undelTitle = SpecialPage::getTitleFor( 'Undelete' );
					$content_actions['undelete'] = array(
						'class' => false,
						'text' => wfMsgExt( 'undelete_short', array( 'parsemag' ), $n ),
						'href' => $undelTitle->getLocalUrl( 'target=' . urlencode( $this->thispage ) )
						#'href' => self::makeSpecialUrl( "Undelete/$this->thispage" )
					);
				}
			}
		}
	}else{
		/* show special page tab */
		$content_actions[$wgTitle->getNamespaceKey()] = array(
			'class' => 'selected',
			'text' => wfMsg('nstab-special'),
			'href' => $wgRequest->getRequestURL(), // @bug 2457, 2510
		);
	}
	
	return $content_actions;
}

function getActionBarLinks() {
	global $wgTitle;
	
	$left = array($wgTitle->getNamespaceKey(), "edit","talk","viewsource","addsection","history");
	$actions = $this->buildActionBar();
	$moreLinks = array();
	$leftLinks = array();
	foreach($actions as $action => $value){
		if ( in_array( $action, $left ) ){
			$leftLinks[$action] = $value;
		}else{
			$moreLinks[$action] = $value;
		}
	}

	return array( $leftLinks, $moreLinks );
}

function actionBar() {
	
	global $wgUser, $wgTitle;
	
	$full_title = Title::makeTitle( $wgTitle->getNameSpace(), $wgTitle->getText() );
	
	$output = "";
	$output .= "<div id=\"action-bar\">";
		if ($wgUser->isLoggedIn() && $this->isContent() ) {

			$output .= "<div id=\"article-controls\">
				<img src=\"http://alpha.search.wikia.com/images/wikia/plus.gif\" alt=\"\" border=\"0\">";

				if (!$wgTitle->userIsWatching()) {
					$output .= "<a href=\"".$full_title->escapeFullURL('action=watch')."\">
						".wfMsg('watch')."
					</a>";
				} else {
					$output .= "<a href=\"".$full_title->escapeFullURL('action=unwatch')."\">
						".wfMsg('unwatch')."
					</a>";
				}
			$output .= "</div>";
		}
		$output .= "<div id=\"article-tabs\">";
			
			list( $leftLinks, $moreLinks ) = $this->getActionBarLinks();
			
			foreach ($leftLinks as $key => $val) {
					$output .= "<a href=\"".htmlspecialchars($val['href'])."\" class=\"".(($val['class']!="selected")?"article-tab-off":"article-tab-on")."\" rel=\"nofollow\">
						<span>" . ucfirst($val['text']) . "</span>
					</a>";
			}
			
			if (count($moreLinks)>0) {
				
				$output .=  "<script>
					var _shown = false;
					var _hide_timer;
					function show_actions(el, type) {

						if (type==\"show\") {
							clearTimeout(_hide_timer);
							if (!_shown) {
								\$('more-arrow').src = 'http://alpha.search.wikia.com/images/wikia/down_arrow_on.gif';
								\$('more-tab').removeClassName('more-tab-off');
								\$('more-tab').addClassName('more-tab-on');
								\$(el).show();
								_shown = true;
							}
						} else {
							\$('more-arrow').src = 'http://alpha.search.wikia.com/images/wikia/down_arrow_off.gif';
							\$('more-tab').removeClassName('more-tab-on');
							\$('more-tab').addClassName('more-tab-off');
							\$(el).hide();
							_shown = false;
						}

					}
					
					function delay_hide(el) {
						_hide_timer = setTimeout (function() {show_actions(el, 'hide');}, 500);
					}

				
				
				</script>
				

				<div class=\"more-tab-off\" id=\"more-tab\" onmouseover=\"show_actions('article-more-container', 'show');\" onmouseout=\"delay_hide('article-more-container');\">
					<span>More Actions <img src=\"http://alpha.search.wikia.com/images/wikia/down_arrow_off.gif\" id=\"more-arrow\" alt=\"\" border=\"0\"/></span>";
				
					$output .= "<div class=\"article-more-actions\" id=\"article-more-container\" style=\"display:none\" onmouseover=\"clearTimeout(_hide_timer);\" onmouseout=\"show_actions('article-more-container', 'hide');\">";
					
					$more_links_count = 1;
					
					foreach ($moreLinks as $key => $val) {
						
						if (count($moreLinks)==$more_links_count) {
							$border_fix = "class=\"border-fix\"";
						} else {
							$border_fix = "";
						}
						
						$output .= "<a href=\"".htmlspecialchars( $val['href'] )."\" {$border_fix} rel=\"nofollow\">
							".ucfirst($val['text'])."
						</a>";
						
						$more_links_count++;
					}
				$output .= "</div>
				</div>";
			}
		
			$output .= 	"<div class=\"cleared\"></div>
		</div>
	</div>";
	
	return $output;
	
}
  
function doBeforeContent() {

	global $wgOut, $wgTitle, $wgParser, $wgUser, $wgLang, $wgContLang, $wgEnableUploads, $wgRequest, $wgSiteView, $wgArticle, $IP, $wgMemc, $wgUploadPath;	 
     
	/*
	if ($wgTitle->getNamespace()==NS_MINI) {
		$mini_fix = "class=\"mini-fix\"";
	}
	*/

	$output = "<div id=\"container\">";
		$output .= $this->header();
		$output .= "<div id=\"article-container\">
			".$this->actionBar()."
			<div id=\"article\">
				<div id=\"article-text\">
					".$this->pageTitle().
					$this->pageSubtitle();
	

  return $output;
  
}
 
 function doAfterContent() {
 
 	global $wgOut, $wgUser, $wgTitle, $wgSupressPageCategories;
  	$output = "";
					$cat=$this->getCategoryLinks();
					if($cat){
						$output.="<div id=\"catlinks\">
							$cat
						</div>";
					}
					$output .= "<div class=\"cleared\"></div>
				</div>
			</div>";
			//$output .= $this->footer();
		$output .= "</div>";
		$output .= $this->sideNavigation();
	$output .= "</div>";
	
	
  return $output;
 }
 

 
   function searchForm( $label = "" ) {
    global $wgRequest, $wgUploadPath;
  
    $search = $wgRequest->getText( 'search' );
    $action = $this->escapeSearchLink();
  
    $s = "<form method=\"get\" action=\"$action\" name=\"search_form\">";
  
    if ( "" != $label ) { $s .= "{$label}: "; }
	$s .= "<div class=\"search-form\">
		<div class=\"search-input\"><input type='text' name=\"search\" size='20' value=\"Players, Teams, Sports\" onclick=\"this.value=''\"/></div>
		<div class=\"search-button\" onclick=\"document.search_form.submit()\"></div>
	</div>";
    $s .= "</form>";
  
	//<input type='image' src='{$wgUploadPath}/common/search.png' value=\"" . htmlspecialchars( wfMsg( "go" ) ) . "\" onclick=\"document.search-form.submit()\"/>

    return $s;
  }
  
  
	
	function bottomScripts() {
		
		global $wgJsMimeType;
		$r = "\n\t\t<script type=\"$wgJsMimeType\">if (window.runOnloadHook) runOnloadHook();</script>\n";

		$r .= "<script src='http://www.google-analytics.com/urchin.js'  type='text/javascript'></script><script type='text/javascript'>function GAEvent(msg){_udn = 'none';_uff = 0;_uacct='UA-288915-2';urchinTracker('/b2098/'+msg+'/'+location.hostname);}GAEvent('show');</script>\n";
		
		
		return $r;
	}
 
}

?>
