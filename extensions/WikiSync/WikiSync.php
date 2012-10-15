<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of WikiSync.
 *
 * WikiSync is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * WikiSync is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WikiSync; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * WikiSync allows an AJAX-based synchronization of revisions and files between
 * global wiki site and it's local mirror.
 *
 * To activate this extension :
 * * Create a new directory named WikiSync into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/WikiSync/WikiSync.php";
 *
 * @version 0.3.2
 * @link http://www.mediawiki.org/wiki/Extension:WikiSync
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is a part of MediaWiki extension.\n" );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'WikiSync',
	'author' => 'QuestPC',
	'url' => 'https://www.mediawiki.org/wiki/Extension:WikiSync',
	'descriptionmsg' => 'wikisync-desc',
);

$dir = dirname(__FILE__);
$wgExtensionMessagesFiles['WikiSync'] = $dir . '/WikiSync.i18n.php';
$wgExtensionMessagesFiles['WikiSyncAlias'] = $dir . '/WikiSync.alias.php';
$wgSpecialPages['WikiSync'] = 'WikiSyncPage';
$wgSpecialPageGroups['WikiSync'] = 'pagetools';

if ( !isset( $wgAutoloadClasses['FormatJson'] ) ) {
	// for MediaWiki 1.15.5
	class FormatJson {

		/**
		 * Returns the JSON representation of a value.
		 * 
		 * @param $value Mixed: the value being encoded. Can be any type except a resource.
		 * @param $isHtml Boolean
		 * 
		 * @return string
		 */
		public static function encode( $value, $isHtml = false ) {
			// Some versions of PHP have a broken json_encode, see PHP bug
			// 46944. Test encoding an affected character (U+20000) to
			// avoid this.
			if ( !function_exists( 'json_encode' ) || $isHtml || strtolower( json_encode( "\xf0\xa0\x80\x80" ) ) != '\ud840\udc00' ) {
				$json = new Services_JSON();
				return $json->encode( $value, $isHtml );
			} else {
				return json_encode( $value );
			}
		}

		/**
		 * Decodes a JSON string.
		 * 
		 * @param $value String: the json string being decoded.
		 * @param $assoc Boolean: when true, returned objects will be converted into associative arrays.
		 * 
		 * @return Mixed: the value encoded in json in appropriate PHP type.
		 * Values true, false and null (case-insensitive) are returned as true, false
		 * and &null; respectively. &null; is returned if the json cannot be
		 * decoded or if the encoded data is deeper than the recursion limit.
		 */
		public static function decode( $value, $assoc = false ) {
			if ( !function_exists( 'json_decode' ) ) {
				$json = new Services_JSON();
				$jsonDec = $json->decode( $value );
				if( $assoc ) {
					$jsonDec = wfObjectToArray( $jsonDec );
				}
				return $jsonDec;
			} else {
				return json_decode( $value, $assoc );
			}
		}

	}
}

WikiSyncSetup::init();

class WikiSyncSetup {

	const COOKIE_EXPIRE_TIME = 2592000; // 60 * 60 * 24 * 30; see also WikiSync.js, WikiSync.cookieExpireTime
	# please never change next value in between the synchronizations
	# otherwise null revisions created by ImportReporter::reportPage
	# will not be skipped, thus fake synchronizations might occur
	const WIKISYNC_BOT_NAME = 'WikiSyncBot';

	static $remote_wiki_user = self::WIKISYNC_BOT_NAME;
	static $report_null_revisions = false;
	# {{{ changable in LocalSettings.php :
	# debug mode (do not erase temporary XML dump files)
	static $debug_mode = false;
	static $remote_wiki_root = 'http://www.mediawiki.org/w';
	static $proxy_address = ''; # 'http://10.0.0.78:3128';
	# which user groups can synchronize from remote to local
	static $rtl_access_groups = array( 'user' );
	# which user groups can synchronize from local to remote
	static $ltr_access_groups = array( 'sysop', 'bureaucrat' );
	# }}}

	# {{{ decoded local proxy settings
	static $proxy_host = '';
	static $proxy_port = '';
	static $proxy_user = '';
	static $proxy_pass = '';
	# }}}

	static $version = '0.3.2'; // version of extension
	static $ExtDir; // filesys path with windows path fix
	static $ScriptPath; // apache virtual path

	static $user; // current User
	static $cookie_prefix; // an extension's cookie prefix for current User
	static $response; // an extension's WebResponse

	const JS_MSG_PREFIX = 'wikisync_js_';
	static $jsMessages = array(
		'last_op_error',
		'synchronization_confirmation',
		'synchronization_success',
		'already_synchronized',
		'sync_to_itself',
		'diff_search',
		'revision',
		'file_size_mismatch',
		'invalid_scheduler_time',
		'scheduler_countdown',
		'sync_start_ltr',
		'sync_start_rtl',
		'sync_end_ltr',
		'sync_end_rtl'
	);

	static function init() {
		global $wgScriptPath;
		global $wgAutoloadClasses;
		global $wgAjaxExportList;
		global $wgAPIModules;
		global $wgHooks;

		self::$ExtDir = str_replace( "\\", "/", dirname( __FILE__ ) );
		$top_dir = explode( '/', self::$ExtDir );
		$top_dir = array_pop( $top_dir );
		self::$ScriptPath = $wgScriptPath . '/extensions' . ( ( $top_dir == 'extensions' ) ? '' : '/' . $top_dir );

		if ( !isset( $wgAutoloadClasses['_QXML'] ) ) {
			$wgAutoloadClasses['_QXML'] = self::$ExtDir . '/WikiSyncQXML.php';
		}
		if ( !isset( $wgAutoloadClasses['FormatJson'] ) ) {
			$wgAutoloadClasses['FormatJson'] = self::$ExtDir . '/WikiSync.php';
		}
		$wgAutoloadClasses['Snoopy'] = self::$ExtDir . '/Snoopy/Snoopy.class.php';
		$wgAutoloadClasses['WikiSyncSetup'] = self::$ExtDir . '/WikiSync.php';
		$wgAutoloadClasses['WikiSnoopy'] =
		$wgAutoloadClasses['WikiSyncJSONresult'] =
		$wgAutoloadClasses['WikiSyncClient'] = self::$ExtDir . '/WikiSyncClient.php';
		$wgAutoloadClasses['WikiSyncPage'] = self::$ExtDir . '/WikiSyncPage.php';
		$wgAutoloadClasses['WikiSyncExporter'] =
		$wgAutoloadClasses['WikiSyncImportReporter'] = self::$ExtDir . '/WikiSyncExporter.php';
		$wgAutoloadClasses['ApiWikiSync'] =
		$wgAutoloadClasses['ApiRevisionHistory'] =
		$wgAutoloadClasses['ApiFindSimilarRev'] =
		$wgAutoloadClasses['ApiGetFile'] =
		$wgAutoloadClasses['ApiSyncImport'] = self::$ExtDir . '/WikiSyncApi.php';

		$wgAPIModules['revisionhistory'] = 'ApiRevisionHistory';
		$wgAPIModules['similarrev'] = 'ApiFindSimilarRev';
		$wgAPIModules['getfile'] = 'ApiGetFile';
		$wgAPIModules['syncimport'] = 'ApiSyncImport';

		$wgAjaxExportList[] = 'WikiSyncClient::remoteLogin';
		$wgAjaxExportList[] = 'WikiSyncClient::localAPIget';
		$wgAjaxExportList[] = 'WikiSyncClient::remoteAPIget';
		$wgAjaxExportList[] = 'WikiSyncClient::syncXMLchunk';
		$wgAjaxExportList[] = 'WikiSyncClient::findNewFiles';
		$wgAjaxExportList[] = 'WikiSyncClient::transferFileBlock';
		$wgAjaxExportList[] = 'WikiSyncClient::uploadLocalFile';

		$wgHooks['ResourceLoaderRegisterModules'][] = 'WikiSyncSetup::registerModules';

		if ( ($parsed_url = parse_url( self::$proxy_address )) !== false ) {
			if ( isset( $parsed_url['host'] ) ) { self::$proxy_host = $parsed_url['host']; }
			if ( isset( $parsed_url['port'] ) ) { self::$proxy_port = $parsed_url['port']; }
			if ( isset( $parsed_url['user'] ) ) { self::$proxy_user = $parsed_url['user']; }
			if ( isset( $parsed_url['pass'] ) ) { self::$proxy_pass = $parsed_url['pass']; }
		}
	}

	static function setJSprefix( $val ) {
		return self::JS_MSG_PREFIX . $val;
	}

	/**
	 * MW 1.17+ ResourceLoader module hook (JS,CSS)
	 */
	static function registerModules( $resourceLoader ) {
		global $wgExtensionAssetsPath;
		$localpath = dirname( __FILE__ );
		$remotepath = "$wgExtensionAssetsPath/WikiSync";
		$resourceLoader->register(
			array(
				'ext.wikisync' => new ResourceLoaderFileModule(
					array(
						'scripts' => array( 'md5.js', 'WikiSync_utils.js', 'WikiSync.js' ),
						'styles' => 'WikiSync.css',
						'messages' => array_map( array( 'self', 'setJSprefix' ), self::$jsMessages )
					),
					$localpath,
					$remotepath
				)
			)
		);
		return true;
	}

	/**
	 * include stylesheets and scripts; set javascript variables
	 * @param $outputPage - an instance of OutputPage
	 * @param $isRTL - whether the current language is RTL
	 */
	static function headScripts( &$outputPage, $isRTL ) {
		global $wgJsMimeType;
		if ( class_exists( 'ResourceLoader' ) ) {
#			$outputPage->addModules( 'jquery' );
			$outputPage->addModules( 'ext.wikisync' );
			return;
		}
		$outputPage->addLink(
			array( 'rel' => 'stylesheet', 'type' => 'text/css', 'href' => self::$ScriptPath . '/WikiSync.css?' . self::$version )
		);
		if ( $isRTL ) {
			$outputPage->addLink(
				array( 'rel' => 'stylesheet', 'type' => 'text/css', 'href' => self::$ScriptPath . '/WikiSync_rtl.css?' . self::$version )
			);
		}
		$outputPage->addScript(
			'<script type="' . $wgJsMimeType . '" src="' . self::$ScriptPath . '/md5.js?' . self::$version . '"></script>
			<script type="' . $wgJsMimeType . '" src="' . self::$ScriptPath . '/WikiSync_Utils.js?' . self::$version . '"></script>
			<script type="' . $wgJsMimeType . '" src="' . self::$ScriptPath . '/WikiSync.js?' . self::$version . '"></script>
			<script type="' . $wgJsMimeType . '">
				WikiSync.setLocalMessages(' . self::getJsObject( 'wsLocalMessages', self::$jsMessages ) . ');
			</script>
'
		);
	}

	static function getJsObject( $method_name, $jsMessages ) {
		$result = array();
		foreach ( $jsMessages as $arg ) {
			$arg = self::JS_MSG_PREFIX . $arg;
			$result[$arg] = wfMsg( $arg );
		}
		return FormatJson::encode( $result );
	}

	static function checkUserMembership( $groups ) {
		global $wgLang;
		$ug = self::$user->getEffectiveGroups();
		if ( !self::$user->isAnon() && !in_array( 'user', $ug ) ) {
			$ug[] = 'user';
		}
		if ( array_intersect( $groups, $ug ) ) {
			return true;
		}
		return wfMsgExt( 'wikisync_api_result_noaccess', array( 'parsemag' ), $wgLang->commaList( $groups ), count( $groups ) );
	}

	/**
	 * should not be called from LocalSettings.php
	 * should be called only when the wiki is fully initialized
	 * @param $direction defines the direction of synchronization
	 *     true - from remote to local wiki
	 *     false - from local to remote wiki
	 *     null - direction is undefined yet (any direction)
	 * @return true, when the current user has access to synchronization;
	 *     string error message, when the current user has no access
	 */
	static function initUser( $direction = null ) {
		global $wgUser, $wgRequest;
		self::$user = is_object( $wgUser ) ? $wgUser : new User();
		self::$response = $wgRequest->response();
		self::$cookie_prefix = 'WikiSync_' . md5( self::$user->getName() ) . '_';
		if ( self::$user->getName() !== self::WIKISYNC_BOT_NAME ) {
			return wfMsg( 'wikisync_unsupported_user', self::WIKISYNC_BOT_NAME );
		}
		if ( $direction === true ) {
			return self::checkUserMembership( self::$rtl_access_groups );
		} elseif ( $direction === false ) {
			return self::checkUserMembership( self::$ltr_access_groups );
		} elseif ( $direction === null ) {
			$groups = array_merge( self::$rtl_access_groups, self::$ltr_access_groups );
			return self::checkUserMembership( $groups );
		}
		return 'Bug: direction should be boolean or null, value (' . $direction . ') given in ' . __METHOD__;
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

	/**
	 * set a cookie which is accessible in javascript
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

} /* end of WikiSyncSetup class */
