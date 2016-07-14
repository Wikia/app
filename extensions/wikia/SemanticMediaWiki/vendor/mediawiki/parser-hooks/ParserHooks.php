<?php
/**
 * Initialization file for the ParserHooks MediaWiki extension.
 *
 * https://github.com/JeroenDeDauw/ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( defined( 'ParserHooks_VERSION' ) ) {
	// Do not initialize more than once.
	return 1;
}

define( 'ParserHooks_VERSION', '1.4.0' );

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	include_once( __DIR__ . '/vendor/autoload.php' );
}

// Only initialize the extension when all dependencies are present.
if ( !defined( 'ParamProcessor_VERSION' ) ) {
	throw new Exception( 'You need to have the ParamProcessor library loaded in order to use ParserHooks' );
}

call_user_func( function() {
	global $wgExtensionCredits, $wgExtensionMessagesFiles, $wgHooks, $wgMessagesDirs;

	$wgExtensionCredits['other'][] = array(
		'path' => __FILE__,
		'name' => 'ParserHooks',
		'version' => ParserHooks_VERSION,
		'author' => array(
			'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
		),
		'url' => 'https://github.com/JeroenDeDauw/ParserHooks',
		'descriptionmsg' => 'parserhooks-desc'
	);

	$wgMessagesDirs['ParserHooksExtension'] = __DIR__ . '/i18n';
	$wgExtensionMessagesFiles['ParserHooksExtension'] = __DIR__ . '/ParserHooks.i18n.php';

	/**
	 * Hook to add PHPUnit test cases.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
	 *
	 * @since 1.0
	 *
	 * @param array $files
	 *
	 * @return boolean
	 */
	$wgHooks['UnitTestsList'][]	= function( array &$files ) {
		$directoryIterator = new RecursiveDirectoryIterator( __DIR__ . '/tests/' );

		/**
		 * @var SplFileInfo $fileInfo
		 */
		foreach ( new RecursiveIteratorIterator( $directoryIterator ) as $fileInfo ) {
			if ( substr( $fileInfo->getFilename(), -8 ) === 'Test.php' ) {
				$files[] = $fileInfo->getPathname();
			}
		}

		return true;
	};

} );
// @codeCoverageIgnoreEnd
