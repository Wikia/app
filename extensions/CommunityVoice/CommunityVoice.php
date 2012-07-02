<?php
/**
 * CommunityVoice extension
 *
 * @file
 * @ingroup Extensions
 *
 * This is the main include file for the CommunityVoice extension.
 *
 * Installation: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/CommunityVoice/CommunityVoice.php" );
 *
 * This extension depends on the ClientSide extension, which provides functions
 * for generating code in client-side formats such as HTML, CSS and JavaScript
 *
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * @license GPL v2
 * @version 0.1.0
 */

// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo ( "This is a MediaWiki extension and cannot be run standalone.\n" );
	die ( 1 );
}

/* Configuration */

// Web-accessable resource path
// Defaults to $wgExtensionAssetsPath . '/CommunityVoice/Resources'
$egCommunityVoiceResourcesPath = null;

/* MediaWiki Integration */

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CommunityVoice',
	'author' => 'Trevor Parscal',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CommunityVoice',
	'descriptionmsg' => 'communityvoice-desc',
	'version' => '0.1.0',
);
// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';
// Internationalization
$wgExtensionMessagesFiles['CommunityVoice'] = $dir . 'CommunityVoice.i18n.php';
// Class Autoloading
$wgAutoloadClasses['CommunityVoice'] = $dir . 'CommunityVoice.php';
$wgAutoloadClasses['CommunityVoicePage'] = $dir . 'CommunityVoice.page.php';
$wgAutoloadClasses['CommunityVoiceRatings'] = $dir . 'Modules/Ratings.php';
// Spacial Pages
$wgSpecialPages['CommunityVoice'] = 'CommunityVoicePage';
// Setup Hooks
$wgExtensionFunctions[] = 'CommunityVoice::registerModules';
$wgExtensionFunctions[] = 'CommunityVoice::setupVars';
$wgHooks['BeforePageDisplay'][] = 'CommunityVoice::addStyles';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'CommunityVoice::LoadExtensionSchemaUpdates';

/* Classes */

abstract class CommunityVoice {

	/* Private Static Members */

	private static $modules = array(
		'Ratings' => array( 'class' => 'CommunityVoiceRatings' )
	);
	private static $messagesLoaded = false;

	/* Static Functions */

	public static function getModules() {
		return array_keys( self::$modules );
	}

	public static function setupVars() {
		// Web-accessable resource path
		global $egCommunityVoiceResourcesPath, $wgExtensionAssetsPath;
		if ( $egCommunityVoiceResourcesPath === null ) {
			$egCommunityVoiceResourcesPath = $wgExtensionAssetsPath .
				'/CommunityVoice/Resources';
		}
	}

	public static function callModuleAction(
		$module,
		$type,
		$action = '',
		$path = ''
	) {
		// Checks for class
		if ( isset( self::$modules[$module] ) ) {
			if ( class_exists( self::$modules[$module]['class'] ) ) {
				// Builds function
				$function = array(
					self::$modules[$module]['class'], $type . $action
				);
				// Checks callability
				if ( is_callable( $function ) ) {
					// Calls function on class
					return call_user_func( $function, $path );
				} else {
					// Throws unfound/uncallable function exception
					throw new MWException(
						implode( '::', $function ) .
						' was not found or is not callable!'
					);
				}
			} else {
				// Throws non-existant class exception
				throw new MWException(
					self::$modules[$module]['class'] . ' is not a class!'
				);
			}
		} else {
			// Throws non-existant module exception
			throw new MWException( $module . ' is not a module!' );
		}
	}

	/**
	 * Registers modules with MediaWiki
	 */
	public static function registerModules() {
		// Loops over each module
		foreach( self::getModules() as $module ) {
			self::callModuleAction( $module, 'register' );
		}
		return true;
	}

	public static function getMessage(
		$module,
		$message,
		$parameter = null
	) {
		// Returns message
		return wfMsg( 'communityvoice-' . $module . '-' . $message, $parameter );
	}

	public static function getMessageParse(
		$module,
		$message
	) {
		// Gets variadic parameters
		$parameters = func_get_args();
		// Less the first two
		array_shift( $parameters );
		array_shift( $parameters );
		// Returns message
		return wfMsgExt(
			'communityvoice-' . $module . '-' . $message,
			array( 'parsemag' ),
			$parameters
		);
	}
	
	/**
	 * Adds scripts to document.
	 * This used to run from AjaxAddScript hook, but now runs
	 * from parser tag.
	 */
	public static function addScripts(
		$out
	) {
		global $wgJsMimeType;
		global $egCommunityVoiceResourcesPath;
		if ( !$out->hasHeadItem( 'CommunityVoice' ) ) {
			$out->addInlineScript(
				sprintf(
					"var egCommunityVoiceResourcesPath = '%s';\n" ,
					Xml::escapeJsString( $egCommunityVoiceResourcesPath )
				)
			);
			$out->addScript(
				Xml::element(
					'script',
					array(
						'type' => $wgJsMimeType,
						'src' => $egCommunityVoiceResourcesPath .
							'/CommunityVoice.js'
					),
					'',
					false
				)
			);
			// Hack to prevent double inclusion because.
			$out->addHeadItem( 'CommunityVoice', '' );
		}
		return true;
	}

	/**
	 * Adds styles to document
	 */
	public static function addStyles(
		$out
	) {
		global $egCommunityVoiceResourcesPath;
		$out->addLink(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => $egCommunityVoiceResourcesPath . '/CommunityVoice.css'
			)
		);
		return true;
	}

	/**
	 * As an alternative to the command line script, hook into update.php.
	 * This might not work for non-mysql db's.
	 */
	public static function loadExtensionSchemaUpdates(
		$updater = null
	) {
		global $wgDBtype;
		$dir = dirname( __FILE__ );
		if ( $updater ) {
			$updater->addExtensionTable( 'cv_ratings_votes', "$dir/CommunityVoice.sql" );
		} else {
			global $wgExtNewTables;
			$wgExtNewTables[] = array( 'cv_ratings_votes', "$dir/CommunityVoice.sql" );
		}
		return true;
	}
}
