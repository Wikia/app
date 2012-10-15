<?php
/**
 * Notes:
 * Template:Didyouknow is a part of the interface (=should be fully protected on the wiki)
 * If SocialProfile extension (+some other social extensions) is available,
 * then more stuff will appear in the skin interface
 *
 * Feel free to improve source code documentation as you like,
 * it's in a really crappy state currently, but better than nothing.
 *
 * @file
 */
if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @ingroup Skins
 */
class SkinNimbus extends SkinTemplate {
	var $skinname = 'nimbus', $stylename = 'nimbus',
		$template = 'NimbusTemplate', $useHeadElement = true;

	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		// Add CSS & JS
		$out->addModuleStyles( array( 'skins.nimbus', 'skins.monobook' ) );
		$out->addModuleScripts( 'skins.nimbus' );
	}
}

/**
 * Main skin class.
 * @ingroup Skins
 */
class NimbusTemplate extends BaseTemplate {
	/**
	 * @var Skin
	 */
	var $skin;

	/**
	 * Template filter callback for Nimbus skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 */
	public function execute() {
		global $wgContLang, $wgLogo, $wgOut, $wgStylePath, $wgTitle, $wgUser;
		global $wgLangToCentralMap, $wgSupressPageTitle, $wgSupressSubTitle, $wgSupressPageCategories;
		global $wgUserLevels;

		$this->skin = $this->data['skin'];

		// This trick copied over from Monaco.php to allow localized central wiki URLs
		$central_url = !empty( $wgLangToCentralMap[$wgContLang->getCode()] ) ?
						$wgLangToCentralMap[$wgContLang->getCode()] :
						'http://www.shoutwiki.com/';

		$register_link = SpecialPage::getTitleFor( 'Userlogin', 'signup' );
		$login_link = SpecialPage::getTitleFor( 'Userlogin' );
		$logout_link = SpecialPage::getTitleFor( 'Userlogout' );
		$profile_link = Title::makeTitle( NS_USER, $wgUser->getName() );
		$main_page_link = Title::newMainPage();
		$recent_changes_link = SpecialPage::getTitleFor( 'Recentchanges' );
		$top_fans_link = SpecialPage::getTitleFor( 'TopUsers' );
		$special_pages_link = SpecialPage::getTitleFor( 'Specialpages' );
		$help_link = Title::newFromText( wfMsgForContent( 'helppage' ) );
		$upload_file = SpecialPage::getTitleFor( 'Upload' );
		$what_links_here = SpecialPage::getTitleFor( 'Whatlinkshere' );
		$preferences_link = SpecialPage::getTitleFor( 'Preferences' );
		$watchlist_link = SpecialPage::getTitleFor( 'Watchlist' );

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		$this->html( 'headelement' );
?><div id="container">
	<div id="header">
		<div id="sw-logo">
			<a href="<?php echo $central_url ?>">
				<img src="<?php echo $wgStylePath ?>/Nimbus/nimbus/sw_logo.png" alt="" />
			</a>
			<span id="sw-category">ShoutWiki</span>
		</div>
		<div id="sw-more-category">
			<div class="positive-button"><span><?php echo wfMsg( 'nimbus-more-wikis' ) ?></span></div>
		</div>
		<div id="more-wikis-menu" style="display:none;">
		<?php
		$more_wikis = $this->buildMoreWikis();

		$x = 1;
		foreach( $more_wikis as $link ) {
			$ourClass = '';
			if ( $x == count( $more_wikis ) ) {
				$ourClass = ' class="border-fix"';
			}
			echo "<a href=\"{$link['href']}\"" . $ourClass .
				">{$link['text']}</a>\n";
			if ( $x > 1 && $x % 2 == 0 ) {
				echo '<div class="cleared"></div>' . "\n";
			}
			$x++;
		}
		?>
		</div><!-- #more-wikis-menu -->
		<div id="wiki-login">
<?php
	if ( $wgUser->isLoggedIn() ) {
		echo '<div id="login-message">' .
				wfMsg( 'nimbus-welcome', '<b>' . $wgUser->getName() . '</b>' ) .
			'</div>
			<a class="positive-button" href="' . $profile_link->escapeFullURL() . '" rel="nofollow"><span>' . wfMsg( 'nimbus-profile' ) . '</span></a>
			<a class="negative-button" href="' . $logout_link->escapeFullURL() . '"><span>' . wfMsg( 'nimbus-logout' ) . '</span></a>';
	} else {
		echo '<a class="positive-button" href="' . $register_link->escapeFullURL() . '" rel="nofollow"><span>' . wfMsg( 'nimbus-signup' ) . '</span></a>
		<a class="positive-button" href="' . $login_link->escapeFullURL() . '" id="nimbusLoginButton"><span>' . wfMsg( 'nimbus-login' ) . '</span></a>';
	}
?>
		</div><!-- #wiki-login -->
	</div><!-- #header -->
	<div id="site-header">
		<div id="site-logo">
			<a href="<?php echo $main_page_link->escapeFullURL() ?>" rel="nofollow">
				<img src="<?php echo $wgLogo ?>" alt="" />
			</a>
		</div>
	</div>
	<div id="side-bar">
		<div id="navigation">
			<div id="navigation-title"><?php echo wfMsg( 'navigation' ) ?></div>
			<script type="text/javascript">
				var submenu_array = new Array();
				var menuitem_array = new Array();
				var submenuitem_array = new Array();
			</script>
			<?php
				$this->navmenu_array = array();
				$this->navmenu = $this->getNavigationMenu();
				echo $this->printMenu( 0 );
			?>
			<div id="other-links-container">
				<div id="other-links">
				<?php
					// Only show the link to Special:TopUsers if wAvatar class exists and $wgUserLevels is an array
					if ( class_exists( 'wAvatar' ) && is_array( $wgUserLevels ) ) {
						echo '<a href="' . $top_fans_link->escapeFullURL() . '">' . wfMsg( 'topusers' ) . '</a>';
					}
				?>
					<a href="<?php echo $recent_changes_link->escapeFullURL() ?>"><?php echo wfMsg( 'recentchanges' ) ?></a>
					<div class="cleared"></div>
					<?php if ( $wgUser->isLoggedIn() ) { ?>
					<a href="<?php echo $watchlist_link->escapeFullURL() ?>"><?php echo wfMsg( 'watchlist' ) ?></a>
					<a href="<?php echo $preferences_link->escapeFullURL() ?>"><?php echo wfMsg( 'preferences' ) ?></a>
					<div class="cleared"></div>
					<?php } ?>
					<a href="<?php echo $help_link->escapeFullURL() ?>"><?php echo wfMsg( 'help' ) ?></a>
					<a href="<?php echo $special_pages_link->escapeFullURL() ?>"><?php echo wfMsg( 'specialpages' ) ?></a>
					<div class="cleared"></div>
				</div>
			</div>
		</div>
		<div id="search-box">
			<div id="search-title"><?php echo wfMsg( 'search' ) ?></div>
			<form method="get" action="<?php echo $this->text( 'wgScript' ) ?>" name="search_form" id="searchform">
				<input id="searchInput" type="text" class="search-field" name="search" value="<?php echo wfMsg( 'nimbus-search' ) ?>" onclick="this.value=''" />
				<input type="image" src="<?php echo $wgStylePath ?>/Nimbus/nimbus/search_button.gif" class="search-button" alt="search" />
			</form>
			<div class="cleared"></div>
			<div class="bottom-left-nav">
			<?php
			if( function_exists( 'wfRandomCasualGame' ) ) {
				echo wfGetRandomGameUnit();
			}
			?>
				<div class="bottom-left-nav-container">
					<h2><?php echo wfMsg( 'nimbus-didyouknow' ) ?></h2>
					<?php echo $wgOut->parse( '{{Didyouknow}}' ) ?>
				</div>
			<?php
				if( function_exists( 'wfRandomImageByCategory' ) ) {
					$randomImage = $wgOut->parse(
						'<randomimagebycategory width="200" categories="Featured Image" />',
						false
					);
					echo '<div class="bottom-left-nav-container">
					<h2>' . wfMsg( 'nimbus-featuredimage' ) . '</h2>' .
					$randomImage . '</div>';
				}

				if( function_exists( 'wfRandomFeaturedUser' ) ) {
					$randomUser = $wgOut->parse(
						'<randomfeatureduser period="weekly" />',
						false
					);
					echo '<div class="bottom-left-nav-container">
						<h2>' . wfMsg( 'nimbus-featureduser' ) . '</h2>' .
						$randomUser . '</div>';
				}
			?>
			</div>
		</div>
	</div>
	<div id="body-container">
		<?php echo $this->actionBar(); ?>
		<div id="article">
			<div id="mw-js-message" style="display:none;"></div>

			<div id="article-body">
				<?php if( $this->data['sitenotice'] ) { ?><div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div><?php } ?>
				<div id="article-text" class="clearfix">
					<?php if( !$wgSupressPageTitle ) { ?><h1 class="pagetitle"><?php $this->html( 'title' ) ?></h1><?php } ?>
					<?php if( !$wgSupressSubTitle ) { ?><p class='subtitle'><?php $this->msg( 'tagline' ) ?></p><?php } ?>
					<?php if( $this->data['undelete'] ) { ?><div id="contentSub2"><?php $this->html( 'undelete' ) ?></div><?php } ?>
					<?php if( $this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html( 'newtalk' ) ?></div><?php } ?>
					<!-- start content -->
					<?php $this->html( 'bodytext' ) ?>
					<?php if( $this->data['printfooter'] ) { ?><div class="printfooter"><?php $this->html( 'printfooter' ); ?></div><?php } ?>
					<?php $this->html( 'debughtml' ); ?>
					<?php if( $this->data['catlinks'] && !$wgSupressPageCategories ) { $this->html( 'catlinks' ); } ?>
					<!-- end content -->
					<?php if( $this->data['dataAfterContent'] ) { $this->html( 'dataAfterContent' ); } ?>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->footer(); ?>
</div><!-- #container -->
<?php
		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
		wfRestoreWarnings();
	} // end of execute() method

	/**
	 * Parse MediaWiki-style messages called 'v3sidebar' to array of links,
	 * saving hierarchy structure.
	 * Message parsing is limited to first 150 lines only.
	 */
	private function getNavigationMenu() {
		$message_key = 'sidebar';
		$message = trim( wfMsg( $message_key ) );

		if( wfEmptyMsg( $message_key, $message ) ) {
			return array();
		}

		$lines = array_slice( explode( "\n", $message ), 0, 150 );

		if( count( $lines ) == 0 ) {
			return array();
		}

		$nodes = array();
		$nodes[] = array();
		$lastDepth = 0;
		$i = 0;
		foreach( $lines as $line ) {
			# ignore empty lines
			if( strlen( $line ) == 0 ) {
				continue;
			}

			$node = $this->parseItem( $line );
			$node['depth'] = strrpos( $line, '*' ) + 1;

			if( $node['depth'] == $lastDepth ) {
				$node['parentIndex'] = $nodes[$i]['parentIndex'];
			} elseif( $node['depth'] == $lastDepth + 1 ) {
				$node['parentIndex'] = $i;
			} elseif(
				// ignore crap that works on Monobook, but not on other skins
				$node['text'] == 'SEARCH' ||
				$node['text'] == 'TOOLBOX' ||
				$node['text'] == 'LANGUAGES'
			)
			{
				continue;
			} else {
				for( $x = $i; $x >= 0; $x-- ) {
					if( $x == 0 ) {
						$node['parentIndex'] = 0;
						break;
					}
					if( $nodes[$x]['depth'] == $node['depth'] - 1 ) {
						$node['parentIndex'] = $x;
						break;
					}
				}
			}

			$nodes[$i + 1] = $node;
			$nodes[$node['parentIndex']]['children'][] = $i+1;
			$lastDepth = $node['depth'];
			$i++;
		}
		return $nodes;
	}

	/**
	 * Parse one line form MediaWiki-style message as array of 'text' and 'href'
	 */
	private function parseItem( $line ) {
		$line_temp = explode( '|', trim( $line, '* ' ), 2 );
		if( count( $line_temp ) > 1 ) {
			$line = $line_temp[1];
			$link = wfMsgForContent( $line_temp[0] );
		} else {
			$line = $line_temp[0];
			$link = $line_temp[0];
		}

		if( wfEmptyMsg( $line, $text = wfMsg( $line ) ) ) {
			$text = $line;
		}

		if( $link != null ) {
			if( wfEmptyMsg( $line_temp[0], $link ) ) {
				$link = $line_temp[0];
			}
			if ( preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link ) ) {
				$href = $link;
			} else {
				$title = Title::newFromText( $link );
				if( $title ) {
					$title = $title->fixSpecialName();
					$href = $title->getLocalURL();
				} else {
					$href = '#';
				}
			}
		}
		return array( 'text' => $text, 'href' => $href );
	}

	/**
	 * Generate and return "More Wikis" menu, showing links to related wikis.
	 *
	 * @return Array: "More Wikis" menu
	 */
	private function buildMoreWikis() {
		$messageKey = 'morewikis';
		$message = trim( wfMsg( $messageKey ) );

		if( wfEmptyMsg( $messageKey, $message ) ) {
			return array();
		}

		$lines = array_slice( explode( "\n", $message ), 0, 150 );

		if( count( $lines ) == 0 ) {
			return array();
		}

		foreach( $lines as $line ) {
			$moreWikis[] = $this->parseItem( $line );
		}

		return $moreWikis;
	}

	/**
	 * Prints the sidebar menu & all necessary JS
	 */
	private function printMenu( $id, $last_count = '', $level = 0 ) {
		global $wgContLang, $wgStylePath;

		$menu_output = '';
		$script_output = '';
		$output = '';
		$count = 1;

		if( isset( $this->navmenu[$id]['children'] ) ) {
			$script_output .= '<script type="text/javascript">/*<![CDATA[*/';
			if ( $level ) {
				$menu_output .= '<div class="sub-menu" id="sub-menu' . $last_count . '" style="display:none;">';
				$script_output .= 'submenu_array["sub-menu' . $last_count . '"] = "' . $last_count . '";' . "\n";
				$script_output .= 'document.getElementById("sub-menu' . $last_count . '").onmouseout = NimbusSkin.clearMenu;' . "\n";
				$script_output .= 'if( document.getElementById("sub-menu' . $last_count . '").captureEvents ) document.getElementById("sub-menu' . $last_count . '").captureEvents(Event.MOUSEOUT);' . "\n";
			}
			foreach( $this->navmenu[$id]['children'] as $child ) {
				$mouseover = ' onmouseover="NimbusSkin.' . ( $level ? 'sub_' : '' ) . 'menuItemAction(\'' .
					( $level ? $last_count . '_' : '_' ) . $count . '\');"';
				$mouseout = ' onmouseout="NimbusSkin.clearBackground(\'_' . $count . '\')"' . "\n";
				$menu_output .= '<div class="' . ( $level ? 'sub-' : '' ) . 'menu-item' .
					( ( $count == sizeof( $this->navmenu[$id]['children'] ) ) ? ' border-fix' : '' ) .
					'" id="' . ( $level ? 'sub-' : '' ) . 'menu-item' .
						( $level ? $last_count . '_' : '_' ) . $count . '">';
				$menu_output .= '<a id="' . ( $level ? 'a-sub-' : 'a-' ) . 'menu-item' .
					( $level ? $last_count . '_' : '_' ) . $count . '" href="' .
					( !empty( $this->navmenu[$child]['href'] ) ? htmlspecialchars( $this->navmenu[$child]['href'] ) : '#' ) . '">';

				if( !$level ) {
					$script_output .= 'menuitem_array["menu-item' . $last_count . '_' . $count . '"] = "' . $last_count . '_' . $count . '";';
					$script_output .= 'document.getElementById("menu-item' . $last_count . '_' . $count . '").onmouseover = NimbusSkin.menuItemAction;' . "\n";
					$script_output .= 'if( document.getElementById("menu-item' . $last_count . '_' .$count . '").captureEvents) document.getElementById("menu-item' . $last_count . '_' . $count . '").captureEvents(Event.MOUSEOVER);' . "\n";
					$script_output .= 'document.getElementById("menu-item' . $last_count . '_' . $count . '").onmouseout = NimbusSkin.clearBackground;' . "\n";
					$script_output .= 'if( document.getElementById("menu-item' . $last_count . '_' . $count . '").captureEvents) document.getElementById("menu-item' . $last_count . '_' . $count . '").captureEvents(Event.MOUSEOUT);' . "\n";

					$script_output .= 'document.getElementById("a-menu-item' . $last_count . '_' . $count . '").onmouseover = NimbusSkin.menuItemAction;if( document.getElementById("a-menu-item' . $last_count . '_' . $count . '").captureEvents) document.getElementById("a-menu-item' . $last_count . '_' . $count . '").captureEvents(Event.MOUSEOVER);' . "\n";
				} else {
					$script_output .= 'submenuitem_array["sub-menu-item' . $last_count . '_' . $count . '"] = "' . $last_count . '_' . $count . '";';
					$script_output .= 'document.getElementById("sub-menu-item' . $last_count . '_' . $count . '").onmouseover = NimbusSkin.sub_menuItemAction;' . "\n";
					$script_output .= 'if( document.getElementById("sub-menu-item' . $last_count . '_' . $count . '").captureEvents) document.getElementById("sub-menu-item' . $last_count . '_' . $count . '").captureEvents(Event.MOUSEOVER);' . "\n";
				}
				$menu_output .= $this->navmenu[$child]['text'];
				// If a menu item has submenus, show an arrow so that the user
				// knows that there are submenus available
				if( sizeof( $this->navmenu[$child]['children'] ) ) {
					$menu_output .= '<img src="' . $wgStylePath . '/Nimbus/nimbus/right_arrow' .
						( $wgContLang->isRTL() ? '_rtl' : '' ) .
						'.gif" alt="" class="sub-menu-button" />';
				}
				$menu_output .= '</a>';
				//$menu_output .= $id . ' ' . sizeof( $this->navmenu[$child]['children'] ) . ' ' . $child . ' ';
				$menu_output .= $this->printMenu( $child, $last_count . '_' . $count, $level + 1 );
				//$menu_output .= 'last';
				$menu_output .= '</div>';
				$count++;
			}
			if ( $level ) {
				$menu_output .= '</div>';
			}
			$script_output .= '/*]]>*/</script>';
		}

		if ( $menu_output . $script_output != '' ) {
			$output .= "<div id=\"menu{$last_count}\">";
			$output .= $menu_output . $script_output;
			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Do some tab-related magic
	 *
	 * @param $title Object: instance of Title class
	 * @param $message String: name of a MediaWiki: message
	 * @param $selected Boolean?
	 * @param $query String: empty by default, but if not empty, query to append (such as action=edit)
	 * @param $checkEdit Boolean: false by default
	 *
	 * @return array
	 */
	function tabAction( $title, $message, $selected, $query = '', $checkEdit = false ) {
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
			$text = $wgContLang->getFormattedNsText(
				MWNamespace::getSubject( $title->getNamespace() )
			);
		}

		return array(
			'class' => implode( ' ', $classes ),
			'text' => $text,
			'href' => $title->getLocalURL( $query )
		);
	}

	function buildActionBar() {
		global $wgRequest, $wgTitle, $wgOut, $wgUser;

		$action = $wgRequest->getText( 'action' );
		$section = $wgRequest->getText( 'section' );
		$content_actions = array();

		if( $wgTitle->getNamespace() != NS_SPECIAL ) {
			$subjpage = $wgTitle->getSubjectPage();
			$talkpage = $wgTitle->getTalkPage();
			$nskey = $wgTitle->getNamespaceKey();
			$prevent_active_tabs = ''; // Prevent E_NOTICE ;-)

			$content_actions[$nskey] = $this->tabAction(
				$subjpage,
				$nskey,
				!$wgTitle->isTalkPage() && !$prevent_active_tabs,
				'',
				true
			);

			$content_actions['talk'] = $this->tabAction(
				$talkpage,
				'talk',
				$wgTitle->isTalkPage() && !$prevent_active_tabs,
				'',
				true
			);

			if ( $wgTitle->quickUserCan( 'edit' ) && ( $wgTitle->exists() || $wgTitle->quickUserCan( 'create' ) ) ) {
				$isTalk = $wgTitle->isTalkPage();
				$isTalkClass = $isTalk ? ' istalk' : '';

				$content_actions['edit'] = array(
					'class' => ( ( ( $action == 'edit' || $action == 'submit' ) && $section != 'new' ) ? 'selected' : '' ) . $isTalkClass,
					'text' => wfMsg( 'edit' ),
					'href' => $wgTitle->getLocalURL( $this->skin->editUrlOptions() )
				);

				if ( $isTalk || $wgOut->showNewSectionLink() ) {
					$content_actions['addsection'] = array(
						'class' => $section == 'new' ? 'selected' : false,
						'text' => wfMsg( 'addsection' ),
						'href' => $wgTitle->getLocalURL( 'action=edit&section=new' )
					);
				}
			} else {
				$content_actions['viewsource'] = array(
					'class' => ( $action == 'edit' ) ? 'selected' : false,
					'text' => wfMsg( 'viewsource' ),
					'href' => $wgTitle->getLocalURL( $this->skin->editUrlOptions() )
				);
			}

			if ( $wgTitle->getArticleId() ) {
				$content_actions['history'] = array(
					'class' => ( $action == 'history' ) ? 'selected' : false,
					'text' => wfMsg( 'history_short' ),
					'href' => $wgTitle->getLocalURL( 'action=history' )
				);

				if ( $wgTitle->getNamespace() !== NS_MEDIAWIKI && $wgUser->isAllowed( 'protect' ) ) {
					if( !$wgTitle->isProtected() ) {
						$content_actions['protect'] = array(
							'class' => ( $action == 'protect' ) ? 'selected' : false,
							'text' => wfMsg( 'protect' ),
							'href' => $wgTitle->getLocalURL( 'action=protect' )
						);

					} else {
						$content_actions['unprotect'] = array(
							'class' => ( $action == 'unprotect' ) ? 'selected' : false,
							'text' => wfMsg( 'unprotect' ),
							'href' => $wgTitle->getLocalURL( 'action=unprotect' )
						);
					}
				}
				if( $wgUser->isAllowed( 'delete' ) ) {
					$content_actions['delete'] = array(
						'class' => ( $action == 'delete' ) ? 'selected' : false,
						'text' => wfMsg( 'delete' ),
						'href' => $wgTitle->getLocalURL( 'action=delete' )
					);
				}
				if ( $wgTitle->quickUserCan( 'move' ) ) {
					$moveTitle = SpecialPage::getTitleFor( 'Movepage', $wgTitle->getPrefixedDBkey() );
					$content_actions['move'] = array(
						'class' => $wgTitle->isSpecial( 'Movepage' ) ? 'selected' : false,
						'text' => wfMsg( 'move' ),
						'href' => $moveTitle->getLocalURL()
					);
				}

				$whatlinkshereTitle = SpecialPage::getTitleFor( 'Whatlinkshere', $wgTitle->getPrefixedDBkey() );
				$content_actions['whatlinkshere'] = array(
					'class' => $wgTitle->isSpecial( 'Whatlinkshere' ) ? 'selected' : false,
					'text' => wfMsg( 'whatlinkshere' ),
					'href' => $whatlinkshereTitle->getLocalURL()
				);

			} else {
				// Article doesn't exist or is deleted
				if( $wgUser->isAllowed( 'delete' ) ) {
					if( $n = $wgTitle->isDeleted() ) {
						$undelTitle = SpecialPage::getTitleFor( 'Undelete' );
						$content_actions['undelete'] = array(
							'class' => false,
							'text' => wfMsgExt( 'undelete_short', array( 'parsemag' ), $n ),
							'href' => $undelTitle->getLocalURL( 'target=' . urlencode( $wgTitle->getPrefixedDBkey() ) )
							#'href' => self::makeSpecialUrl( "Undelete/$this->thispage" )
						);
					}
				}
			}
		} else {
			/* show special page tab */
			if( $wgTitle->isSpecial( 'QuizGameHome' ) && $wgRequest->getVal( 'questionGameAction' ) == 'editItem' ) {
				global $wgQuizID;
				$quiz = SpecialPage::getTitleFor( 'QuizGameHome' );
				$content_actions[$wgTitle->getNamespaceKey()] = array(
					'class' => 'selected',
					'text' => wfMsg( 'nstab-special' ),
					'href' => $quiz->getFullURL( 'questionGameAction=renderPermalink&permalinkID=' . $wgQuizID ),
				);
			} else {
				$content_actions[$wgTitle->getNamespaceKey()] = array(
					'class' => 'selected',
					'text' => wfMsg( 'nstab-special' ),
					'href' => $wgRequest->getRequestURL(), // @bug 2457, 2510
				);
			}

			if( $wgTitle->isSpecial( 'QuizGameHome' ) && $wgUser->isAllowed( 'quizgameadmin' ) ) {
				global $wgQuizID;
				$quiz = SpecialPage::getTitleFor( 'QuizGameHome' );
				$content_actions['edit'] = array(
					'class' => ( $wgRequest->getVal( 'questionGameAction' ) == 'editItem' ) ? 'selected' : false,
					'text' => wfMsg( 'edit' ),
					'href' => $quiz->getFullURL( 'questionGameAction=editItem&quizGameId=' . $wgQuizID ), // @bug 2457, 2510
				);
			}
			if( $wgTitle->isSpecial( 'PictureGameHome' ) && $wgUser->isAllowed( 'picturegameadmin' ) ) {
				global $wgPictureGameID;
				$quiz = SpecialPage::getTitleFor( 'PictureGameHome' );
				$content_actions['edit'] = array(
					'class' => ( $wgRequest->getVal( 'picGameAction' ) == 'editPanel' ) ? 'selected' : false,
					'text' => wfMsg( 'edit' ),
					'href' => $quiz->getFullURL( 'picGameAction=editPanel&id=' . $wgPictureGameID ), // @bug 2457, 2510
				);
			}
		}

		return $content_actions;
	}

	/**
	 * Gets the links for the action bar (edit, talk etc.)
	 *
	 * @return array
	 */
	function getActionBarLinks() {
		global $wgTitle;

		$left = array(
			$wgTitle->getNamespaceKey(), 'edit', 'talk', 'viewsource',
			'addsection', 'history'
		);
		$actions = $this->buildActionBar();
		$moreLinks = null;

		foreach( $actions as $action => $value ) {
			if ( in_array( $action, $left ) ) {
				$leftLinks[$action] = $value;
			} else {
				$moreLinks[$action] = $value;
			}
		}

		return array( $leftLinks, $moreLinks );
	}

	/**
	 * Generates the actual action bar - watch/unwatch links for logged-in users,
	 * "More actions" menu that has some other tools (WhatLinksHere special page etc.)
	 *
	 * @return $output HTML for action bar
	 */
	function actionBar() {
		global $wgUser, $wgTitle, $wgStylePath;

		$full_title = Title::makeTitle( $wgTitle->getNamespace(), $wgTitle->getText() );

		$output = '<div id="action-bar">';
		// Watch/unwatch link for registered users on namespaces that can be
		// watched (i.e. everything but the Special: namespace)
		if ( $wgUser->isLoggedIn() && $wgTitle->getNamespace() != NS_SPECIAL ) {
			$output .= '<div id="article-controls">
				<img src="' . $wgStylePath . '/Nimbus/nimbus/plus.gif" alt="" />';

			// In 1.16, all we needed was the ID for AJAX page watching to work
			// In 1.18, we need the class *and* the title...w/o the title, the
			// new, jQuery-ified version of the AJAX page watching code dies
			// if the title attribute is not present
			if ( !$wgTitle->userIsWatching() ) {
				$output .= '<a id="ca-watch" class="mw-watchlink" href="' .
					$full_title->escapeFullURL( 'action=watch' ) . '" title="' .
						wfMsg( 'tooltip-ca-watch' ) . '">' .
					wfMsg( 'watch' ) .
				'</a>';
			} else {
				$output .= '<a id="ca-unwatch" class="mw-watchlink" href="' .
					$full_title->escapeFullURL( 'action=unwatch' ) . '" title="' .
						wfMsg( 'tooltip-ca-unwatch' ) . '">' .
					wfMsg( 'unwatch' ) .
				'</a>';
			}

			$output .= '</div>';
		}

		$output .= '<div id="article-tabs">';

		list( $leftLinks, $moreLinks ) = $this->getActionBarLinks();

		foreach( $leftLinks as $key => $val ) {
			$output .= '<a href="' . htmlspecialchars( $val['href'] ) . '" class="' .
				( ( strpos( $val['class'], 'selected' ) === 0 ) ? 'tab-on' : 'tab-off' ) .
				( strpos( $val['class'], 'new' ) && ( strpos( $val['class'], 'new' ) > 0 ) ? ' tab-new' : '' ) . '" rel="nofollow">
				<span>' . ucfirst( $val['text'] ) . '</span>
			</a>';
		}

		if ( count( $moreLinks ) > 0 ) {
			$output .= '<div class="more-tab-off" id="more-tab">
				<span>' . wfMsg( 'nimbus-more-actions' ) . '</span>';

			$output .= '<div class="article-more-actions" id="article-more-container" style="display:none">';

			$more_links_count = 1;

			foreach( $moreLinks as $key => $val ) {
				if ( count( $moreLinks ) == $more_links_count ) {
					$border_fix = ' class="border-fix"';
				} else {
					$border_fix = '';
				}

				$output .= '<a href="' . htmlspecialchars( $val['href'] ) .
					"\"{$border_fix} rel=\"nofollow\">" .
					ucfirst( $val['text'] ) .
				'</a>';

				$more_links_count++;
			}

			$output .= '</div>
			</div>';
		}

		$output .= '<div class="cleared"></div>
			</div>
		</div>';

		return $output;
	}

	/**
	 * Returns the footer for a page
	 *
	 * @return $footer The generated footer, including recent editors
	 */
	function footer() {
		global $wgMemc, $wgTitle, $wgUploadPath;

		$title = Title::makeTitle( $wgTitle->getNamespace(), $wgTitle->getText() );
		$pageTitleId = $wgTitle->getArticleID();
		$main_page = Title::newMainPage();
		$about = Title::makeTitle( wfMsgForContent( 'aboutpage' ) );
		$special = SpecialPage::getTitleFor( 'Specialpages' );
		$help = SpecialPage::getTitleFor( 'Userlogin', 'signup' );
		$disclaimerPage = Title::newFromText( wfMsgForContent( 'disclaimerpage' ) );

		$footerShow = array( NS_MAIN, NS_FILE );
		if ( defined( 'NS_VIDEO' ) ) {
			$footerShow[] = NS_VIDEO;
		}
		$footer = '';

		// Show the list of recent editors and their avatars if the page is in
		// one of the allowed namespaces and it is not the main page
		if(
			in_array( $wgTitle->getNamespace(), $footerShow ) &&
			( $pageTitleId != $main_page->getArticleID() )
		)
		{
			$key = wfMemcKey( 'recenteditors', 'list', $pageTitleId );
			$data = $wgMemc->get( $key );
			$editors = array();
			if( !$data ) {
				wfDebug( __METHOD__ . ": Loading recent editors for page {$pageTitleId} from DB\n" );
				$dbw = wfGetDB( DB_MASTER );
				$res = $dbw->select(
					'revision',
					array( 'DISTINCT rev_user', 'rev_user_text' ),
					array(
						'rev_page' => $pageTitleId,
						'rev_user <> 0',
						"rev_user_text <> 'MediaWiki default'"
					),
					__METHOD__,
					array( 'ORDER BY' => 'rev_user_text ASC', 'LIMIT' => 8 )
				);

				foreach ( $res as $row ) {
					// Prevent blocked users from appearing
					$user = User::newFromId( $row->rev_user );
					if( !$user->isBlocked() ) {
						$editors[] = array(
							'user_id' => $row->rev_user,
							'user_name' => $row->rev_user_text
						);
					}
				}

				$wgMemc->set( $key, $editors, 60 * 5 );
			} else {
				wfDebug( __METHOD__ . ": Loading recent editors for page {$pageTitleId} from cache\n" );
				$editors = $data;
			}

			$x = 1;
			$per_row = 4;

			if( count( $editors ) > 0 ) {
				$footer .= '<div id="footer-container">
					<div id="footer-actions">
						<h2>' . wfMsg( 'nimbus-contribute' ) . '</h2>'
							. wfMsgExt( 'nimbus-pages-can-be-edited', 'parsemag' ) .
						'<a href="' . $title->escapeFullURL( $this->skin->editUrlOptions() ) . '" rel="nofollow" class="edit-action">' . wfMsg( 'editthispage' ) . '</a>
						<a href="' . $title->getTalkPage()->escapeFullURL() . '" rel="nofollow" class="discuss-action">' . wfMsg( 'talkpage' ) . '</a>
						<a href="' . $title->escapeFullURL( 'action=history' ) . '" rel="nofollow" class="page-history-action">' . wfMsg( 'pagehist' ) . '</a>';
				$footer .= '</div>';
				// Only load the page editors' avatars if wAvatar class exists and $wgUserLevels is an array
				global $wgUserLevels;
				if ( class_exists( 'wAvatar' ) && is_array( $wgUserLevels ) ) {
					$footer .= '<div id="footer-contributors">
						<h2>' . wfMsg( 'nimbus-recent-contributors' ) . '</h2>'
						. wfMsg( 'nimbus-recent-contributors-info' );

					foreach( $editors as $editor ) {
						$avatar = new wAvatar( $editor['user_id'], 'm' );
						$user_title = Title::makeTitle( NS_USER, $editor['user_name'] );

						$footer .= '<a href="' . $user_title->escapeFullURL() . '" rel="nofollow">
							<img src="' . $wgUploadPath . '/avatars/' .
								$avatar->getAvatarImage() . '" alt="' .
								htmlspecialchars( $editor['user_name'] ) .
								'" title="' .
								htmlspecialchars( $editor['user_name'] ) . '" />
						</a>';

						if( $x == count( $editors ) || $x != 1 && $x % $per_row == 0 ) {
							$footer .= '<br />';
						}

						$x++;
					}

					$footer .= '</div>';
				}

				$footer .= '</div>';
			}
		}

		$footer .= '<div id="footer-bottom">
			<a href="' . $main_page->escapeLocalURL() . '" rel="nofollow">' . wfMsg( 'mainpage' ) . '</a>
			<a href="' . $about->escapeLocalURL() . '" rel="nofollow">' . wfMsg( 'about' ) . '</a>
			<a href="' . $special->escapeLocalURL() . '" rel="nofollow">' . wfMsg( 'specialpages' ) . '</a>
			<a href="' . $help->escapeLocalURL() . '" rel="nofollow">' . wfMsg( 'help' ) . '</a>
			<a href="' . $disclaimerPage->escapeLocalURL() . '" rel="nofollow">' . wfMsg( 'disclaimers' ) . '</a>';

		// "Advertise" link on the footer, but only if a URL has been specified
		// in the MediaWiki:Nimbus-advertise-url system message
		$adURL = trim( wfMsgForContent( 'nimbus-advertise-url' ) );
		if( !wfEmptyMsg( 'nimbus-advertise-url', $adURL ) ) {
			$footer .= '<a href="' . $adURL . '" rel="nofollow">' .
				wfMsg( 'nimbus-advertise' ) . '</a>';
		}

		$footer .= '</div>' . "\n";

		return $footer;
	}

} // end of class