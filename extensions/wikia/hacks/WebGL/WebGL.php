<?php
/**
 * WebGL widget c - implements tag <cube> for showing webGL 3D cube 
 *
 * @author Andrzej P.Urbański <andrzej.urbanski(at)wikia-inc.com>

 * usage in wikia:
<cube width="500" height="500">
name of a wikia image from NS_FILE MAME SPACE (one to six each in seperate line
</cube>

 */

if(!defined('MEDIAWIKI')) {
	die();
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Cube',
	'author' => 'Andrzej P.Urbański',
	'url' => 'http://www.wikia.com' ,
	'description' => 'implements tag <cube> for webGL widget of cube 3D object',
	'descriptionmsg' => 'cube-desc'
);

$app = F::app();
$dir = dirname( __FILE__ );
$wgAutoloadClasses['CubeController'] =  $dir . '/CubeController.class.php';
/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfCube';
$wgExtensionMessagesFiles['Cube'] = dirname(__FILE__) . '/Cube.include.php';

function wfCube() {
	global $wgHooks, $wgAutoloadClasses;

	$dir = dirname(__FILE__) . '/';

	/**
	 * hooks
	 */
	$wgHooks['ParserFirstCallInit'][] = 'wfCubeInitParserHooks';
	$wgHooks['ParserAfterTidy'][] = 'Cube::replaceMarkers';

	/**
	 * classes
	 */
	$wgAutoloadClasses['Cube'] = $dir . 'Cube.class.php';
}

function wfCubeInitParserHooks( &$parser ) {

	$parser->setHook('cube','Cube::CubeParserHook');

	return true;
}
