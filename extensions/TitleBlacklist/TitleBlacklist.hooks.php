<?php
/**
 * Hooks for Title Blacklist
 * @author Victor Vasiliev
 * @copyright © 2007-2010 Victor Vasiliev et al
 * @license GNU General Public License 2.0 or later
 */

/**
 * Hooks for the TitleBlacklist class
 *
 * @ingroup Extensions
 */
class TitleBlacklistHooks {

	/**
	 * Added by Wikia
	 * @var array
	 */
	public static $cache = array();

	/**
	 * getUserPermissionsErrorsExpensive hook
	 *
	 * @param $title Title
	 * @param $user User
	 * @param $action
	 * @param $result
	 * @return bool
	 */
	public static function userCan( $title, $user, $action, &$result ) {
		# Some places check createpage, while others check create.
		# As it stands, upload does createpage, but normalize both
		# to the same action, to stop future similar bugs.
		if( $action === 'createpage' || $action === 'createtalk' ) {
			$action = 'create';
		}
		if( $action == 'create' || $action == 'edit' || $action == 'upload' ) {
			// Wikia change - begin - @author: wladek
			// Add in-request cache
			$cacheKey = serialize(array(
				$title->getPrefixedText(),
				$user->getName(),
				(string)$action,
			));
			if ( !array_key_exists($cacheKey,self::$cache) ) {
				$blacklisted = TitleBlacklist::singleton()->userCannot( $title, $user, $action );
				self::$cache[$cacheKey] = $blacklisted;
			} else {
				$blacklisted = self::$cache[$cacheKey];
			}
			// Wikia change - end - @author: wladek
			if( $blacklisted instanceof TitleBlacklistEntry ) {
				$result = array( $blacklisted->getErrorMessage( 'edit' ),
					htmlspecialchars( $blacklisted->getRaw() ),
					$title->getFullText() );
				return false;
			}
		}
		return true;
	}

	/**
	 * AbortMove hook
	 *
	 * @param $old Title
	 * @param $nt Title
	 * @param $user User
	 * @param $err
	 * @return bool
	 */
	public static function abortMove( $old, $nt, $user, &$err ) {
		$titleBlacklist = TitleBlacklist::singleton();
		$blacklisted = $titleBlacklist->userCannot( $nt, $user, 'move' );
		if( !$blacklisted ) {
			$blacklisted = $titleBlacklist->userCannot( $old, $user, 'edit' );
		}
		if( $blacklisted instanceof TitleBlacklistEntry ) {
			$err = wfMsgWikiHtml( $blacklisted->getErrorMessage( 'move' ),
				htmlspecialchars( $blacklisted->getRaw() ),
				htmlspecialchars( $old->getFullText() ),
				htmlspecialchars( $nt->getFullText() ) );
			return false;
		}
		return true;
	}

	/**
	 * Check whether a user name is acceptable,
	 * and set a message if unacceptable.
	 *
	 * Used by abortNewAccount and centralAuthAutoCreate
	 *
	 * @return bool Acceptable
	 */
	private static function acceptNewUserName( $userName, $permissionsUser, &$err, $override = true ) {
		$title = Title::makeTitleSafe( NS_USER, $userName );
		$blacklisted = TitleBlacklist::singleton()->userCannot( $title, $permissionsUser, 
			'new-account', $override );
		if( $blacklisted instanceof TitleBlacklistEntry ) {
			$message = $blacklisted->getErrorMessage( 'new-account' );
			$err = wfMsgWikiHtml( $message, $blacklisted->getRaw(), $userName );
			return false;
		}
		return true;
	}

	/** CentralAuthAutoCreate hook */
	public static function centralAuthAutoCreate( $user, $userName ) {
		$message = ''; # Will be ignored
		$anon = new User;
		return self::acceptNewUserName( $userName, $anon, $message );
	}

	/**
	 * EditFilter hook
	 *
	 * @param $editor EditPage
	 */
	public static function validateBlacklist( $editor, $text, $section, $error ) {
		global $wgUser;
		$title = $editor->mTitle;

		if( $title->getNamespace() == NS_MEDIAWIKI && $title->getDBkey() == 'Titleblacklist' ) {

			$blackList = TitleBlacklist::singleton();
			$bl = $blackList->parseBlacklist( $text );
			$ok = $blackList->validate( $bl );
			if( count( $ok ) == 0 ) {
				return true;
			}

			$errmsg = wfMsgExt( 'titleblacklist-invalid', array( 'parsemag' ), count( $ok ) );
			$errlines = '* <tt>' . implode( "</tt>\n* <tt>", array_map( 'wfEscapeWikiText', $ok ) ) . '</tt>';
			$error = Html::openElement( 'div', array( 'class' => 'errorbox' ) ) .
				$errmsg .
				"\n" .
				$errlines .
				Html::closeElement( 'div' ) . "\n" .
				Html::element( 'br', array( 'clear' => 'all' ) ) . "\n";

			// $error will be displayed by the edit class
			return true;
		} elseif( !$section ) {
			# Block redirects to nonexistent blacklisted titles
			$retitle = Title::newFromRedirect( $text );
			if( $retitle !== null && !$retitle->exists() )  {
				$blacklisted = TitleBlacklist::singleton()->userCannot( $retitle, $wgUser, 'create' );
				if( $blacklisted instanceof TitleBlacklistEntry ) {
					$error = Html::openElement( 'div', array( 'class' => 'errorbox' ) ) .
						wfMsg( 'titleblacklist-forbidden-edit',
							htmlspecialchars( $blacklisted->getRaw() ),
							$retitle->getFullText() ) .
						Html::closeElement( 'div' ) . "\n" .
						Html::element( 'br', array( 'clear' => 'all' ) ) . "\n";
				}
			}

			return true;
		}
		return true;
	}

	/**
	 * ArticleSaveComplete hook
	 *
	 * @param Article $article
	 */
	public static function clearBlacklist(
		WikiPage $article, User $user, $text, $summary, $isminor, $iswatch, $section
	): bool {
		$title = $article->getTitle();
		if( $title->getNamespace() == NS_MEDIAWIKI && $title->getDBkey() == 'Titleblacklist' ) {
			TitleBlacklist::singleton()->invalidate();
		}
		return true;
	}
}
