<?php


$wgExtensionFunctions[] = "wfWikiaIrcGateway";

function wfWikiaIrcGateway() {
	global $wgParser, $wgExtensionMessagesFiles;
	$wgParser->setHook( "irclogin", "printWikiaIrcGatewayLoginForm" );
	$wgExtensionMessagesFiles['WikiaIrcGateway'] = dirname( __FILE__ ) . '/WikiaIrcGateway.i18n.php';
}

function printWikiaIrcGatewayLoginForm( $input, $argv ) {

	wfLoadExtensionMessages('WikiaIrcGateway');

$output = 
'
<form method="post" action="http://irc.wikia.com/irc.cgi" name="loginform" onsubmit="setjs();return nickvalid()">
	<input type="hidden" name="interface" value="nonjs">
	<input type="hidden" name="Server" value="irc.freenode.net" disabled="1">
	<table>
		<tr>
			<td> ' . wfMsg('ircgate-username') . '</td>
			<td>
				<input type="text" name="Nickname" value="">
				<input type="submit" value="Login">
			</td>
		</tr>
		<tr>
			<td>' . wfMsg('ircgate-channel') . '</td>
			<td>
				<select name="Channel">';

$array = explode( "\n* ", wfMsgForContent('ircgate-channellist') );

foreach ( $array as $channel ) {
	$output .= '<option>' . $channel . "</option>\n";
}

$output .= '				</select>
			</td>
		</tr>
	</table>   
</form>';

return $output;

}

