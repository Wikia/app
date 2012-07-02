<?php
/**
 * API sandbox extension. Initial author Max Semenik, based on idea by Salil P. A.
 * License: WTFPL 2.0
 */
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ApiSandbox',
	'author' => array( 'Max Semenik' ),
	'url' => 'https://mediawiki.org/wiki/Extension:ApiSandbox',
	'descriptionmsg' => 'apisb-desc',
);

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['ApiSandbox'] = $dir . 'ApiSandbox.i18n.php';
$wgExtensionMessagesFiles['ApiSandboxAlias']  = $dir . 'ApiSandbox.alias.php';

$wgAutoloadClasses['SpecialApiSandbox'] = $dir . 'SpecialApiSandbox.php';

$wgSpecialPages['ApiSandbox'] = 'SpecialApiSandbox';
$wgSpecialPageGroups['ApiSandbox'] = 'wiki';

$wgResourceModules['ext.apiSandbox'] = array(
	'scripts' => 'ext.apiSandbox.js',
	'styles' => 'ext.apiSandbox.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'ApiSandbox',
	'messages' => array(
		'apisb-loading',
		'apisb-load-error',
		'apisb-request-error',
		'apisb-select-value',
		'apisb-docs-more',
		'apisb-params-param',
		'apisb-params-input',
		'apisb-params-desc',
		'apisb-ns-main',
		'apisb-example',
		'apisb-examples',
		'apisb-clear',
		'apisb-submit',
		'parentheses',
	),
	'dependencies' => array(
		'mediawiki.util',
		'jquery.ui.button',
	)
);

$wgHooks['APIGetDescription'][] = 'efASAPIGetDescription';

/**
 * @param $module ApiBase
 * @param $desc array
 * @return bool
 */
function efASAPIGetDescription( &$module, &$desc ) {
	if ( !$module instanceof ApiMain ) {
		return true;
	}

	$desc[] = 'The ApiSandbox extension is installed on this wiki, it adds a graphical interface to using the MediaWiki Api.';
	$desc[] = 'It is helpful for new users, allowing request debugging without any extra tools.';
	$desc[] = 'See ' . SpecialPage::getTitleFor( 'ApiSandbox' )->getCanonicalURL();

	// Append some more whitespace for ApiMain
	for ( $i = 0; $i < 3; $i++ ) {
		$desc[] = '';
	}
	return true;
}
