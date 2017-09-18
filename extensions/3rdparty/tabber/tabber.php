<?php

# Credits
$wgExtensionCredits['parserhook'][] = array(
    'name' => 'Tabber',
    'author' => 'Eric Fortin',
    'url' => 'http://www.mediawiki.org/wiki/Extension:Tabber',
    'description' => 'Create tabs that contain wiki compatible based data',
    'version' => '1.01'
);

// Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'wfTabber';

$wgResourceModules['ext.tabber'] = [
	'scripts' => [ 'tabber.js' ],
	'styles' => [ 'tabber.css' ],

	'localBasePath' => __DIR__,
	'remoteExtPath' => '3rdparty/tabber',
];

/**
 * @param Parser $parser
 * @return bool
 */
function wfTabber( Parser $parser ) {
	$parser->setHook( 'tabber', 'renderTabber' );
	return true;
}

function renderTabber( $paramstring, $params, Parser $parser ) {
	// Wikia change - add styles and scripts to output:
	$parser->getOutput()->addModules( 'ext.tabber' );

	$arr = explode( "|-|", $paramstring );
	$htmlTabs = Html::openElement( 'div', [ 'class' => 'tabber' ] );

	foreach ( $arr as $tab ) {
		$htmlTabs .= buildTab( $tab, $parser ); # macbre: pass Parser object (refs RT #34513)
	}

	return $htmlTabs . Html::closeElement( 'div' );
}

/**
 * @param $tab
 * @param Parser $parser
 * @return string
 */
function buildTab( $tab, $parser ) {
	if ( trim( $tab ) == '' ) return '';

	$arr = explode( "=", $tab );
	$tabName = array_shift( $arr );
	// Wikia Change Start @author aquilax
	$tabName = trim( $tabName );
	// Wikia Change End
	$tabBody = $parser->recursiveTagParse( implode( "=", $arr ) );

	$tab = Html::openElement( 'div', [
		'class' => 'tabbertab',
		'title' => $tabName
	] );

	$tab .= Html::rawElement( 'p', [], $tabBody );
	$tab .= Html::closeElement( 'div' );

	return $tab;
}
