<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of CategoryBrowser.
 *
 * CategoryBrowser is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * CategoryBrowser is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CategoryBrowser; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * CategoryBrowser is an AJAX-enabled category filter and browser for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named CategoryBrowser into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/CategoryBrowser/CategoryBrowser.php";
 *
 * @version 0.3.1
 * @link http://www.mediawiki.org/wiki/Extension:CategoryBrowser
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is a part of MediaWiki extension.\n" );
}

/* default minimal count of DB rows to start paging */
define( 'CB_PAGING_ROWS', 20 );
/* minimal count of rows in image gallery (not DB rows!) pager */
define( 'CB_FILES_MAX_ROWS', 3 );
/* maximal number of logical operations in SQL filter (condition) */
define( 'CB_MAX_LOGICAL_OP', 5 );

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'CategoryBrowser',
	'author' => 'QuestPC',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CategoryBrowser',
	'descriptionmsg' => 'categorybrowser-desc',
);
$dir = dirname(__FILE__);
$wgExtensionMessagesFiles['CategoryBrowser'] = $dir . '/CategoryBrowser.i18n.php';
$wgExtensionMessagesFiles['CategoryBrowserAliases'] = $dir . '/CategoryBrowser.alias.php';
$wgSpecialPages['CategoryBrowser'] = 'CategoryBrowserPage';
$wgSpecialPageGroups['CategoryBrowser'] = 'pages';

CB_Setup::init();

class CB_Setup {

	static $version = '0.3.1';
	static $ExtDir; // filesys path with windows path fix
	static $ScriptPath; // apache virtual path
	static $cat_pages_ranges; // ???

	static $skin = null;
	static $user;
	static $response;
	static $cookie_prefix;

	// by default, enable browsing of category parents (reverse browsing)
	static $allowNestedParents = true;

	// by default, allow optional selecting of categories which has no parents only
	static $allowNoParentsOnly = true;

	// number of files to show in gallery row
	static $imageGalleryPerRow = 4;

	// default limits of different pagers
	static $categoriesLimit = CB_PAGING_ROWS;
	static $pagesLimit = CB_PAGING_ROWS;
	static $filesLimit = null;
	static $filesMaxRows = CB_FILES_MAX_ROWS;
	static $parentsLimit = CB_PAGING_ROWS;

	// case insensitive collation of category table 'cat_title' field
	static $cat_title_CI = '';

	/**
	 * Add this extension to the mediawiki's extensions list.
	 */
	static function init() {
		global $wgScriptPath;
		global $wgAutoloadClasses;
		global $wgAjaxExportList;

		self::$ExtDir = str_replace( "\\", "/", dirname( __FILE__ ) );
		// next expression splitted into two separate lines due to warning in E_STRICT mode
		$top_dir = explode( '/', self::$ExtDir );
		$top_dir = array_pop( $top_dir );
		self::$ScriptPath = $wgScriptPath . '/extensions' . ( ( $top_dir == 'extensions' ) ? '' : '/' . $top_dir );

		// do not forget to autoload all the required classes (for AJAX to work correctly)
		$wgAutoloadClasses['CB_XML'] =
		$wgAutoloadClasses['CB_SqlCond'] = self::$ExtDir . '/CategoryBrowserBasic.php';

		$wgAutoloadClasses['CB_AbstractPager'] =
		$wgAutoloadClasses['CB_RootPager'] =
		$wgAutoloadClasses['CB_SubPager'] =
		$wgAutoloadClasses['CB_ParentPager'] = self::$ExtDir . '/CategoryBrowserModel.php';

		$wgAutoloadClasses['CB_AbstractPagesView'] =
		$wgAutoloadClasses['CB_CategoriesView'] =
		$wgAutoloadClasses['CB_PagesView'] =
		$wgAutoloadClasses['CB_FilesView'] = self::$ExtDir . '/CategoryBrowserView.php';

		$wgAutoloadClasses['CategoryBrowser'] = self::$ExtDir . '/CategoryBrowserCtrl.php';
		$wgAutoloadClasses['CategoryBrowserPage'] = self::$ExtDir . '/CategoryBrowserPage.php';


		$wgAjaxExportList[] = 'CategoryBrowser::getRootOffsetHtml';
		$wgAjaxExportList[] = 'CategoryBrowser::getSubOffsetHtml';
		$wgAjaxExportList[] = 'CategoryBrowser::applyEncodedQueue';
		$wgAjaxExportList[] = 'CategoryBrowser::generateSelectedOption';

		# calculate proper limit for files pager
		# by default, limit for ImageGallery is maxrows * perrow :
		self::$filesLimit = CB_Setup::$filesMaxRows * CB_Setup::$imageGalleryPerRow;
		if ( self::$filesLimit <= 0 ) {
			# ImageGallery is disabled, use pages limit instead
			self::$filesLimit = CB_Setup::$pagesLimit;
		}
	}

	/**
	 * should not be called from LocalSettings.php
	 * should be called only when the wiki is fully initialized
	 */
	static function initUser() {
		global $wgUser, $wgRequest, $wgSkin;
		// TODO: add more encoding mappings
		$collation_CS_CI = array( 'utf8_bin' => 'utf8_general_ci' );
		self::$user = is_object( $wgUser ) ? $wgUser : new User();
		self::$skin = is_object( $wgUser ) ? self::$user->getSkin() : $wgSkin;
		self::$response = $wgRequest->response();
		self::$cookie_prefix = 'CategoryBrowser_' . self::$user->getId() . '_';
		# find out current collation of category table 'cat_title' field
		# this is required to switch between CI and CS search
		$db = & wfGetDB( DB_SLAVE );
		$category_table = $db->tableName( 'category' );
		$db_result = $db->query( "SHOW FULL COLUMNS FROM ${category_table}" );
		self::$cat_title_CI = '';
		$cat_title_CS = '';
		while ( $row = $db->fetchObject( $db_result ) ) {
			if ( $row->Field == 'cat_title' ) {
				$cat_title_CS = $row->Collation;
				if ( isset( $collation_CS_CI[ $cat_title_CS ] ) ) {
					self::$cat_title_CI = $collation_CS_CI[ $cat_title_CS ];
				}
				break;
			}
		}
	}

	static function entities( $s ) {
		return htmlentities( $s, ENT_COMPAT, 'UTF-8' );
	}

	static function specialchars( $s ) {
		return htmlspecialchars( $s, ENT_COMPAT, 'UTF-8' );
	}

	static function getFullCookieName( $cookievar ) {
		global $wgCookiePrefix;
		if ( !is_string( self::$cookie_prefix ) ) {
			throw new MWException( 'You have to call CB_Setup::initUser before to use ' . __METHOD__ );
		}
		return $wgCookiePrefix . self::$cookie_prefix . $cookievar;
	}

	static function getJsCookiePrefix() {
		global $wgCookiePrefix;
		if ( !is_string( self::$cookie_prefix ) ) {
			throw new MWException( 'You have to call CB_Setup::initUser before to use ' . __METHOD__ );
		}
		return Xml::escapeJsString( $wgCookiePrefix . self::$cookie_prefix );
	}

	/* # urlencode cookie illegal chars (not needed anymore, was used with self::$user->getName())
	 * $cookie_illegal_chars =     array( "=",   ",",   ";",   " ",   "\t",  "\r",  "\n",  "\013", "\014" );
	 * $cookie_replacement_chars = array( "%23", "%2C", "%3B", "%20", "%09", "%0D", "%0A", "%0B",  "%0C" );
	 * self::$cookie_prefix = str_replace( $cookie_illegal_chars, $cookie_replacement_chars, self::$cookie_prefix );
	 */
	static function setCookie( $cookievar, $val, $time ) {
		global $wgCookieHttpOnly;
		// User::setCookies() is not suitable for our needs because it's called only for non-anonymous users
		// our cookie has to be accessible in javascript
		// todo: cookie is not set / read in JS anymore, don't modify $wgCookieHttpOnly
		$wgCookieHttpOnly_save = $wgCookieHttpOnly;
		$wgCookieHttpOnly = false;
		if ( !is_string( self::$cookie_prefix ) || !is_object( self::$response ) ) {
			throw new MWException( 'You have to call CB_Setup::initUser before to use ' . __METHOD__ );
		}
		self::$response->setcookie( self::$cookie_prefix . $cookievar, $val, $time );
		$wgCookieHttpOnly = $wgCookieHttpOnly_save;
	}

	static function getCookie( $cookievar ) {
		$idx = self::getFullCookieName( $cookievar );
		return isset( $_COOKIE[ $idx ] ) ? $_COOKIE[ $idx ] : null;
	}

}
