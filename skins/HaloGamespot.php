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

/**
 * requeire for wfGetRandomGameUnit, fix #3050
 */
require_once( "$IP/extensions/wikia/RandomGameUnit/RandomGameUnit.php" );

class SkinHaloGamespot extends Skin {

	private $navmenu;
	private $navmenu_array;

	#set stylesheet
	function getStylesheet() {
		return "http://images2.wikia.com/common/wikiany/css/HaloGamespot.css";
	}

	#set skinname
	function getSkinName() {
		return "HaloGamespot";
	}

	# get the user/site-specific stylesheet, SkinTemplate loads via RawPage.php (settings are cached that way)
	function getUserStylesheet() {
		global $wgStylePath, $wgRequest, $wgContLang, $wgSquidMaxage, $wgStyleVersion;
		$sheet = $this->getStylesheet();
		//$s = "@import \"$wgStylePath/common/common.css?$wgStyleVersion\";\n";
		$s .= "@import \"$sheet?$wgStyleVersion\";\n";
		if($wgContLang->isRTL()) $s .= "@import \"$wgStylePath/common/common_rtl.css?$wgStyleVersion\";\n";

		$query = "usemsgcache=yes&action=raw&ctype=text/css&smaxage=$wgSquidMaxage";
		$s .= '@import "' . self::makeNSUrl( 'Common.css', $query, NS_MEDIAWIKI ) . "\";\n" .
			'@import "' . self::makeNSUrl( ucfirst( $this->getSkinName() . '.css' ), $query, NS_MEDIAWIKI ) . "\";\n";

		$s .= $this->doGetUserStyles();
		return $s."\n";
	}

	function getUserStyles() {
		$s = "<style type='text/css'>\n";
		$s .= "/*/*/ /*<![CDATA[*/\n"; # <-- Hide the styles from Netscape 4 without hiding them from IE/Mac
		$s .= $this->getUserStylesheet();
		$s .= "/*]]>*/ /* */\n";
		$s .= "</style>\n";

		$s .= "<!--[if IE]><style type=\"text/css\" media=\"all\">@import \"http://images2.wikia.com/common/wikiany/css/Halo_IE.css\";</style><![endif]-->\n";
		return $s;

	}
function bottomScripts() {

			global $wgJsMimeType;

			$r .= "<script src=\"http://www.google-analytics.com/urchin.js\" type=\"text/javascript\"></script>\n";
			$r .= "<script type=\"text/javascript\">\n";
			$r .= "_udn=\"none\";_uff=0;_uacct=\"UA-288915-1\";\n";
			$r .= "_userv=2;urchinTracker();_userv=1;\n";
			$r .= "var Key;\n";

			$r .= "if (typeof wgUserName == 'undefined' || wgUserName == null) {Key=\"Anon/\"} else {Key=\"User/\"}\n";
			$r .= "if (typeof skin == 'undefined' || skin == null) {Key+=\"na/\" } else {Key+=skin.substr(0,6)+\"/\"}\n";
			$r .= "Key+=\"../\";\n";
			$r .= "if (typeof wgWikiaAdvertiserCategory == 'undefined' || wgWikiaAdvertiserCategory == null) {Key+=\"na/\"} else {Key+=wgWikiaAdvertiserCategory+\"/\"}\n";
			$r .= "if (typeof wgCityId == 'undefined' || wgCityId == null) {Key+=\"na/\"} else {Key+=wgCityId+\"/\"};\n";
			$r .= "if (typeof bannerid == 'undefined') {Key+=\"na/\"} else {Key+=bannerid+\"/\"};\n";

			$r .= "_udn=\"none\";_uff=0;_uacct=\"UA-288915-6\";urchinTracker(Key);\n";

			$r .= "if (typeof wgID == 'number')\n";
			$r .= "{\n";
			$r .= "var cid_ua = new Array()\n";
			$r .= "cid_ua.push(51,\"UA-2697185-4\", 147,\"UA-288915-7\",462,\"UA-288915-8\",410,\"UA-288915-9\",113,\"UA-288915-10\",324,\"UA-288915-11\",602,\"UA-288915-12\",1657,\"UA-784542-1\",59,\"UA-363124-1\", 38,\"UA-89493-2\", 1323,\"UA-89493-2\", 769,\"UA-992722-1\", 1107,\"UA-265325-1\", 1844,\"UA-89493-1\", 549,\"UA-89493-1\", 1167,\"UA-89493-3\", 1870,\"UA-346766-6\", 1846,\"UA-89493-1\", 1448,\"UA-550357-1\", 1848,\"UA-89493-1\", 989,\"UA-371419-1\", 706,\"UA-444393-1\", 816,\"UA-84972-5\", 1847,\"UA-89493-1\", 383,\"UA-921254-1\", 2161,\"UA-921115-1\", 3616,\"UA-145089-1\", 3756,\"UA-145089-1\", 2233,\"UA-145089-1\", 2234,\"UA-145089-1\", 2235,\"UA-145089-1\", 2236,\"UA-145089-1\", 2237,\"UA-145089-4\", 2020,\"UA-87586-8\", 171,\"UA-978350-1\", 1928,\"UA-657201-1\", 1864,\"UA-855317-1\", 1404,\"UA-722649-1\", 702,\"UA-680784-1\", 909,\"UA-968098-1\", 999,\"UA-818628-1\", 1981,\"UA-776391-1\", 1916,\"UA-1153537-1\", 1778,\"UA-1068008-1\", 2307,\"UA-1276867-1\", 2166,\"UA-1291238-2\", 133,\"UA-1362746-1\", 2342,\"UA-1368221-1\", 645,\"UA-1368532-1\", 2193,\"UA-1368560-1\", 667,\"UA-1377241-1\", 2195,\"UA-1263121-1\", 3236,\"UA-2100028-5\", 193,\"UA-1946686-3\", 2165,\"UA-1946686-2\")\n";
			$r .= "for (i = 0;i<cid_ua.length;i=i+2) {if (wgID==cid_ua[i]) {_udn=\"none\";_uff=0;_uacct=cid_ua[i+1];urchinTracker();}}\n";
			$r .= "}\n";

			$r .= "if (typeof skin != 'undefined' && skin == \"quartz\")\n";
			$r .= "{\n";
			$r .= "document.write (\"<\" + \"script language='JavaScript' type='text/javascript' \");\n";
			$r .= "document.write (\"src='http://static.fmpub.net/site/wikia'><\" + \"/script>\");\n";
			$r .= "}\n";
			$r .= "</script>\n";

			return $r;
	}

	function getHeadScripts() {
		global $wgStylePath, $wgUser, $wgAllowUserJs, $wgJsMimeType, $wgStyleVersion, $wgServer;

		$r = self::makeGlobalVariablesScript( array( 'skinname' => $this->getSkinName() ) );
		$r .= "<script type= \"text/javascript\">\n var wgCityId = \"462\";\n var wgID = 462;\n var wgWikiaAdvertiserCategory = \"GAMI\";\n</script>\n";


		$r .= "<script type=\"{$wgJsMimeType}\" src=\"http://images1.wikia.com/common/wikiany/js/wikibits.js?$wgStyleVersion\"></script>\n";
		$r .= "<script type=\"{$wgJsMimeType}\" src=\"http://images1.wikia.com/common/wikiany/js/onejstorule.js?{$wgStyleVersion}\"></script>\n";
		//$r .= "<script type=\"{$wgJsMimeType}\" src=\"{$wgServer}/extensions/wikia/container_core-min.js?{$wgStyleVersion}\"></script>\n";
		//$r .= "<script type=\"{$wgJsMimeType}\" src=\"{$wgServer}/extensions/wikia/menu-min.js?{$wgStyleVersion}\"></script>\n";

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

	function searchForm( $label = "" ) {

	 	global $wgRequest, $wgUploadPath;

	    $search = $wgRequest->getText( 'search' );
	    $action = $this->escapeSearchLink();

	    $search = "<form method=\"get\" action=\"$action\" name=\"search_form\">";

	    if ( "" != $label ) { $s .= "{$label}: "; }
		$search .= "<input type=\"text\" class=\"search-field\" name=\"search\" value=\"enter search\" onclick=\"this.value=''\"/>
		<input type=\"image\" src=\"{$wgUploadPath}/common/new/search_button.gif\" class=\"search-button\" value=\"go\"/>";
	    $search .= "</form>
		<div class=\"cleared\"></div>";

	    return $search;

	  }

	  /**
	 * Parse MediaWiki-style messages called 'v3sidebar' to array of links, saving
	 * hierarchy structure.
	 * Message parsing is limited to first 150 lines only.
	 *
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getNavigationMenu() {
		$message_key = 'sidebar';
		$message = trim(wfMsg($message_key));

		if(wfEmptyMsg($message_key, $message)) {
			return array();
		}

		$lines = array_slice(explode("\n", $message), 0, 150);

		if(count($lines) == 0) {
			return array();
		}

		$nodes = array();
		$nodes[] = array();
		$lastDepth = 0;
		$i = 0;
		foreach($lines as $line) {

			$node = $this->parseItem($line);
			$node['depth'] = strrpos($line, '*') + 1;

			if($node['depth'] == $lastDepth) {
				$node['parentIndex'] = $nodes[$i]['parentIndex'];
			} else if ($node['depth'] == $lastDepth + 1) {
				$node['parentIndex'] = $i;
			} else {
				for($x = $i; $x >= 0; $x--) {
					if($x == 0) {
						$node['parentIndex'] = 0;
						break;
					}
					if($nodes[$x]['depth'] == $node['depth'] - 1) {
						$node['parentIndex'] = $x;
						break;
					}
				}
			}

			$nodes[$i+1] = $node;
			$nodes[$node['parentIndex']]['children'][] = $i+1;
			$lastDepth = $node['depth'];
			$i++;
		}
		return $nodes;
	}

	/**
	 * Parse one line form MediaWiki-style message as array of 'text' and 'href'
	 *
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function parseItem($line) {
		$line_temp = explode('|', trim($line, '* '), 2);
		if(count($line_temp) > 1) {
			$line = $line_temp[1];
			$link = wfMsgForContent( $line_temp[0] );
		} else {
			$line = $line_temp[0];
			$link = $line_temp[0];
		}

		if (wfEmptyMsg($line, $text = wfMsg($line))) {
			$text = $line;
		}

		if($link != null) {
			if (wfEmptyMsg($line_temp[0], $link)) {
				$link = $line_temp[0];
			}
			if ( preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link ) ) {
				$href = $link;
			} else {
				$title = Title::newFromText( $link );
				if($title) {
					$title = $title->fixSpecialName();
					$href = $title->getLocalURL();
				} else {
					$href = 'INVALID-TITLE';
				}
			}
		}
		return array('text' => $text, 'href' => $href);
	}

	private function buildMoreGaming(){
		$message_key = 'moregaming';
		$message = trim(wfMsg($message_key));

		if(wfEmptyMsg($message_key, $message)) {
			return array();
		}

		$lines = array_slice(explode("\n", $message), 0, 150);

		if(count($lines) == 0) {
			return array();
		}


		foreach($lines as $line) {
			$more_gaming[] = $this->parseItem($line);
		}

		return $more_gaming;
	}

	private function printMenu($id, $last_count='', $level=0) {
		global $wgUploadPath;
		$menu_output = "";
		$script_output = "";
		$count = 1;
		if(isset($this->navmenu[$id]['children'])) {
			$script_output .= '<script type="text/javascript">/*<![CDATA[*/';
			if ($level) {
				$menu_output .= '<div class="sub-menu" id="sub-menu' . $last_count . '" style="display:none;" >';
				$script_output .= 'submenu_array["sub-menu' . $last_count . '"] = "' . $last_count . '";';
				$script_output .= '$("sub-menu' . $last_count . '").onmouseout = clearMenu;if ($("sub-menu' . $last_count . '").captureEvents) $("sub-menu' . $last_count . '").captureEvents(Event.MOUSEOUT);';
			}
			foreach($this->navmenu[$id]['children'] as $child) {

				$mouseover = ' onmouseover="' . ($level ? 'sub_' : '') . 'menuItemAction(\'' . ($level ? $last_count . '_' : '_') .$count . '\');"';
				$mouseout = ' onmouseout="clearBackground(\'_' . $count . '\')"';
				$menu_output .='<div class="' . ($level ? 'sub-' : '') . 'menu-item' . (($count==sizeof($this->navmenu[$id]['children'])) ? ' border-fix' : '') . '" id="' . ($level ? 'sub-' : '') . 'menu-item' . ($level ? $last_count . '_' : '_') .$count . '">';
				$menu_output .= '<a id="' . ($level ? 'a-sub-' : 'a-') . 'menu-item' . ($level ? $last_count . '_' : '_') .$count . '" href="'.(!empty($this->navmenu[$child]['href']) ? htmlspecialchars($this->navmenu[$child]['href']) : '#').'">';
				if(!$level) {

					$script_output .= 'menuitem_array["menu-item' . $last_count . '_' .$count .'"] = "' . $last_count . '_' .$count . '";';
					$script_output .= '$("menu-item' . $last_count . '_' .$count .'").onmouseover = menuItemAction;if ($("menu-item' . $last_count . '_' .$count .'").captureEvents) $("menu-item' . $last_count . '_' .$count .'").captureEvents(Event.MOUSEOVER);';
					$script_output .= '$("menu-item' . $last_count . '_' .$count .'").onmouseout = clearBackground;if ($("menu-item' . $last_count . '_' .$count .'").captureEvents) $("menu-item' . $last_count . '_' .$count .'").captureEvents(Event.MOUSEOUT);';

					$script_output .= '$("a-menu-item' . $last_count . '_' .$count .'").onmouseover = menuItemAction;if ($("a-menu-item' . $last_count . '_' .$count .'").captureEvents) $("a-menu-item' . $last_count . '_' .$count .'").captureEvents(Event.MOUSEOVER);';

					/*
					$script_output .= 'menuitem_array["d-menu-item' . $last_count . '_' .$count .'"] = "' . $last_count . '_' .$count . '";';
					$script_output .= '$("d-menu-item' . $last_count . '_' .$count .'").onmouseover = menuItemAction;if ($("d-menu-item' . $last_count . '_' .$count .'").captureEvents) $("d-menu-item' . $last_count . '_' .$count .'").captureEvents(Event.MOUSEOVER);';
					$script_output .= '$("d-menu-item' . $last_count . '_' .$count .'").onmouseout = clearBackground;if ($("d-menu-item' . $last_count . '_' .$count .'").captureEvents) $("d-menu-item' . $last_count . '_' .$count .'").captureEvents(Event.MOUSEOUT);';
					*/
				}
				else {
					$script_output .= 'submenuitem_array["sub-menu-item' . $last_count . '_' .$count .'"] = "' . $last_count . '_' .$count . '";';
					$script_output .= '$("sub-menu-item' . $last_count . '_' .$count .'").onmouseover = sub_menuItemAction;if ($("sub-menu-item' . $last_count . '_' .$count .'").captureEvents) $("sub-menu-item' . $last_count . '_' .$count .'").captureEvents(Event.MOUSEOVER);';
				}
				$menu_output .= $this->navmenu[$child]['text'];
				if (sizeof($this->navmenu[$child]['children'])) {
					//$menu_output .= '<div class="sub-menu-button"><img src="http://fp029.sjc.wikia-inc.com/images/halo/new/right_arrow.gif" alt="" border="0" /></div>';
					$menu_output .= '<img src="{$wgUploadPath}/common/new/right_arrow.gif" alt="" border="0" class="sub-menu-button" />';
				}
				$menu_output .= '</a>';
				//$menu_output .= $id . ' ' . sizeof($this->navmenu[$child]['children']) . ' ' . $child . ' ';
				$menu_output .= $this->printMenu($child, $last_count . '_' . $count, $level+1);
				//$menu_output .= "last";
				$menu_output .= '</div>';
				$count++;
			}
			if ($level) {
				$menu_output .= '</div>';
			}
			$script_output .= '/*]]>*/</script>';
		}

		if ($menu_output.$script_output!="") {

			$output .= "<div id=\"menu{$last_count}\">";
				$output .= $menu_output . $script_output;
			$output .= "</div>";

		}



		return $output;
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
			$classes[] = ' new';
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
					$moveTitle = SpecialPage::getTitleFor( 'Movepage', $wgTitle->getPrefixedDbKey() );
					$content_actions['move'] = array(
						'class' => $wgTitle->isSpecial( 'Movepage' ) ? 'selected' : false,
						'text' => wfMsg('move'),
						'href' => $moveTitle->getLocalUrl()
					);
				}

				$whatlinkshereTitle = SpecialPage::getTitleFor( 'Whatlinkshere', $wgTitle->getPrefixedDbKey() );
				$content_actions['whatlinkshere'] = array(
					'class' => $wgTitle->isSpecial( 'Whatlinkshere' ) ? 'selected' : false,
					'text' => wfMsg('whatlinkshere'),
					'href' => $whatlinkshereTitle->getLocalURL()
				);

			} else {
				//article doesn't exist or is deleted
				if( $wgUser->isAllowed( 'delete' ) ) {
					if( $n = $wgTitle->isDeleted() ) {
						$undelTitle = SpecialPage::getTitleFor( 'Undelete' );
						$content_actions['undelete'] = array(
							'class' => false,
							'text' => wfMsgExt( 'undelete_short', array( 'parsemag' ), $n ),
							'href' => $undelTitle->getLocalUrl( 'target=' . urlencode( $wgTitle->getPrefixedDbKey() ) )
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

			if( $wgTitle->getText() == "QuizGameHome" && $wgUser->isAllowed( 'protect' ) ){
				global $wgQuizID;
				$quiz = Title::makeTitle( NS_SPECIAL, "QuizGameHome");
				$content_actions["edit"] = array(
					'class' => ($wgRequest->getVal("questionGameAction") == 'editItem') ? 'selected' : false,
					'text' => wfMsg('edit'),
					'href' => $quiz->getFullURL("questionGameAction=editItem&quizGameId=".$wgQuizID), // @bug 2457, 2510
				);
			}
			if( $wgTitle->getText() == "PictureGameHome" && $wgUser->isAllowed( 'protect' ) ){
				global $wgPictureGameID;
				$quiz = Title::makeTitle( NS_SPECIAL, "PictureGameHome");
				$content_actions["edit"] = array(
					'class' => ($wgRequest->getVal("picGameAction") == 'editPanel') ? 'selected' : false,
					'text' => wfMsg('edit'),
					'href' => $quiz->getFullURL("picGameAction=editPanel&id=".$wgPictureGameID), // @bug 2457, 2510
				);
			}
		}

		return $content_actions;
	}

	function getActionBarLinks() {
		global $wgTitle;

		$left = array($wgTitle->getNamespaceKey(), "edit","talk","viewsource","addsection","history");
		$actions = $this->buildActionBar();

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
						/*$output .= "<a href=\"".htmlspecialchars($val['href'])."\" class=\"".(($val['class']!="selected")?"tab-off":"tab-on")."\" rel=\"nofollow\">
							<span>" . ucfirst($val['text']) . "</span>
						</a>";*/
						$output .= "<a href=\"".htmlspecialchars($val['href'])."\" class=\"".((strpos($val['class'], "selected")===0)?"tab-on":"tab-off"). (strpos($val['class'], "new") && (strpos($val['class'], "new")>0)?" tab-new":"")."\" rel=\"nofollow\">
							<span>" . ucfirst($val['text']) . "</span>
						</a>";
				}

				if (count($moreLinks)>0) {

					$output .=  "<script type=\"text/javascript\">/*<![CDATA[*/
						var _shown = false;
						var _hide_timer;
						function show_actions(el, type) {

							if (type==\"show\") {
								clearTimeout(_hide_timer);
								if (!_shown) {
									\$D.replaceClass('more-tab','more-tab-off','more-tab-on');
									YAHOO.widget.Effects.Show(\$(el));
									_shown = true;
								}
							} else {
								\$D.replaceClass('more-tab','more-tab-on','more-tab-off');

								YAHOO.widget.Effects.Hide(\$(el));
								_shown = false;
							}

						}

						function delay_hide(el) {
							_hide_timer = setTimeout (function() {show_actions(el, 'hide');}, 500);
						}


					/*]]>*/
					</script>


					<div class=\"more-tab-off\" id=\"more-tab\" onmouseover=\"show_actions('article-more-container', 'show');\" onmouseout=\"delay_hide('article-more-container');\">
						<span>More Actions</span>";

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

	static public function parseGamespotFeed($feed)
	{
		wfProfileIn(__METHOD__);

		$allowed_tags = array('headline', 'deck', 'gs_story_link', 'post_date', 'story_id');

		$data = array();
		if (preg_match_all('/<story>(.+)<\/story>/sU', $feed, $preg, PREG_SET_ORDER))
		{
			foreach ($preg as $match)
			{
				$row = array();
				if (preg_match_all('/<([^\/][^>]+)>([^<]+)<\/([^>]+)>/sU', $match[1], $preg2, PREG_SET_ORDER))
				{
					foreach ($preg2 as $match2)
					{
						if (($match2[1] == $match2[3]) && in_array($match2[1], $allowed_tags))
						{
							$row[$match2[1]] = str_replace(array('&lt;', '&gt;', '&amp;'), array('<', '>', '&'), $match2[2]);
						}
					}
				}

				$data[] = $row;
			}
		}

		$data = array_slice($data, 0, 5);

		wfProfileOut(__METHOD__);
		return $data;
	}

	#main page before wiki content
	function doBeforeContent() {

  		##global variables
  		global $wgOut, $wgTitle, $wgParser, $wgUser, $wgLang, $wgContLang, $wgEnableUploads, $wgRequest,
			$wgSiteView, $wgArticle, $IP, $wgMemc, $wgSupressPageTitle,$wgSupressSubTitle, $wgUploadPath;


		$output .= "<div id=\"container\">
			<div id=\"wikia-header\">
				<div id=\"wikia-logo\">
					<a href=\"http://www.wikia.com/wiki/Gaming\"><img src=\"{$wgUploadPath}/common/new/wikia_logo.gif\" alt=\"\" border=\"0\"/></a>
					<span id=\"wikia-category\">Gaming</span>
				</div>
				<div id=\"wikia-more-category\" onclick=\"show_more_category('wikia-more-menu')\">
					<div class=\"positive-button\"><span>More Gaming</span></div>
				</div>
				<div id=\"wikia-more-menu\" style=\"display:none;\">\n";
				$more_gaming = $this->buildMoreGaming();

				$x = 1;
				foreach( $more_gaming as $link ){
					$output .= "<a href=\"{$link["href"]}\"" . (($x==count($more_gaming))?" class=\"border-fix\"":"") . ">{$link["text"]}</a>\n"; //<a href=\"#\">EQ2i</a>
					if ( $x > 1 && $x % 2 == 0 )$output .= "<div class=\"cleared\"></div>\n";
					$x++;
				}

				$output .= "</div>";

				//login safe title
				$register_link = Title::makeTitle(NS_SPECIAL, "UserRegister");
				$login_link = Title::makeTitle(NS_SPECIAL, "Login");
				$logout_link = Title::makeTitle(NS_SPECIAL, "Userlogout");
				$profile_link = Title::makeTitle(NS_USER, $wgUser->getName());
				$main_page_link = Title::makeTitle(NS_MAIN, "Main Page");

				$output .= "<div id=\"wikia-login\">";

					if ($wgUser->isLoggedIn()) {
						$output .= "<div id=\"login-message\">
							Welcome <b>{$wgUser->getName()}</b>
						</div>
						<a class=\"positive-button\" href=\"".$profile_link->escapeFullURL()."\" rel=\"nofollow\"><span>Profile</span></a>
						<a class=\"negative-button\" href=\"".$logout_link->escapeFullURL()."\"><span>Log Out?</span></a>";
					} else {
						$output .= "<a class=\"positive-button\" href=\"".$register_link->escapeFullURL()."\" rel=\"nofollow\"><span>Sign Up</span></a>
						<a class=\"positive-button\" href=\"".$login_link->escapeFullURL()."\"><span>Login</span></a>";
					}


				$output .= "</div>
			</div>
			<div id=\"site-header\">
				<div id=\"site-logo\">
					<a href=\"".$main_page_link->escapeFullURL()."\" rel=\"nofollow\"><img src=\"http://images.wikia.com/halo/images/common/gamespot_icon_halo.jpg\" border=\"0\" alt=\"\"/></a>
				</div>
				<div id=\"site-sub-info\">
					<a href=\"http://www.gamespot.com\"><img src=\"http://images.wikia.com/halo/images/common/gamespot_logo_header.gif\" border=\"0\" alt=\"\"/></a>
					<div class=\"site-info\"><a href=\"".$main_page_link->escapeFullURL()."\" rel=\"nofollow\">Halopedia</a> | Halo 3</div>
				</div>
				<div id=\"site-links\">
					<span class=\"site-links-red\"><a href=\"\">Jump Back to Gamespot:</a></span>
					<b><a href=\"http://www.gamespot.com/xbox360/action/halo3/index.html?tag=wikiacb\">Halo 3</a></b>
					<a href=\"http://www.gamespot.com/xbox360/action/halo3/index.html?tag=wikiacb\">(X360)</a> |
					<b><a href=\"http://www.gamespot.com/xbox360/strategy/halowars/index.html?tag=wikiacb\">Halo Wars</a></b>
					<a href=\"http://www.gamespot.com/xbox360/strategy/halowars/index.html?tag=wikiacb\">(Xbox 360, PC)</a> |
					<b><a href=\"http://www.gamespot.com/xbox/action/halo2/index.html?tag=wikiacb\">Halo 2</a></b>
					<a href=\"http://www.gamespot.com/xbox/action/halo2/index.html?tag=wikiacb\">(Xbox, PC)</a> |
					<b><a href=\"http://www.gamespot.com/xbox/action/halo/index.html?tag=wikiacb\">Halo: Combat Evolved</a></b>
					<a href=\"http://www.gamespot.com/xbox/action/halo/index.html?tag=wikiacb\">(Xbox, PC)</a>
				</div>
			</div>";


			$output .= "<div id=\"side-bar\">";



				$random_page_link = Title::makeTitle(NS_SPECIAL, "RandomPage");
				$recent_changes_link = Title::makeTitle(NS_SPECIAL, "Recentchanges");
				$top_fans_link = Title::makeTitle(NS_SPECIAL, "TopUsers");
				$special_pages_link = Title::makeTitle(NS_SPECIAL, "Specialpages");
				$help_link = Title::makeTitle(NS_HELP, "Contents");
				$images_link = Title::makeTitle(NS_SPECIAL, "ImageRating");
				$articles_home_link = Title::makeTitle(NS_SPECIAL, "ArticlesHome");
				$main_page_link = Title::makeTitle(NS_MAIN, "Main Page");
				$site_scout_link = Title::makeTitle(NS_SPECIAL, "SiteScout");
				$move = Title::makeTitle(NS_SPECIAL,"Movepage");
				$upload_file = Title::makeTitle(NS_SPECIAL,"Upload");
				$what_links_here = Title::makeTitle(NS_SPECIAL,"Whatlinkshere");
				$full_title = Title::makeTitle( $wgTitle->getNameSpace(), $wgTitle->getText() );
				$main_title = Title::makeTitle( NS_MAIN, $wgTitle->getText() );
				$preferences_link = Title::makeTitle (NS_SPECIAL, "Preferences");
				$watchlist_link = Title::makeTitle (NS_SPECIAL, "Watchlist");


				$output .= "

				<div id=\"navigation\">
					<div id=\"navigation-title\">
						Navigation
					</div>";
					$output .= '<script type="text/javascript">var submenu_array = new Array();var menuitem_array = new Array();var submenuitem_array = new Array();</script>';
					$this->navmenu_array = array();
					$this->navmenu = $this->getNavigationMenu();
					$output .= $this->printMenu(0);
				$output .= "
					<div id=\"other-links-container\">
						<div id=\"other-links\">
							<a href=\"".$top_fans_link->escapeFullURL()."\">Top Users</a>
							<a href=\"".$recent_changes_link->escapeFullURL()."\">Recent Changes</a>
							<div class=\"cleared\"></div>";
							if ($wgUser->isLoggedIn()) {
								$output .= "<a href=\"".$watchlist_link->escapeFullURL()."\">Watchlist</a>
								<a href=\"".$preferences_link->escapeFullURL()."\">Preferences</a>
								<div class=\"cleared\"></div>";
							}
							$output .= "<a href=\"".$help_link->escapeFullURL()."\">Help</a>
							<a href=\"".$special_pages_link->escapeFullURL()."\">Special Pages</a>
							<div class=\"cleared\"></div>
						</div>
					</div>
				</div>";


				$output .= "<div id=\"search-box\">
					<div id=\"search-title\">
						Search
					</div>
					".$this->searchForm();

					$output .= '<div class="gamespot-container">
						<div class="gamespot-header"><a href="http://www.gamespot.com"><img src="http://images.wikia.com/common/skins/quartz/gamespot/images/gamespot_logo_box.gif"/></a> updates</div>';

						//HARDCODE IN GAMESPOT PARTNER NAME
						$wgPartnerWikiName = "halo";
						$wgPartnerWikiData['feed-more'] = "http://www.gamespot.com/xbox360/action/halo3/news.html?mode=all&om_act=convert&om_clk=gsupdates&tag=updates;all";

						$key  =  wfMemcKey('widget:gamespot:feed', $wgPartnerWikiName);
						$data = $wgMemc->get($key);
						//$wgMemc->delete($key);
						wfDebug(sprintf("Gamespot widget: from cache: %s\n", print_r($data, true)));

						if (empty($data)){
							global $wgPartnerWikiData;

							//HARD CODE IN GAMESPOT FEED
							$wgPartnerWikiData["feed"] = "http://feeds.gamespot.com/feeds/wikia.php?hud=wikia&name=halo";

							if (!empty($wgPartnerWikiData['feed'])){

								$url = $wgPartnerWikiData['feed'];
								$ch = curl_init();
								curl_setopt_array($ch, array(
									CURLOPT_HEADER         => false,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_URL            => $url,
								));
								$data = curl_exec($ch);
								wfDebug(sprintf("Gamespot Widget: gs feed: %s\n", $data));

								$data = $this->parseGamespotFeed($data);
								wfDebug(sprintf("Gamespot Widget: parsed feed: %s\n", print_r($data, true)));
							}

							$wgMemc->add($key, $data, 60 * 15);
						}
						$output .= "<ul>";

						if (!count($data)){
							$output .= "no updates available";
						}else{
							$i = 0;
							foreach ($data as $row){
								$output .= "<li>";
								$output .= "<a href=\"" . htmlspecialchars($row['gs_story_link']) . "\" title=\"" . htmlspecialchars($row['headline']) . "\">" . str_replace(array('&lt;', '&gt;', '&amp;'), array('<', '>', '&'), $row['headline']) . "</a>";

								if (0 == $i){
									$output .= "<div class=\"gamespot-text\">" . htmlspecialchars($row['deck']) . "</div>";
									$output .= "<div class=\"gamespot-date\">";
									$output .= wfTimestamp(TS_RFC2822, $row['post_date']);
									$output .= "</div>";
								}
								$i++;
								$output .= "</li>";
							}

						}
						$output .= "</ul>";
						$more = $wgPartnerWikiData['feed-more'];
						if (!empty($more)){
							$output .= "<div class=\"gamespot-more\"><a href=\"{$more}\">See more GameSpot Updates &raquo;</a></div>";
						}

					$output .= "</div>
					<div class=\"bottom-left-nav\">";

						if ($wgTitle->getNamespace() == NS_BLOG) {

							global $wgBlogCategory;
							require_once ("$IP/extensions/wikia/ListPages/ListPagesClass.php");

							$output .= '<div class="bottom-left-nav-container bottom-left-listpage-fix">';
								$output .= '<h2>Popular Blog Posts</h2>';

								$list = new ListPages();
								$list->setCategory("News, {$wgBlogCategory},Questions");
								$list->setShowCount(10);
								$list->setOrder("New");
								$list->setShowPublished("NO");
								$list->setBool("ShowVoteBox","NO");
								$list->setBool("ShowDate","NO");
								$list->setBool("ShowStats","NO");
								$list->setBool("ShowNav","NO");
								$output .= $list->DisplayList();

							$output .= '</div>
							<div class="bottom-left-nav-container bottom-left-listpage-fix">';

								$output .= '<h2>New Blog Posts</h2>';
								$list = new ListPages();
								$list->setCategory("News, {$wgBlogCategory},Questions");
								$list->setShowCount(10);
								$list->setOrder("PublishedDate");
								$list->setShowPublished("YES");
								$list->setBool("ShowVoteBox","NO");
								$list->setBool("ShowDate","NO");
								$list->setBool("ShowStats","NO");
								$list->setBool("ShowNav","NO");
								$output .= $list->DisplayList();


							$output .= '</div>';
						}

						if ($wgTitle->getNamespace() == NS_COMMENT_FORUM) {

							global $wgForumCategory;
							require_once ("$IP/extensions/wikia/ListPages/ListPagesClass.php");

							$output .= '<div class="bottom-left-nav-container bottom-left-listpage-fix">';

								$output .= '<h2>New Forum Topics</h2>';
								$list = new ListPages();
								$list->setCategory("{$wgForumCategory}");
								$list->setShowCount(5);
								$list->setOrder("NEW");
								$list->setShowPublished("NO");
								$list->setBool("ShowVoteBox","NO");
								$list->setBool("ShowDate","NO");
								$list->setBool("ShowStats","NO");
								$list->setBool("ShowNav","NO");
								$output .= $list->DisplayList();

							$output .= '</div>';

							$output .= "<h2>latest top forum comments<h2>";
							$output .= ForumPage::getCommentsOfTheDay();

						}

						$output .=	wfGetRandomGameUnit();

						$output .= "<div class=\"bottom-left-nav-container\">
							<h2>Did You Know</h2>
							".$wgOut->parse("{{Didyouknow}}")."
						</div>";

						$random_image = $wgOut->parse("<randomimagebycategory width=\"200\" categories=\"Featured Image\"></randomimagebycategory>", false);

						if( $random_image ){
							$output .= "<div class=\"bottom-left-nav-container\">
								<h2>Featured Image</h2>
								{$random_image}
							</div>";
						}

						$random_user = $wgOut->parse("<randomfeatureduser period=\"weekly\"></randomfeatureduser>", false);

						if( $random_user ){
							$output .= "<div class=\"bottom-left-nav-container\">
								<h2>Featured User</h2>
								{$random_user}
							</div>";
						}


					$output .= "</div>
				</div>
			</div>
			<div id=\"body-container\">";



						$site_notice = wfGetSiteNotice();
						if( $site_notice){
							$site_notice_html = "<div id=\"siteNotice\">{$site_notice}</div>";
						}

						$output .= $this->actionBar()."

						<div id=\"article\">

							<div id=\"article-body\">

							{$site_notice_html}

								<div id=\"article-text\" class=\"clearfix\">";

								if( !$wgSupressPageTitle ){
									$output .= $this->pageTitle();
								}
								if( $this->isContent() &&  !$wgSupressSubTitle){
									$output .= $this->pageSubtitle();
								}



			  		return $output;


	}


	 function doAfterContent() {

		global $wgOut, $wgUser, $wgTitle, $wgSupressPageCategories;

					if( !$wgSupressPageCategories ){
						$cat=$this->getCategoryLinks();
						if($cat){
							$output.="
							<div id=\"catlinks\">
								$cat
							</div>";
						}
					}

					$output .= "</div>
					</div>
			</div>
			{$this->footer()}
		</div>";

		return $output;


	 }

	function footer() {

		global $IP, $wgUser, $wgTitle, $wgOut,$wgUploadPath, $wgMemc, $wgSitename;

		$title = Title::makeTitle($wgTitle->getNamespace(),$wgTitle->getText());
		$page_title_id = $wgTitle->getArticleID();
		$main_page = Title::makeTitle(NS_MAIN,"Main Page");
		$about = Title::makeTitle(NS_MAIN,"About");
		$special = Title::makeTitle(NS_SPECIAL,"Specialpages");
		$help = Title::makeTitle(NS_MAIN,"UserRegister");

		$footer_show = array(NS_VIDEO,NS_MAIN,NS_IMAGE);

		//edit button
		if (in_array($wgTitle->getNamespace(), $footer_show) && ($wgTitle->getText()!="Main Page")) {

			$key = wfMemcKey( 'recenteditors', 'list', $page_title_id );
			$data = $wgMemc->get( $key );
			$editors = array();

			if(!$data ) {

				wfDebug( "loading recent editors for page {$page_title_id} from db\n" );

				$dbr =& wfGetDB( DB_MASTER );
				$sql = "SELECT DISTINCT rev_user, rev_user_text FROM revision WHERE rev_page = {$page_title_id} and rev_user <> 0 and rev_user_text<>'Mediawiki Default' and rev_user_text<>'MLB Stats Bot' ORDER BY rev_user_text ASC LIMIT 0,8";
				$res = $dbr->query($sql);

				while ($row = $dbr->fetchObject( $res ) ) {
					$editors[] = array( "user_id" => $row->rev_user, "user_name" => $row->rev_user_text);
				}

				$wgMemc->set( $key, $editors, 60 * 5 );

			} else {
				wfDebug( "loading recent editors for page {$page_title_id} from cache\n" );
				$editors = $data;
			}

			$x=1;
			$per_row=4;

			if (count($editors)>0) {

				$footer .= "<div id=\"footer-container\" class=\"clearfix\">
					<div id=\"footer-actions\">
						<h2>Contribute</h2>
						<p>
							{$wgSitename}'s pages can be edited.<br/>
							Is this page incomplete?  Is there anything wrong?<br/>
							<b>Change it!</b>
						</p>
						<a href=\"".$title->escapeFullURL( $this->editUrlOptions() )."\" rel=\"nofollow\" class=\"edit-action\">Edit this page</a>
						<a href=\"".$title->getTalkPage()->escapeFullURL()."\" rel=\"nofollow\" class=\"discuss-action\">Discuss this page</a>
						<a href=\"".$title->escapeFullURL('action=history')."\" rel=\"nofollow\" class=\"page-history-action\">Page history</a>";
					$footer.="</div>
					<div id=\"footer-contributors\">
						<h2>Recent contributors to this page</h2>
						<p>
							The following people recently contributed to this article.
						</p>";

						foreach($editors as $editor) {

							$avatar = new wAvatar($editor["user_id"],"m");
							$user_title = Title::makeTitle(NS_USER,$editor["user_name"]);

							$footer .= "<a href=\"{$user_title->escapeFullURL()}\" rel=\"nofollow\"><img src=\"/images/avatars/{$avatar->getAvatarImage()}\" alt=\"\" border=\"0\"/></a>";

							if($x==count($editors) || $x!=1 && $x%$per_row ==0) {
								$footer .= "<br/>";
							}

							$x++;
						}

						$footer .= "<div class=\"editor-spacer\"></div>
					</div>
					<div class=\"cleared\"></div>
				</div>";

			}
		}

		$footer .= "<div id=\"footer-bottom\">
			<a href=\"{$main_page->escapeLocalURL()}\" rel=\"nofollow\">Main Page</a>
			<a href=\"{$about->escapeLocalURL()}\" rel=\"nofollow\">About</a>
			<a href=\"{$special->escapeLocalURL()}\" rel=\"nofollow\">Special Pages</a>
			<a href=\"{$help->escapeLocalURL()}\" rel=\"nofollow\">Help</a>
			<a href=\"http://www.wikia.com/wiki/Terms_of_use\" rel=\"nofollow\">Terms of Use</a>
			<a href=\"http://www.federatedmedia.net/authors/wikia\" rel=\"nofollow\">Advertise</a>
		</div>";

		return $footer;
	}

}

?>
