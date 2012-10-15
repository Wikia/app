<?php
/**
 * @file
 * @ingroup SpecialPage Favoritelist
 */

/**
 * Constructor
 *
 * @param $par Parameter passed to the page
 */

class SpecialFavoritelist extends SpecialPage {
        function __construct() {
                parent::__construct( 'Favoritelist' );
        }
 
        function execute( $par ) {
             global $wgRequest, $wgOut;
             $vwfav = new ViewFavorites();
 
 	         $this->setHeaders();
    	     $param = $wgRequest->getText('param');
    	     
        	 $vwfav->wfSpecialFavoritelist( $par );
        }
        
}

class ViewFavorites {

function wfSpecialFavoritelist( $par ) {
	global $wgUser, $wgOut, $wgLang, $wgRequest;
	global $wgRCShowFavoritingUsers, $wgEnotifFavoritelist, $wgShowUpdatedMarker;
	
	// Add feed links
	$flToken = $wgUser->getOption( 'favoritelisttoken' );
	if (!$flToken) {
		$flToken = sha1( mt_rand() . microtime( true ) );
		$wgUser->setOption( 'favoritelisttoken', $flToken );
		$wgUser->saveSettings();
	}
	
	global $wgServer, $wgScriptPath, $wgFeedClasses;
	$apiParams = array( 'action' => 'feedfavoritelist', 'allrev' => 'allrev',
						'flowner' => $wgUser->getName(), 'fltoken' => $flToken );
	$feedTemplate = wfScript('api').'?';
	
	foreach( $wgFeedClasses as $format => $class ) {
		$theseParams = $apiParams + array( 'feedformat' => $format );
		$url = $feedTemplate . wfArrayToCGI( $theseParams );
		$wgOut->addFeedLink( $format, $url );
	}

	$skin = $wgUser->getSkin();
	$specialTitle = SpecialPage::getTitleFor( 'Favoritelist' );
	$wgOut->setRobotPolicy( 'noindex,nofollow' );

	# Anons don't get a favoritelist
	if( $wgUser->isAnon() ) {
		$wgOut->setPageTitle( wfMsg( 'favoritenologin' ) );
		$llink = $skin->linkKnown(
			SpecialPage::getTitleFor( 'Userlogin' ), 
			wfMsgHtml( 'loginreqlink' ),
			array(),
			array( 'returnto' => $specialTitle->getPrefixedText() )
		);
		$wgOut->addHTML( wfMsgWikiHtml( 'favoritelistanontext', $llink ) );
		return;
	}

	$wgOut->setPageTitle( wfMsg( 'favoritelist' ) );

	$sub  = wfMsgExt( 'favoritelistfor', 'parseinline', $wgUser->getName() );
	$sub .= '<br />' . FavoritelistEditor::buildTools( $wgUser->getSkin() );
	$wgOut->setSubtitle( $sub );

	if( ( $mode = FavoritelistEditor::getMode( $wgRequest, $par ) ) !== false ) {
		$editor = new FavoritelistEditor();
		$editor->execute( $wgUser, $wgOut, $wgRequest, $mode );
		return;
	}

	
	$this->viewFavList($wgUser, $wgOut, $wgRequest, $mode);
	
}


private function viewFavList ($user, $output, $request, $mode) {
	global $wgUser, $wgOut, $wgLang, $wgRequest;
	$uid = $wgUser->getId();
	$output->setPageTitle( wfMsg( 'favoritelist' ) );
				if( $request->wasPosted() && $this->checkToken( $request, $wgUser ) ) {
					$titles = $this->extractTitles( $request->getArray( 'titles' ) );
					$this->unfavoriteTitles( $titles, $user );
					$user->invalidateCache();
					$output->addHTML( wfMsgExt( 'favoritelistedit-normal-done', 'parse',
						$GLOBALS['wgLang']->formatNum( count( $titles ) ) ) );
					$this->showTitles( $titles, $output, $wgUser->getSkin() );
				}
				$this->showNormalForm( $output, $user );

	$dbr = wfGetDB( DB_SLAVE, 'favoritelist' );
//	$recentchanges = $dbr->tableName( 'recentchanges' );

	$favoritelistCount = $dbr->selectField( 'favoritelist', 'COUNT(fl_user)',
		array( 'fl_user' => $uid ), __METHOD__ );
	// Adjust for page X, talk:page X, which are both stored separately,
	// but treated together
	//$nitems = floor($favoritelistCount / 2);
	$nitems = $favoritelistCount;
	if( $nitems == 0 ) {
		$wgOut->addWikiMsg( 'nofavoritelist' );
		return;
	}

}

	/**
	 * Check the edit token from a form submission
	 *
	 * @param $request WebRequest
	 * @param $user User
	 * @return bool
	 */
	private function checkToken( $request, $user ) {
		return $user->matchEditToken( $request->getVal( 'token' ), 'favoritelistedit' );
	}

	/**
	 * Extract a list of titles from a blob of text, returning
	 * (prefixed) strings; unfavoritable titles are ignored
	 *
	 * @param $list mixed
	 * @return array
	 */
	private function extractTitles( $list ) {
		$titles = array();
		if( !is_array( $list ) ) {
			$list = explode( "\n", trim( $list ) );
			if( !is_array( $list ) )
				return array();
		}
		foreach( $list as $text ) {
			$text = trim( $text );
			if( strlen( $text ) > 0 ) {
				$title = Title::newFromText( $text );
				//if( $title instanceof Title && $title->isFavoritable() )
					$titles[] = $title->getPrefixedText();
			}
		}
		return array_unique( $titles );
	}

	/**
	 * Print out a list of linked titles
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param $titles An array of strings, or Title objects
	 * @param $output OutputPage
	 * @param $skin Skin
	 */
	private function showTitles( $titles, $output, $skin ) {
		$talk = wfMsgHtml( 'talkpagelinktext' );
		// Do a batch existence check
		$batch = new LinkBatch();
		foreach( $titles as $title ) {
			if( !$title instanceof Title )
				$title = Title::newFromText( $title );
			//if( $title instanceof Title ) {
			//	$batch->addObj( $title );
			//	$batch->addObj( $title->getTalkPage() );
			//}
		}
		$batch->execute();
		// Print out the list
		$output->addHTML( "<ul>\n" );
		foreach( $titles as $title ) {
			if( !$title instanceof Title )
				$title = Title::newFromText( $title );
			if( $title instanceof Title ) {
				$output->addHTML( "<li>" . $skin->link( $title )
				//. ' (' . $skin->link( $title->getTalkPage(), $talk ) . ")</li>\n" );
				. "</li>\n" );
			}
		}
		$output->addHTML( "</ul>\n" );
	}

	/**
	 * Count the number of titles on a user's favoritelist, excluding talk pages
	 *
	 * @param $user User
	 * @return int
	 */
	private function countFavoritelist( $user ) {
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select( 'favoritelist', 'COUNT(fl_user) AS count', array( 'fl_user' => $user->getId() ), __METHOD__ );
		$row = $dbr->fetchObject( $res );
		return ceil( $row->count ); // Paranoia
	}

	/**
	 * Prepare a list of titles on a user's favoritelist (excluding talk pages)
	 * and return an array of (prefixed) strings
	 *
	 * @param $user User
	 * @return array
	 */
	private function getFavoritelist( $user ) {
		$list = array();
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select(
			'favoritelist',
			array(
				'fl_namespace',
				'fl_title'
			),
			array(
				'fl_user' => $user->getId(),
			),
			__METHOD__
		);
		if( $res->numRows() > 0 ) {
			while( $row = $res->fetchObject() ) {
				$title = Title::makeTitleSafe( $row->fl_namespace, $row->fl_title );
				if( $title instanceof Title && !$title->isTalkPage() )
					$list[] = $title->getPrefixedText();
			}
			$res->free();
		}
		return $list;
	}

	/**
	 * Get a list of titles on a user's favoritelist, excluding talk pages,
	 * and return as a two-dimensional array with namespace, title and
	 * redirect status
	 *
	 * @param $user User
	 * @return array
	 */
	private function getFavoritelistInfo( $user ) {
		$titles = array();
		$dbr = wfGetDB( DB_MASTER );
		$uid = intval( $user->getId() );
		list( $favoritelist, $page ) = $dbr->tableNamesN( 'favoritelist', 'page' );
		$sql = "SELECT fl_namespace, fl_title, page_id, page_len, page_is_redirect
			FROM {$favoritelist} LEFT JOIN {$page} ON ( fl_namespace = page_namespace
			AND fl_title = page_title ) WHERE fl_user = {$uid}";
		$res = $dbr->query( $sql, __METHOD__ );
		if( $res && $dbr->numRows( $res ) > 0 ) {
			$cache = LinkCache::singleton();
			while( $row = $dbr->fetchObject( $res ) ) {
				$title = Title::makeTitleSafe( $row->fl_namespace, $row->fl_title );
				if( $title instanceof Title ) {
					// Update the link cache while we're at it
					if( $row->page_id ) {
						$cache->addGoodLinkObj( $row->page_id, $title, $row->page_len, $row->page_is_redirect );
					} else {
						$cache->addBadLinkObj( $title );
					}
					// Ignore non-talk
					if( !$title->isTalkPage() )
						$titles[$row->fl_namespace][$row->fl_title] = $row->page_is_redirect;
				}
			}
		}
		return $titles;
	}


/**
	 * Add a list of titles to a user's favoritelist
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param $titles An array of strings, or Title objects
	 * @param $user User
	 */
	private function favoriteTitles( $titles, $user ) {
		$dbw = wfGetDB( DB_MASTER );
		$rows = array();
		foreach( $titles as $title ) {
			if( !$title instanceof Title )
				$title = Title::newFromText( $title );
			if( $title instanceof Title ) {
				$rows[] = array(
					'fl_user' => $user->getId(),
					'fl_namespace' => ( $title->getNamespace() | 1 ),
					'fl_title' => $title->getDBkey(),
					'fl_notificationtimestamp' => null,
				);
			}
		}
		$dbw->insert( 'favoritelist', $rows, __METHOD__, 'IGNORE' );
	}

	/**
	 * Remove a list of titles from a user's favoritelist
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param $titles An array of strings, or Title objects
	 * @param $user User
	 */
	private function unfavoriteTitles( $titles, $user ) {
		$dbw = wfGetDB( DB_MASTER );
		foreach( $titles as $title ) {
			if( !$title instanceof Title )
				$title = Title::newFromText( $title );
			if( $title instanceof Title ) {
				$dbw->delete(
					'favoritelist',
					array(
						'fl_user' => $user->getId(),
						'fl_namespace' => ( $title->getNamespace() | 1 ),
						'fl_title' => $title->getDBkey(),
					),
					__METHOD__
				);
				$article = new Article($title);
				wfRunHooks('UnfavoriteArticleComplete',array(&$user,&$article));
			}
		}
	}

	/**
	 * Show the standard favoritelist editing form
	 *
	 * @param $output OutputPage
	 * @param $user User
	 */
	private function showNormalForm( $output, $user ) {
		global $wgUser;
		if( ( $count = $this->countFavoritelist($user ) ) > 0 ) {
			$self = SpecialPage::getTitleFor( 'Favoritelist' );
			$form  = Xml::openElement( 'form', array( 'method' => 'post',
				'action' => $self->getLocalUrl( array( 'action' => 'edit' ) ) ) );
			$form .= Html::hidden( 'token', $wgUser->editToken( 'favoritelistedit' ) );
			//$form .= "<fieldset>\n<legend>" . wfMsgHtml( 'favoritelistedit-normal-legend' ) . "</legend>";
			//$form .= wfMsgExt( 'favoritelistedit-normal-explain', 'parse' );
			$form .= $this->buildRemoveList( $user, $wgUser->getSkin() );
			//$form .= '<p>' . Xml::submitButton( wfMsg( 'favoritelistedit-normal-submit' ) ) . '</p>';
			$form .= '</fieldset></form>';
			$output->addHTML( $form );
		}
	}

	/**
	 * Build the part of the standard favoritelist editing form with the actual
	 * title selection checkboxes and stuff.  Also generates a table of
	 * contents if there's more than one heading.
	 *
	 * @param $user User
	 * @param $skin Skin (really, Linker)
	 */
	private function buildRemoveList( $user, $skin ) {
		$list = "";
		$toc = $skin->tocIndent();
		$tocLength = 0;
		foreach( $this->getFavoritelistInfo( $user ) as $namespace => $pages ) {
			$tocLength++;
			$heading = htmlspecialchars( $this->getNamespaceHeading( $namespace ) );
			$anchor = "editfavoritelist-ns" . $namespace;

			$list .= $skin->makeHeadLine( 2, ">", $anchor, $heading, "" );
			$toc .= $skin->tocLine( $anchor, $heading, $tocLength, 1 ) . $skin->tocLineEnd();

			$list .= "<ul>\n";
			foreach( $pages as $dbkey => $redirect ) {
				$title = Title::makeTitleSafe( $namespace, $dbkey );
				$list .= $this->buildRemoveLine( $title, $redirect, $skin );
			}
			$list .= "</ul>\n";
		}
		// ISSUE: omit the TOC if the total number of titles is low?
		if( $tocLength > 10 ) {
			$list = $skin->tocList( $toc ) . $list;
		}
		return $list;
	}

	/**
	 * Get the correct "heading" for a namespace
	 *
	 * @param $namespace int
	 * @return string
	 */
	private function getNamespaceHeading( $namespace ) {
		return $namespace == NS_MAIN
			? wfMsgHtml( 'blanknamespace' )
			: htmlspecialchars( $GLOBALS['wgContLang']->getFormattedNsText( $namespace ) );
	}

	/**
	 * Build a single list item containing a check box selecting a title
	 * and a link to that title, with various additional bits
	 *
	 * @param $title Title
	 * @param $redirect bool
	 * @param $skin Skin
	 * @return string
	 */
	private function buildRemoveLine( $title, $redirect, $skin ) {
		global $wgLang;
		# In case the user adds something unusual to their list using the raw editor
		# We moved the Tools array completely into the "if( $title->exists() )" section.
		$showlinks=false; 
		$link = $skin->link( $title );
		if( $redirect )
			$link = '<span class="favoritelistredir">' . $link . '</span>';
			
		if( $title->exists() ) {
			$showlinks = true;
			$tools[] = $skin->link( $title->getTalkPage(), wfMsgHtml( 'talkpagelinktext' ) );
			$tools[] = $skin->link(
				$title,
				wfMsgHtml( 'history_short' ),
				array(),
				array( 'action' => 'history' ),
				array( 'known', 'noclasses' )
			);
		}
		if( $title->getNamespace() == NS_USER && !$title->isSubpage() ) {
			$tools[] = $skin->link(
				SpecialPage::getTitleFor( 'Contributions', $title->getText() ),
				wfMsgHtml( 'contributions' ),
				array(),
				array(),
				array( 'known', 'noclasses' )
			);
		}
		
		if ($showlinks) {
			return "<li>"
			. $link . " (" . $wgLang->pipeList( $tools ) . ")" . "</li>\n";
		} else {
			return "<li>"
			. $link . "</li>\n";
		}
	}

	/**
	 * Show a form for editing the favoritelist in "raw" mode
	 *
	 * @param $output OutputPage
	 * @param $user User
	 */
	public function showRawForm( $output, $user ) {
		global $wgUser;
		$this->countFavoritelist( $user );
		$self = SpecialPage::getTitleFor( 'Favoritelist' );
		$form  = Xml::openElement( 'form', array( 'method' => 'post',
			'action' => $self->getLocalUrl( array( 'action' => 'raw' ) ) ) );
		$form .= Html::hidden( 'token', $wgUser->editToken( 'favoritelistedit' ) );
		$form .= '<fieldset><legend>' . wfMsgHtml( 'favoritelistedit-raw-legend' ) . '</legend>';
		$form .= wfMsgExt( 'favoritelistedit-raw-explain', 'parse' );
		$form .= Xml::label( wfMsg( 'favoritelistedit-raw-titles' ), 'titles' );
		$form .= "<br />\n";
		$form .= Xml::openElement( 'textarea', array( 'id' => 'titles', 'name' => 'titles',
			'rows' => $wgUser->getIntOption( 'rows' ), 'cols' => $wgUser->getIntOption( 'cols' ) ) );
		$titles = $this->getFavoritelist( $user );
			foreach( $titles as $title )
			$form .= htmlspecialchars( $title ) . "\n";
		$form .= '</textarea>';
		$form .= '<p>' . Xml::submitButton( wfMsg( 'favoritelistedit-raw-submit' ) ) . '</p>';
		$form .= '</fieldset></form>';
		$output->addHTML( $form );
	}

	/**
	 * Determine whether we are editing the favoritelist, and if so, what
	 * kind of editing operation
	 *
	 * @param $request WebRequest
	 * @param $par mixed
	 * @return int
	 */
	public static function getMode( $request, $par ) {
		$mode = strtolower( $request->getVal( 'action', $par ) );
		switch( $mode ) {
			case 'clear':
				return self::EDIT_CLEAR;
			case 'raw':
				return self::EDIT_RAW;
			case 'edit':
				return self::EDIT_NORMAL;
			default:
				return false;
		}
	}

	/**
	 * Build a set of links for convenient navigation
	 * between favoritelist viewing and editing modes
	 *
	 * @param $skin Skin to use
	 * @return string
	 */
	public static function buildTools( $skin ) {
		global $wgLang;

		$tools = array();
		$modes = array( 'view' => false, 'edit' => 'edit', 'raw' => 'raw' );
		foreach( $modes as $mode => $subpage ) {
			// can use messages 'favoritelisttools-view', 'favoritelisttools-edit', 'favoritelisttools-raw'
			$tools[] = $skin->link(
				SpecialPage::getTitleFor( 'Favoritelist', $subpage ),
				wfMsgHtml( "favoritelisttools-{$mode}" ),
				array(),
				array(),
				array( 'known', 'noclasses' )
			);
		}
		return $wgLang->pipeList( $tools );
	}
}
	

