<?php

use SMW\Scribunto\HookRegistry;

/**
 * @see https://github.com/SemanticMediaWiki/SemanticScribunto/
 *
 * @defgroup SemanticScribunto Semantic Scribunto
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is part of the Semantic Scribunto extension, it is not a valid entry point.' );
}

if ( defined( 'SMW_SCRIBUNTO_VERSION' ) ) {
	// Do not initialize more than once.
	return 1;
}

SemanticScribunto::load();

/**
 * @codeCoverageIgnore
 */
class SemanticScribunto {

	/**
	 * @since 1.0
	 *
	 * @note It is expected that this function is loaded before LocalSettings.php
	 * to ensure that settings and global functions are available by the time
	 * the extension is activated.
	 */
	public static function load() {

		if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
			include_once __DIR__ . '/vendor/autoload.php';
		}

		// In case extension.json is being used, the the succeeding steps will
		// be handled by the ExtensionRegistry
		self::initExtension();

		$GLOBALS['wgExtensionFunctions'][] = function() {
			self::onExtensionFunction();
		};
	}

	/**
	 * @since 1.0
	 */
	public static function initExtension() {

		define( 'SMW_SCRIBUNTO_VERSION', '1.1.0-alpha' );

		// Register extension info
		$GLOBALS['wgExtensionCredits']['semantic'][] = [
			'path'           => __FILE__,
			'name'           => 'Semantic Scribunto',
			'author'         => [
				'James Hong Kong',
				'[https://www.semantic-mediawiki.org/wiki/User:Oetterer Tobias Oetterer]',
			],
			'url'            => 'https://github.com/SemanticMediaWiki/SemanticScribunto/',
			'descriptionmsg' => 'smw-scribunto-desc',
			'version'        => SMW_SCRIBUNTO_VERSION,
			'license-name'   => 'GPL-2.0+',
		];

		// Register message files
		$GLOBALS['wgExtensionMessagesFiles']['SemanticScribunto'] = __DIR__ . '/SemanticScribunto.i18n.php';
	}

	/**
	 * @since 1.0
	 */
	public static function onExtensionFunction() {
		$hookRegistry = new HookRegistry();
		$hookRegistry->register();
	}

	/**
	 * @since 1.0
	 *
	 * @param string|null $dependency
	 *
	 * @return string|null
	 */
	public static function getVersion( $dependency = null ) {

		if ( $dependency === null && defined( 'SMW_SCRIBUNTO_VERSION' ) ) {
			return SMW_SCRIBUNTO_VERSION;
		}

		if ( $dependency === 'SMW' && defined( 'SMW_VERSION' ) ) {
			return SMW_VERSION;
		}

		if ( $dependency === 'Lua' && method_exists( 'Scribunto_LuaStandaloneInterpreter', 'getLuaVersion' ) ) {
			return Scribunto_LuaStandaloneInterpreter::getLuaVersion( [ 'luaPath' => null ] );
		}

		return null;
	}

}
