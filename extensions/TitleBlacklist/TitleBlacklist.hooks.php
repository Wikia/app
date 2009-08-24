<?php
/**
 * Hooks for Title Blacklist
 * @author VasilievVV
 * @copyright © 2007 VasilievVV
 * @license GNU General Public License 2.0 or later
 */

/**
 * Hooks for the TitleBlacklist class
 * @package MediaWiki
 * @subpackage Extensions
 */
class TitleBlacklistHooks {
	/** getUserPermissionsErrorsExpensive hook */
	public static function userCan( $title, $user, $action, &$result ) {
		global $wgTitleBlacklist;
		if( $action == 'create' || $action == 'edit' || $action == 'upload' ) {
			efInitTitleBlacklist();
			$blacklisted = $wgTitleBlacklist->isBlacklisted( $title, $action );
			if( $blacklisted instanceof TitleBlacklistEntry ) {
				wfLoadExtensionMessages( 'TitleBlacklist' );
				$message = $blacklisted->getCustomMessage();
				if( is_null( $message ) )
					$message = 'titleblacklist-forbidden-edit';
				$result = array( $message,
					htmlspecialchars( $blacklisted->getRaw() ),
					$title->getFullText() );
				return false;
			}
		}
		return true;
	}

	/** AbortMove hook */
	public static function abortMove( $old, $nt, $user, &$err ) {
		global $wgTitleBlacklist;
		efInitTitleBlacklist();
		$blacklisted = $wgTitleBlacklist->isBlacklisted( $nt, 'move' );
		if( !$blacklisted )
			$blacklisted = $wgTitleBlacklist->isBlacklisted( $old, 'edit' );
		if( $blacklisted instanceof TitleBlacklistEntry ) {
			wfLoadExtensionMessages( 'TitleBlacklist' );
			$message = $blacklisted->getCustomMessage();
			if( is_null( $message ) )
				$message = 'titleblacklist-forbidden-move';
			$err = wfMsgWikiHtml( $message,
				htmlspecialchars( $blacklisted->getRaw() ),
				htmlspecialchars( $old->getFullText() ),
				htmlspecialchars( $nt->getFullText() ) );
			return false;
		}
		return true;
	}

	/** AbortNewAccount hook */
	public static function abortNewAccount($user, &$message) {
		global $wgTitleBlacklist, $wgUser;
		if ( $wgUser->isAllowed( 'tboverride' ) )
			return true;

		efInitTitleBlacklist();
		$title = Title::newFromText( $user->getName() );
		$blacklisted = $wgTitleBlacklist->isBlacklisted( $title, 'new-account' );
		if( !( $blacklisted instanceof TitleBlacklistEntry ) )
			$blacklisted = $wgTitleBlacklist->isBlacklisted( $title, 'create' );
		if( $blacklisted instanceof TitleBlacklistEntry ) {
			wfLoadExtensionMessages( 'TitleBlacklist' );
			$message = $blacklisted->getCustomMessage();
			if( is_null( $message ) )
				$message = wfMsgWikiHtml( 'titleblacklist-forbidden-new-account',
							  $blacklisted->getRaw(),
							  $user->getName() );
			$result = array( $message,
				htmlspecialchars( $blacklisted->getRaw() ),
				$title->getFullText() );
			return false;
		}
		return true;
	}
	
	/** EditFilter hook */
	public static function validateBlacklist( $editor, $text, $section, $error ) {
		global $wgTitleBlacklist;
		efInitTitleBlacklist();
		$title = $editor->mTitle;
		if( $title->getNamespace() == NS_MEDIAWIKI && $title->getDBkey() == 'Titleblacklist' ) {

			$bl = $wgTitleBlacklist->parseBlacklist( $text );
			$ok = $wgTitleBlacklist->validate( $bl );
			if( count( $ok ) == 0 ) {
				return true;
			}

			wfLoadExtensionMessages( 'TitleBlacklist' );
			$errmsg = wfMsgExt( 'titleblacklist-invalid', array( 'parsemag' ), count( $ok ) );
			$errlines = '* <tt>' . implode( "</tt>\n* <tt>", array_map( 'wfEscapeWikiText', $ok ) ) . '</tt>';
			$error = '<div class="errorbox">' .
				$errmsg .
				"\n" .
				$errlines .
				"</div>\n" .
				"<br clear='all' />\n";
		
			// $error will be displayed by the edit class
			return true;
		} else if (!$section) {
			# Block redirects to nonexistent blacklisted titles
			$retitle = Title::newFromRedirect( $text );
			if ( $retitle !== null && !$retitle->exists() )  {
				$blacklisted = $wgTitleBlacklist->isBlacklisted( $retitle, 'create' );
				if ( $blacklisted instanceof TitleBlacklistEntry ) {
					wfLoadExtensionMessages( 'TitleBlacklist' );
					$error = ( '<div class="errorbox">' .
						   wfMsg( 'titleblacklist-forbidden-edit', 
							  htmlspecialchars( $blacklisted->getRaw() ),
							  $retitle->getFullText() ) .
						   "</div>\n" .
						   "<br clear='all' />\n" );
				}
			}

			return true;
		}
		return true;
	}
	
	/** ArticleSaveComplete hook */
	public static function clearBlacklist( &$article, &$user,
			$text, $summary, $isminor, $iswatch, $section ) {
		$title = $article->getTitle();
		if( $title->getNamespace() == NS_MEDIAWIKI && $title->getDBkey() == 'Titleblacklist' ) {
			global $wgTitleBlacklist;
			efInitTitleBlacklist();
			$wgTitleBlacklist->invalidate();
		}
		return true;
	}
}
