<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Userip extension\n";
	exit( 1 );
}

global $wgMessageCache;
SpecialPage::addPage( new Espionage );
$wgMessageCache->addMessage( 'espionage', 'Espionage' );

class Espionage extends SpecialPage {
	function Espionage() {
		SpecialPage::SpecialPage('Espionage', 'block');
	}
	
	function makelink($user, $time) {
			global $wgContLang, $wgLang;
			
			$ns_user = $wgContLang->getNsText( NS_USER );
			$ns_talk = $wgContLang->getNsText( NS_TALK );;
			$ns_user_talk = $wgContLang->getNsText( NS_USER_TALK );
			$sp_contrib = $wgContLang->specialPage( "Contributions" );
			$conmsg = wfMsg( 'contribslink' );

			$time = $wgLang->timeanddate( $time );
			
			return "$time: [[$ns_user:$user|$user]] ([[$ns_user_talk:$user|$ns_talk]] | [[$sp_contrib/$user|$conmsg]])";
	}

	function execute( $par = null ) {
		global $wgRequest, $wgOut, $wgTitle, $wgContLang, $wgLang, $wgPutIPinRC, $wgUser, $wgVersion;
		
		if ( ! $wgUser->isAllowed( 'block' ) ) {
			$wgOut->permissionRequired( 'block' );
			return;
		}
		
		if ( ! $wgPutIPinRC ) {
			$wgOut->fatalError('You must set $wgPutIPinRC to true in LocalSettings.php in order for this page to work.');
			return;
		}

		$this->setHeaders();

		$action = $wgTitle->escapeLocalUrl();
		$username = is_null($par) ? $wgRequest->getText( 'user' ) : strtr($par, '_', ' ');
		
		$wgOut->addHTML( "
<form id='espionage' method='post' action=\"$action\">
<table>
	<tr>
		<td align='right'>" . wfMsg('ipadressorusername') . "</td>
		<td align='left'>
			<input tabindex='1' type='text' size='20' name='user' value=\"" . htmlspecialchars($username) . "\" />
		</td>
	</tr>
	<tr>
		<td align='right'>&nbsp;</td>
		<td align='left'>
			<input type='submit' name='submit' value=\"" . wfMsg('go') . "\" />
		</td>
	</tr>
</table>
</form>");
		if ($username == '')
			return;

		$dbr =& wfGetDB( DB_READ );

		$ip = $wgUser->isIP($username);
		
		$username = $dbr->addQuotes( $username );
		$recentchanges = $dbr->tableName( 'recentchanges' );
		
		# SELECT MAX(rc_user_text) AS i,rc_timestamp FROM recentchanges GROUP BY rc_user_text ORDER BY i DESC;
		$sql = "SELECT rc_ip,rc_timestamp FROM $recentchanges WHERE rc_user_text = $username AND rc_ip != '' " .
			"GROUP BY rc_ip DESC ORDER BY rc_timestamp DESC";

		$res = $dbr->query( $sql, 'wfEspionage' );

		if ( mysql_num_rows($res) ) {
			$skin = $wgUser->getSkin();
			$out = "----\n";
			while ( $row = $dbr->fetchObject( $res ) ) {
				if (!$ip)
					$out .= '*' . $this->makelink($row->rc_ip, $row->rc_timestamp) . "\n";
				
				$sql2 = "SELECT rc_user_text,rc_timestamp FROM $recentchanges " .
					"WHERE (rc_ip != rc_user_text AND rc_ip = '$row->rc_ip' AND rc_user_text != $username) " .
					"GROUP BY rc_user_text DESC ORDER BY rc_timestamp";
				$res2 = $dbr->query( $sql2, 'wfEspionage' );
				while ( $row2 = $dbr->fetchObject($res2) ) {
					if (!$ip)
						$out .= '*';
					$out .= '*' . $this->makelink($row2->rc_user_text, $row2->rc_timestamp) . "\n";
				}
			}
			$wgOut->addWikiText($out);
		}
	}
}



