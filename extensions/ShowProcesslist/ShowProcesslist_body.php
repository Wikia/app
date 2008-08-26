<?php

class ShowProcesslistPage extends UnlistedSpecialPage {
	function ShowProcesslistPage() {
		SpecialPage::SpecialPage('ShowProcesslist', 'siteadmin');
		wfLoadExtensionMessages( 'showprocesslist' );
	}

	function execute( $par ) {
		global $wgOut, $wgUser;

		$this->setHeaders();
		if ( !$wgUser->isAllowed( 'siteadmin' ) ) {
			$wgOut->permissionRequired( 'siteadmin' );
			return;
		}

		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->query( 'SHOW FULL PROCESSLIST' );
		$output = array();
		$output = '<table border="1" cellspacing="0">'."\n";
		$output .= '<tr><th>'.wfMsg('showprocesslist-id').'</th><th>'.wfMsg ('showprocesslist-user').'</th><th>'.wfMsg ('showprocesslist-host').'</th><th>'.wfMsg ('showprocesslist-db').'</th><th>'.wfMsg ('showprocesslist-command').'</th><th>'.wfMsg('showprocesslist-time').'</th><th>'.wfMsg('showprocesslist-state').'</th><th>'.wfMsg('showprocesslist-info').'</th>'."\n";
		while ( $row = $dbr->fetchObject($res) ) {
			$output .= '<tr>';
			$fields = get_object_vars($row);
			foreach ($fields as $value ) {
				$output .= '<td>' . htmlspecialchars( $value ) . '</td>';
			}
			$output .= "</tr>\n";
		}
		$output .= '</table>';
		$wgOut->addHTML( $output );
	}
}
