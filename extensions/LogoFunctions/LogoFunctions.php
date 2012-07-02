<?php
/**
 * LogoFunctions
 *
 * Add parser function about wiki's logo
 *
 * @link http://www.mediawiki.org/wiki/Extension:LogoFunctions
 *
 * @author Devunt <devunt@devunt.kr>
 * @authorlink http://www.mediawiki.org/wiki/User:Devunt
 * @copyright Copyright © 2010 Devunt (Bae June Hyeon).
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
 
if ( !defined( 'MEDIAWIKI' ) ) die('define error!');
 
$wgExtensionCredits[ 'parserhook' ][] = array(
	'path'            => __FILE__,
	'name'           => 'LogoFunctions',
	'author'         => 'Devunt (Bae June Hyeon)',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:LogoFunctions',
	'descriptionmsg' => 'logofunctions-desc',
	'version'        => '0.9.1',
);

$dir = dirname( __FILE__ ) . '/';

// internationalization
$wgExtensionMessagesFiles['LogoFunctions'] = $dir . 'LogoFunctions.i18n.php';
$wgExtensionMessagesFiles['LogoFunctionsMagic'] = $dir . 'LogoFunctions.i18n.magic.php';

$wgHooks['ParserFirstCallInit'][] = 'efLogoFunctions_Setup';
 
function efLogoFunctions_Setup( &$parser ) {
	$parser->setFunctionHook( 'setlogo', 'efSetLogo_Render' );
	$parser->setFunctionHook( 'getlogo', 'efGetLogo_Render' );
	return true;
}

function efSetLogo_Render( $parser, $logo = '' ) {
	global $wgLogo;
	$imageobj = wfFindFile( $logo );
	if ( $imageobj == null ) {
		return Html::element( 'strong', array( 'class' => 'error' ), 
			wfMsgForContent( 'logofunctions-filenotexist', htmlspecialchars( $logo ) )
		);
	}
	$thumb_arr = array(
		'width' => 135,
		'height' => 135
	);
	$thumb = $imageobj->transform( $thumb_arr );
	$wgLogo = $thumb->getUrl();
}

function efGetLogo_Render( $parser, $prefix = false ) {
	global $wgLogo;
	return ($prefix?$prefix.':':'').basename($wgLogo);
}