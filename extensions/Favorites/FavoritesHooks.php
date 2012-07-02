<?php

class FavoritesHooks {

	public static function onLoadExtensionSchemaUpdates( $updater = null ) {
		if ( $updater === null ) { // <= 1.16 support
			global $wgExtNewTables, $wgExtModifiedFields;
			$wgExtNewTables[] = array(
				'favoritelist',
				dirname( __FILE__ ) . '/favorites.sql'
			);
		} else { // >= 1.17 support
			$updater->addExtensionUpdate( array( 'addTable', 'favoritelist',
				dirname( __FILE__ ) . '/favorites.sql', true ) );
		}
		return true;
	}

	public static function onUnknownAction( $action, $article ) {
		global $wgUser, $wgOut;

		if ( $action !== 'unfavorite' && $action !== 'favorite' ) {
			return true;
		}

		if ( $wgUser->isAnon() ) {
			$wgOut->showErrorPage( 'favoritenologin', 'favoritenologintext' );
			return;
		}
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$wgOut->setRobotPolicy( 'noindex,nofollow' );

		if ( $action === 'favorite' ) {
			if ( self::doFavorite( $article ) ) {
				$wgOut->setPagetitle( wfMsg( 'addedfavorite' ) );
				$wgOut->addWikiMsg( 'addedfavoritetext', $article->getTitle()->getPrefixedText() );
			}
		} else {
			if ( self::doUnfavorite( $article ) ) {
				$wgOut->setPagetitle( wfMsg( 'removedfavorite' ) );
				$wgOut->addWikiMsg( 'removedfavoritetext', $article->getTitle()->getPrefixedText() );
			}
		}

		$wgOut->returnToMain( true, $article->getTitle()->getPrefixedText() );

		return false;
	}

	/**
	 * Add this page to $wgUser's favoritelist
	 * @return bool true on successful favorite operation
	 */
	private static function doFavorite( $article ) {
		global $wgUser;

		if ( $wgUser->isAnon() ) {
			return false;
		}
		if ( wfRunHooks( 'FavoriteArticle', array( &$wgUser, &$article ) ) ) {
			$fl = FavoritedItem::fromUserTitle( $wgUser, $article->getTitle() );
			$fl->addFavorite();
			$article->getTitle()->invalidateCache();
			return wfRunHooks( 'FavoriteArticleComplete', array( &$wgUser, &$article ) );
		}

	}

	/**
	 * Stop favoriting a page
	 * @return bool true on successful unfavorite
	 */
	private static function doUnfavorite( $article ) {
		global $wgUser;

		if ( $wgUser->isAnon() ) {
			return false;
		}
		if ( wfRunHooks( 'UnfavoriteArticle', array( &$wgUser, &$article ) ) ) {
			$fl = FavoritedItem::fromUserTitle( $wgUser, $article->getTitle() );
			$fl->removeFavorite();
			$article->getTitle()->invalidateCache();
			return wfRunHooks( 'UnfavoriteArticleComplete', array( &$wgUser, &$article ) );
		}
		return false;
	}

	public static function onPersonalUrls( &$personal_urls, &$wgTitle ) {
		global $wgFavoritesPersonalURL, $wgUser;

		if ( $wgFavoritesPersonalURL && $wgUser->isLoggedIn() ) {
			$url['userpage'] = array_shift( $personal_urls );
			$url[] = array_shift( $personal_urls );
			$url[] = array_shift( $personal_urls );

			$url[] = array( 'text' => wfMsg( 'myfavoritelist' ),
				'href' => SpecialPage::getTitleFor( 'Favoritelist' )->getLocalURL() );
			$personal_urls = $url + $personal_urls;
		}

		return true;
	}

	public static function onParserFirstCallInit( &$parser ) {
		$parser->setHook( 'favorites', array( __CLASS__, 'renderFavorites' ) );
		return true;
	}

	function renderFavorites( $input, $argv, $parser ) {
		# The parser function itself
		# The input parameters are wikitext with templates expanded
		# The output should be wikitext too
		//$output = "Parser Output goes here.";

		$favParse = new FavParser();
		$output = $favParse->wfSpecialFavoritelist( $argv, $parser );
		$parser->disableCache();
		return $output;
	}

	public static function onSkinTemplateNavigation( $skin, &$links ) {
		global $wgUseIconFavorite, $wgRequest, $wgUser;

		$action = $wgRequest->getText( 'action' );
		$title =  $skin->getTitle();
	
		if ( $title->getNamespace() >= NS_MAIN ) {
			if ( $wgUseIconFavorite ) {
					$class = 'icon ';
					$place = 'views';
				} else {
					$class = '';
					$place = 'actions';
				}

				$fl = FavoritedItem::fromUserTitle( $wgUser, $title );

				$mode = $fl->isFavorited() ? 'unfavorite' : 'favorite';
				$links[$place][$mode] = array(
					'class' => $class . ( ( $action == 'favorite' || $action == 'unfavorite' ) ? ' selected' : false ),
					'text' => wfMsg( $mode ), // uses 'favorite' or 'unfavorite' message
					'href' => $title->getLocalUrl( 'action=' . $mode )
				);
		}
		return true;
	}

	public static function onSkinTemplateTabs( $skin, &$content_actions ) {
		global $wgUseIconFavorite, $wgUser, $wgRequest;
	
		$action = $wgRequest->getText( 'action' );
		$title = $skin->getTitle();
		if ( $title->getNamespace() >= NS_MAIN ) {
			$fl = FavoritedItem::fromUserTitle( $wgUser, $title );
			$mode = $fl->isFavorited() ? 'unfavorite' : 'favorite';
			$content_actions[$mode] = array (
				'class' => (( $action == 'favorite' || $action == 'unfavorite' ) ? ' selected' : false ),
				'text' => wfMsg( $mode ), // uses 'favorite' or 'unfavorite' message
				'href' => $title->getLocalUrl( 'action=' . $mode )
 			);
		}
		return true;
	}

	public static function onTitleMoveComplete( &$title, &$nt, &$user, $pageid, $redirid ) {
		# Update watchlists
		$oldnamespace = $title->getNamespace() & ~1;
		$newnamespace = $nt->getNamespace() & ~1;
		$oldtitle = $title->getDBkey();
		$newtitle = $nt->getDBkey();

		if ( $oldnamespace != $newnamespace || $oldtitle != $newtitle ) {
			FavoritedItem::duplicateEntries( $title, $nt );
		}
		return true;
	}

	public static function onArticleDeleteComplete(&$article, &$user, $reason, $id ){
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'favoritelist', array(
			'fl_namespace' => $article->mTitle->getNamespace(),
			'fl_title' => $article->mTitle->getDBKey() ),
			__METHOD__ );
		return true;
	}

	public static function onBeforePageDisplay( $out ) {
		global $wgUseIconFavorite, $wgExtensionAssetsPath;

		if ( $wgUseIconFavorite ) {
			$out->addStyle( $wgExtensionAssetsPath . '/Favorites/favorites.css' );
		}

		return true;
	}
}
