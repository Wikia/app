<?php
/**
 * WikiaIrcGateway
 *
 * Allows users to add an IRC gateway login form to any article
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2009-05-19
 * @copyright Copyright © 2009 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named WikiaIrcGateway.\n";
        exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Wikia IRC Gateway',
	'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
	'description' => 'Lets users insert IRC login form on any page'
);

$wgExtensionMessagesFiles['WikiaIrcGateway'] = dirname( __FILE__ ) . '/WikiaIrcGateway.i18n.php';
$wgHooks['ParserFirstCallInit'][] = "wfWikiaIrcGateway";

/**
 * @param Parser $parser
 * @return bool
 */
function wfWikiaIrcGateway( $parser ) {
	$parser->setHook( "irclogin", "printWikiaIrcGatewayLoginForm" );
	return true;
}

function printWikiaIrcGatewayLoginForm( $input, $argv ) {

	#only do this once per page;
	global $GatewayOnPage;
	if( !empty($GatewayOnPage) ) {
		return '';
	}
	$GatewayOnPage = true;

	$output = '<div id="ircform_container">
<form id="ircform" method="get" action="http://irc.wikia.com/" name="loginform">
	<table>
		<tr>
			<td> ' . wfMsg('ircgate-username') . '</td>
			<td>
				<input type="text" name="nick" value="">
				<input type="submit" value="Login">
			</td>
		</tr>
		<tr>
			<td>' . wfMsg('ircgate-channel') . '</td>
			<td>
				<select name="channels">';

	$array = explode( "\n*", wfMsgForContent('ircgate-channellist') );

	foreach ( $array as $line ) {
		if ( strpos( ltrim( $line, '* ' ), 'group: ' ) === 0 ) {
			$output .= '<optgroup label="' . htmlspecialchars( substr( ltrim( $line, '* ' ), 7 ) ) . '">';
		} elseif ( strpos( ltrim( $line, '* ' ), 'group-end' ) === 0 ) {
			$output .= "</optgroup>\n";
		} else {
			$output .= '<option>' . htmlspecialchars( ltrim( $line, '* ') ) . "</option>\n";
		}
	}

	$output .= '			</select>
			</td>
		</tr>
	</table>
</form>
</div>';

	return $output;

}
