<?php

$wgExtensionCredits['parserhook'][] = array(
	'name'         => 'UrlGetParameters',
	'version'      => '1.3.0', // Jan. 19, 2012
	'descriptionmsg'  => '',
	'author'       => 'S.O.E. Ansems',
	'url'          => 'https://www.mediawiki.org/wiki/Extension:UrlGetParameters',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['UrlGetParameters'] = $dir . 'UrlGetParameters.i18n.php';
$wgExtensionMessagesFiles['UrlGetParametersMagic'] = $dir . 'UrlGetParameters.i18n.magic.php';

$wgHooks['ParserFirstCallInit'][] = 'urlGetParameters_Setup';

/**
 * @param $parser Parser
 * @return void
 */
function urlGetParameters_Setup( $parser ) {
	$parser->setFunctionHook( 'urlget', 'urlGetParameters_Render' );
	return true;
}

/**
 * @param $parser Parser
 * @return string
 */
function urlGetParameters_Render( $parser ) {
	// {{#urlget:paramname|defaultvalue}}

	// Get the parameters that were passed to this function
	$params = func_get_args();
	array_shift( $params );

	// Cache needs to be disabled for URL parameters to be retrieved correctly
	$parser->disableCache();

	// Check whether this param is an array, i.e. of the form "a[b]"
	$pos_left_bracket = strpos( $params[0], '[' );
	$pos_right_bracket = strpos( $params[0], ']' );

	if ( !$pos_left_bracket || !$pos_right_bracket ) {
		// Not an array
		if ( isset($_GET[$params[0]] ) ) {
			return rawurlencode( $_GET[$params[0]] );
		}
	} else {
		// It's an array
		$key = substr( $params[0], 0, $pos_left_bracket );
		$value = substr($params[0], $pos_left_bracket + 1, ( $pos_right_bracket - $pos_left_bracket - 1 ) );

		if ( isset( $_GET[$key] ) && isset( $_GET[$key][$value] ) ) {
			return rawurlencode( $_GET[$key][$value] );
		}
	}
	if ( count( $params ) > 1 ) {
		return rawurlencode( $params[1] );
	}

	return '';
}
