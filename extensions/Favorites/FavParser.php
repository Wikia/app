<?php

class FavParser {

	function wfSpecialFavoritelist($argv, $parser) {
		
		global $wgUser, $wgOut, $wgLang, $wgRequest;
		global $wgRCShowFavoritingUsers, $wgEnotifFavoritelist, $wgShowUpdatedMarker;
		$output = '';
	
		$skin = $wgUser->getSkin();
		$specialTitle = SpecialPage::getTitleFor( 'Favoritelist' );
		//$wgOut->setRobotPolicy( 'noindex,nofollow' );
		
		$this->mTitle = $parser->getTitle();
		
		if ($this->mTitle->getNamespace() == NS_USER && array_key_exists('userpage', $argv) && $argv['userpage']) {
			$parts = explode( '/', $this->mTitle->getText() );
			$rootPart = $parts[0];
			$user = User::newFromName( $rootPart, true /* don't allow IP users*/ );
			//echo "Userpage: $user";
			$output = $this->viewFavList($user, $output, $wgRequest, $argv);
			$output .= $this->editlink($argv, $skin);
			return $output ;
		} else {
			$user = $wgUser;
		}
		
		# Anons don't get a favoritelist
		if( $wgUser->isAnon() ) {
			//$wgOut->setPageTitle( wfMsg( 'favoritenologin' ) );
			$llink = $skin->linkKnown(
				SpecialPage::getTitleFor( 'Userlogin' ), 
				wfMsg( 'loginreqlink' ),
				array(),
				array( 'returnto' => $specialTitle->getPrefixedText() )
			);
			$output = wfMsgHtml( 'favoritelistanontext', $llink ) ;
			return $output ;
			
		}
	
		$output = $this->viewFavList($user, $output, $wgRequest, $argv);
		$output .= $this->editlink($argv, $skin);
		
		return $output ;
	}

	
	private function viewFavList ($user, $output, $request, $argv) {
		global $wgOut, $wgLang, $wgRequest;
		$output = $this->showNormalForm( $output, $user );

		return $output;
	}

	/**
	 * Does the user want to display an editlink?
	 *
	 * @param $argv Array of values from the parser
	 * $param $skin User skin
	 * @return Output
	 */
	private function editlink($argv, $skin) {
		$output='';
		if ( array_key_exists('editlink', $argv) && $argv['editlink']) {
			# Add an edit link if you want it:
			$output = "<div id='contentSub'><br>" . 
				$skin->link(
					SpecialPage::getTitleFor( 'Favoritelist', 'edit' ),
					wfMsgHtml( "favoritelisttools-edit" ),
					array(),
					array(),
					array( 'known', 'noclasses' )
				) . "</div>";
		}
		return $output;
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
		return ceil( $row->count); 
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
	 * Show the standard favoritelist 
	 *
	 * @param $output OutputPage
	 * @param $user User
	 */
	private function showNormalForm( $output, $user ) {
		global $wgOut;
		$skin = $user->getSkin();
		
		if ( $this->countFavoritelist($user ) > 0 ) {
			$form = $this->buildRemoveList( $user, $skin );
			$output .=  $form ;
			return $output;
		} else {
			$output = wfmsg('nofavoritelist');
			return $output;
		}
	}

	/**
	 * Build part of the standard favoritelist 
	 *
	 * @param $user User
	 * @param $skin Skin (really, Linker)
	 */
	private function buildRemoveList( $user, $skin ) {
		$list = "";
		$list .= "<ul>\n";
		foreach( $this->getFavoritelistInfo( $user ) as $namespace => $pages ) {
			foreach( $pages as $dbkey => $redirect ) {
				$title = Title::makeTitleSafe( $namespace, $dbkey );
				$list .= $this->buildRemoveLine( $title, $redirect, $skin );
			}
		}
		$list .= "</ul>\n";
		return $list;
	}



	/**
	 * Build a single list item containing a link 
	 *
	 * @param $title Title
	 * @param $redirect bool
	 * @param $skin Skin
	 * @return string
	 */
	private function buildRemoveLine( $title, $redirect, $skin ) {
		global $wgLang;

		$link = $skin->link( $title );
		if( $redirect )
			$link = '<span class="favoritelistredir">' . $link . '</span>';

		return "<li>" . $link . "</li>\n";
		}

}
