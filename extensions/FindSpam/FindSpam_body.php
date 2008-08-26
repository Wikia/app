<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FindSpam extension\n";
	exit( 1 );
}

wfLoadExtensionMessages( 'FindSpam' );

class FindSpamPage extends SpecialPage {

	function FindSpamPage() {
		SpecialPage::SpecialPage( 'FindSpam', 'findspam' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgTitle, $wgLocalDatabases, $wgUser;
		global $wgConf, $wgCanonicalNamespaceNames, $wgLang;
		$this->setHeaders();

		# Check permissions
		if( !$wgUser->isAllowed( 'findspam' ) ) {
			$wgOut->permissionRequired( 'findspam' );
			return;
		}

		$ip = $wgRequest->getText( 'ip' );

		# Show form
		$self = Title::makeTitle( NS_SPECIAL, 'FindSpam' );
		$form  = wfOpenElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= '<table><tr><td align="right">' . wfMsgHtml( 'findspam-ip' ) . '</td>';
		$form .= '<td>' . wfInput( 'ip', 50, $ip ) . '</td></tr>';
		$form .= '<tr><td></td><td>' . wfSubmitButton( wfMsg( 'findspam-ok' ) ) . '</td></tr></table></form>';
		$wgOut->addHtml( $form );

		if ( $ip ) {
			$dbr =& wfGetDB( DB_READ );
			$s  = '';

			foreach ( $wgLocalDatabases as $db ) {
				$sql = "SELECT rc_namespace,rc_title,rc_timestamp,rc_user_text,rc_last_oldid FROM $db.recentchanges WHERE rc_ip='" . $dbr->strencode( $ip ) .
				  "' AND rc_this_oldid=0";
				$res = $dbr->query( $sql, "findspam.php" );
				list( $site, $lang ) = $wgConf->siteFromDB( $db );
				if ( $lang == 'meta' ) {
					$baseUrl = "http://meta.wikimedia.org";
				} else {
					$baseUrl = "http://$lang.$site.org";
				}

				if ( $dbr->numRows( $res ) ) {
					$s .= "\n$db\n";
					while ( $row = $dbr->fetchObject( $res ) ) {

						if ( $row->rc_namespace == 0 ){
							$title = $row->rc_title;
						} else {
							$title = $wgCanonicalNamespaceNames[$row->rc_namespace] . ':' .$row->rc_title;
						}
						$encTitle = urlencode( $title );
						$url = "$baseUrl/wiki/$encTitle";
						$user = urlencode( $row->rc_user_text );
						#$rollbackText = wfMsg( 'rollback' );
						$diffText = wfMsg( 'diff' );
						#$rollbackUrl = "$baseUrl/w/wiki.phtml?title=$encTitle&action=rollback&from=$user";
						$diffUrl = "$baseUrl/w/wiki.phtml?title=$encTitle&diff=0&oldid=0";
						if ( $row->rc_last_oldid ) {
							$lastLink = "[$baseUrl/w/wiki.phtml?title=$encTitle&oldid={$row->rc_last_oldid}&action=edit last]";
						}

						$date = $wgLang->timeanddate( $row->rc_timestamp );
						#$s .= "* $date [$url $title] ([$rollbackUrl $rollbackText] | [$diffUrl $diffText])\n";
						$s .= "* $date [$url $title] ($lastLink | [$diffUrl $diffText])\n";
					}
				}
			}
			if ( $s == '' ) {
				$s = wfMsg('findspam-notextfound');
			}
			$wgOut->addWikiText( $s."<br />" );
		}
	}
}
