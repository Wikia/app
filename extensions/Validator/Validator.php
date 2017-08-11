<?php

/**
 * Initialization file for the Validator MediaWiki extension.
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( defined( 'ParamProcessor_VERSION' ) ) {
	// Do not initialize more than once.
	return 1;
}

define( 'Validator_VERSION', '2.2.1' );
define( 'ParamProcessor_VERSION', Validator_VERSION ); // @deprecated since 1.0

// Internationalization
$GLOBALS['wgMessagesDirs']['Validator'] = __DIR__ . '/i18n';
$GLOBALS['wgExtensionMessagesFiles']['Validator'] = __DIR__ . '/Validator.i18n.php';


$GLOBALS['wgExtensionFunctions'][] = function () {
	if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
		include_once( __DIR__ . '/vendor/autoload.php' );
	}

	if ( !class_exists( ParamProcessor\Processor::class ) ) {
		throw new Exception( 'Validator depends on the ParamProcessor library.' );
	}

	// Display extension information
	$GLOBALS['wgExtensionCredits']['other'][] = [
		'path' => __FILE__,
		'name' => 'Validator',
		'version' => Validator_VERSION,
		'author' => [
			'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]'
		],
		'url' => 'https://github.com/JeroenDeDauw/Validator',
		'descriptionmsg' => 'validator-desc',
		'license-name' => 'GPL-2.0+'
	];

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
	$GLOBALS['wgHooks']['UnitTestsList'][]	= function( array &$files ) {
		// @codeCoverageIgnoreStart
		$directoryIterator = new RecursiveDirectoryIterator( __DIR__ . '/tests/phpunit/' );

		/**
		 * @var SplFileInfo $fileInfo
		 */
		foreach ( new RecursiveIteratorIterator( $directoryIterator ) as $fileInfo ) {
			if ( substr( $fileInfo->getFilename(), -8 ) === 'Test.php' ) {
				$files[] = $fileInfo->getPathname();
			}
		}

		return true;
		// @codeCoverageIgnoreEnd
	};

	$GLOBALS['wgDataValues']['mediawikititle'] = ParamProcessor\MediaWikiTitleValue::class;

	$GLOBALS['wgParamDefinitions']['title'] = [
		'string-parser' => ParamProcessor\TitleParser::class,
		'validator' => ValueValidators\TitleValidator::class,
	];
};

