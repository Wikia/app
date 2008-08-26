<?php

/**
 * Extension to provide a global "bad username" list
 *
 * @author Rob Church <robchur@gmail.com>
 * @addtogroup Extensions
 * @copyright © 2006-2007 Rob Church
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0
 */

if( defined( 'MEDIAWIKI' ) ) {

	$wgExtensionCredits['other'][] = array(
		'name'           => 'Username Blacklist',
		'author'         => 'Rob Church',
		'version'        => '1.7.1', # see README
		'url'            => 'http://www.mediawiki.org/wiki/Extension:Username_Blacklist',
		'description'    => 'Restrict the creation of user accounts matching one or more regular expressions',
		'descriptionmsg' => 'usernameblacklist-desc'
	);

	$dir = dirname(__FILE__) . '/';
	$wgExtensionMessagesFiles['UsernameBlacklist'] = $dir . 'UsernameBlacklist.i18n.php';

	$wgAvailableRights[] = 'uboverride';
	$wgGroupPermissions['sysop']['uboverride'] = true;

	$wgHooks['AbortNewAccount'][] = 'efUsernameBlacklist';
	$wgHooks['ArticleSaveComplete'][] = 'efUsernameBlacklistInvalidate';
	$wgHooks['EditFilter'][] = 'efUsernameBlacklistValidate';

	/**
	 * Perform the check
	 * @param $user User to be checked
	 * @return bool
	 */
	function efUsernameBlacklist( &$user ) {
		global $wgUser;
		$blackList = UsernameBlacklist::fetch();
		if( $blackList->match( $user->getName() ) && !$wgUser->isAllowed( 'uboverride' ) ) {
			wfLoadExtensionMessages( 'UsernameBlacklist' );
			global $wgOut;
			$returnTitle = Title::makeTitle( NS_SPECIAL, 'Userlogin' );
			$wgOut->errorPage( 'blacklistedusername', 'blacklistedusernametext' );
			$wgOut->returnToMain( false, $returnTitle->getPrefixedText() );
			return false;
		} else {
			return true;
		}
	}

	/**
	 * When the blacklist page is edited, invalidate the blacklist cache
	 *
	 * @param $article Page that was edited
	 * @return bool
	 */
	function efUsernameBlacklistInvalidate( &$article ) {
		$title =& $article->mTitle;
		if( $title->getNamespace() == NS_MEDIAWIKI && $title->getText() == 'Usernameblacklist' ) {
			$blacklist = UsernameBlacklist::fetch();
			$blacklist->invalidateCache();
		}
		return true;
	}

	/**
	 * If editing the username blacklist page, check for validity and whine at the user.
	 */
	function efUsernameBlacklistValidate( $editPage, $text, $section, &$hookError ) {
		if( $editPage->mTitle->getNamespace() == NS_MEDIAWIKI &&
		 	$editPage->mTitle->getDBkey() == 'Usernameblacklist' ) {

			$blacklist = UsernameBlacklist::fetch();
			$badLines = $blacklist->validate( $text );

			if( $badLines ) {
				wfLoadExtensionMessages( 'UsernameBlacklist' );
				$badList = "*<tt>" .
					implode( "</tt>\n*<tt>",
						array_map( 'wfEscapeWikiText', $badLines ) ) .
					"</tt>\n";
				$hookError =
					"<div class='errorbox'>" .
					wfMsgExt( 'usernameblacklist-invalid-lines', array( 'parsemag' ), count( $badLines ) ) .
					"\n" .
					$badList .
					"</div>\n" .
					"<br clear='all' />\n";

				// This is kind of odd, but... :D
				return true;
			}
		}
		return true;
	}

	class UsernameBlacklist {
		
		var $regex;		
		
		/**
		 * Trim leading spaces and asterisks from the text
		 * @param $text Text to trim
		 * @return string
		 */
		function transform( $text ) {
			return trim( $text, ' *' );
		}

		/**
		 * Is the supplied text an appropriate fragment to include?
		 *
		 * @param string $text Text to validate
		 * @return bool
		 */
		function isUsable( $text ) {
			return substr( $text, 0, 1 ) == '*';
		}

		/**
		 * Attempt to fetch the blacklist from cache; build it if needs be
		 *
		 * @return array
		 */
		function fetchBlacklist() {
			global $wgMemc, $wgDBname;
			$list = $wgMemc->get( $this->key );
			if( is_array( $list ) ) {
				return $list;
			} else {
				$list = $this->buildBlacklist();
				$wgMemc->set( $this->key, $list, 900 );
				return $list;
			}
		}

		/**
		 * Build the blacklist from scratch, using the message page
		 *
		 * @return array of regexes, potentially empty
		 */
		function buildBlacklist() {
			$blacklist = wfMsgForContent( 'usernameblacklist' );
			if( !wfEmptyMsg( 'usernameblacklist', $blacklist ) ) {
				return $this->safeBlacklist( $blacklist );
			} else {
				return array();
			}
		}

		/**
		 * Build one or more blacklist regular expressions from the input.
		 * If a fragment causes an error, we'll return multiple items
		 * so they can be run separately.
		 *
		 * @param string $input
		 * @return array of regexes, potentially empty
		 */
		function safeBlacklist( $input ) {
			$groups = $this->fragmentsFromInput( $input );
			if( count( $groups ) ) {
				$combinedRegex = '/(' . implode( '|', $groups ) . ')/u';

				wfSuppressWarnings();
				$ok = ( preg_match( $combinedRegex, '' ) !== false );
				wfRestoreWarnings();

				if( $ok ) {
					return array( $combinedRegex );
				} else {
					$regexes = array();
					foreach( $groups as $fragment ) {
						$regexes[] = '/' . $fragment . '/u';
					}
					return $regexes;
				}
			} else {
				return array();
			}
		}

		/**
		 * Break input down by line, remove comments, and strip to regex fragments.
		 * @input string
		 * @return array
		 */
		function fragmentsFromInput( $input ) {
			$lines = explode( "\n", $input );
			$groups = array();
			foreach( $lines as $line ) {
				$line = trim( $line );
				if( $this->isUsable( $line ) )
					$groups[] = $this->transform( $line );
			}
			return $groups;
		}

		/**
		 * Go through a set of input and return a list of lines which
		 * produce invalid regexes.
		 * Empty set means good. :)
		 *
		 * @param string $input
		 * @return array
		 */
		function validate( $input ) {
			$bad = array();
			$fragments = $this->fragmentsFromInput( $input );
			foreach( $fragments as $fragment ) {
				wfSuppressWarnings();
				$ok = ( preg_match( "/$fragment/u", '' ) !== false );
				wfRestoreWarnings();
				if( !$ok ) {
					$bad[] = $fragment;
				}
			}
			return $bad;
		}

		/**
		 * Invalidate the blacklist cache
		 */
		function invalidateCache() {
			global $wgMemc;
			$wgMemc->delete( $this->key );
		}

		/**
		 * Match a username against the blacklist
		 * @param $username Username to check
		 * @return bool
		 */
		function match( $username ) {
			foreach( $this->regexes as $regex ) {
				wfSuppressWarnings();
				$match = preg_match( $regex, $username );
				wfRestoreWarnings();

				if( $match ) {
					return true;
				} elseif( $match === false ) {
					wfDebugLog( 'UsernameBlacklist', "Invalid username regex $regex" );
				}
			}
			return false;
		}

		/**
		 * Constructor
		 * Prepare the regular expression
		 */
		function UsernameBlacklist() {
			global $wgDBname;
			$this->key = "{$wgDBname}:username-blacklist";
			$this->regexes = $this->fetchBlacklist();
		}

		/**
		 * Fetch an instance of the blacklist class
		 * @return UsernameBlacklist
		 */
		static function fetch() {
			static $blackList = false;
			if( !$blackList )
				$blackList = new UsernameBlacklist();
			return $blackList;
		}

	}

} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}
