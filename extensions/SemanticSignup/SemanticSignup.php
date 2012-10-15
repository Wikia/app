<?php
/**
 * Initialization file for the Semantic Signup extension.
 *
 * Documentation:	 		http://www.mediawiki.org/wiki/Extension:SemanticSignup
 * Support					http://www.mediawiki.org/wiki/Extension_talk:SemanticSignup
 * Source code:			    http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/SemanticSignup
 *
 * @file SemanticSignup.php
 * @ingroup SemanticSignup
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documenation group collects source code files belonging to SemanticSignup.
 *
 * @defgroup SemanticSignup SemanticSignup
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.16', '<' ) ) {
	die( '<b>Error:</b> SemanticSignup requires MediaWiki 1.16 or above.' );
}

// Show a warning if Semantic MediaWiki is not loaded.
if ( !defined( 'SMW_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://semantic-mediawiki.org/wiki/Semantic_MediaWiki">Semantic MediaWiki</a> installed in order to use SemanticSignup.' );
}

if ( version_compare( SMW_VERSION, '1.5 alpha', '<' ) ) {
	die( '<b>Error:</b> Semantic Signup requires Semantic MediaWiki 1.5 or above.' );
}

if ( !defined( 'SF_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://semantic-mediawiki.org/wiki/Semantic_Forms">Semantic Forms</a> installed in order to use SemanticSignup.' );
}

define( 'SemanticSignup_VERSION', '0.4 alpha' );

$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'SemanticSignup',
	'version' => SemanticSignup_VERSION,
	'author' => array(
		'Serg Kutny',
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Semantic_Watchlist',
	'descriptionmsg' => 'ses-desc'
);

$wgExtensionMessagesFiles['SemanticSignup'] = dirname( __FILE__ ) . '/SemanticSignup.i18n.php';
$wgExtensionMessagesFiles['SemanticSignupMagic'] = dirname( __FILE__ ) . '/SemanticSignup.i18n.magic.php';
$wgExtensionMessagesFiles['SemanticSignupAlias'] = dirname( __FILE__ ) . '/SemanticSignup.i18n.aliases.php';

$wgAutoloadClasses['SemanticSignupSettings'] = dirname( __FILE__ ) . '/SemanticSignup.settings.php';
$wgAutoloadClasses['SemanticSignupHooks'] = dirname( __FILE__ ) . '/SemanticSignup.hooks.php';
$wgAutoloadClasses['SemanticSignup'] = dirname( __FILE__ ) . '/includes/SES_Special.php';
$wgAutoloadClasses['SES_UserAccountDataChecker'] = dirname( __FILE__ ) . '/includes/SES_Special.php';
$wgAutoloadClasses['SES_DataChecker'] = dirname( __FILE__ ) . '/includes/SES_DataChecker.php';
$wgAutoloadClasses['SES_UserAccountDataChecker'] = dirname( __FILE__ ) . '/includes/SES_UserAccountDataChecker.php';
$wgAutoloadClasses['SES_SignupFields'] = dirname( __FILE__ ) . '/includes/SES_SignupFields.php';
$wgAutoloadClasses['CreateUserFieldsTemplate'] = dirname( __FILE__ ) . '/includes/SES_SignupFields.php';

$wgSpecialPages['SemanticSignup'] = 'SemanticSignup';

$egSemanticSignupSettings = array();

$wgHooks['UserCreateForm'][] = 'SemanticSignupHooks::onUserCreateForm';
$wgHooks['ParserFirstCallInit'][] = 'SemanticSignupHooks::onParserFirstCallInit';
