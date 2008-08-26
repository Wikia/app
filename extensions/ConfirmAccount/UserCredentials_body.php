<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "ConfirmAccount extension\n";
	exit( 1 );
}

# Add messages
wfLoadExtensionMessages( 'ConfirmAccount' );

class UserCredentialsPage extends SpecialPage
{

    function __construct() {
        SpecialPage::SpecialPage('UserCredentials','lookupcredentials');
    }

    function execute( $par ) {
        global $wgRequest, $wgOut, $wgUser, $wgAccountRequestTypes;
        
		if( !$wgUser->isAllowed( 'lookupcredentials' ) ) {
			$wgOut->permissionRequired( 'lookupcredentials' );
			return;
		}
		
		$this->setHeaders();
		
		# A target user
		$this->target = $wgRequest->getText( 'target' );
		# Attachments
		$this->file = $wgRequest->getVal( 'file' );

		$this->skin = $wgUser->getSkin();

		if( $this->file ) {
			$this->showFile( $this->file );
		} else if( $this->target ) {
			$this->showForm();
			$this->showCredentials();
		} else {
			$this->showForm();
		}
	}
	
	function showForm() {
		global $wgOut, $wgTitle, $wgScript;
	
		$username = str_replace( '_', ' ', $this->target );
		$form = Xml::openElement( 'form', array( 'name' => 'stablization', 'action' => $wgScript, 'method' => 'get' ) );
		$form .= "<fieldset><legend>".wfMsg('usercredentials-leg')."</legend>";
		$form .= "<table><tr>";
		$form .= "<td>".Xml::hidden( 'title', $wgTitle->getPrefixedText() )."</td>";
		$form .= "<td>".wfMsgHtml("usercredentials-user")."</td>";
		$form .= "<td>".Xml::input('target', 35, $username, array( 'id' => 'wpUsername' ) )."</td>";
		$form .= "<td>".Xml::submitButton( wfMsg( 'go' ) )."</td>";
		$form .= "</tr></table>";
		$form .= "</fieldset></form>\n";
		
		$wgOut->addHTML( $form );
	}
	
	function showCredentials() {
		global $wgOut, $wgUser, $wgLang, $wgAccountRequestTypes;
		
		$titleObj = Title::makeTitle( NS_SPECIAL, "UserCredentials" );
		
		$row = $this->getRequest();
		if( !$row ) {
			$wgOut->addHTML( wfMsgHtml('usercredentials-badid') );
			return;
		}
		
		$wgOut->addWikiText( wfMsg( "usercredentials-text" ) );
		
		$user = User::newFromName( $this->target );
		
		$list = array();
		foreach( $user->getGroups() as $group )
			$list[] = self::buildGroupLink( $group );

		$grouplist = '';
		if( count( $list ) > 0 ) {
			$grouplist = '<tr><td>'.wfMsgHtml( 'usercredentials-member' ).'</td><td>'.implode( ', ', $list ).'</td></tr>';
		}
		
		$form  = "<fieldset>";
		$form .= '<legend>' . wfMsgHtml('usercredentials-leg-user') . '</legend>';
		$form .= '<table cellpadding=\'4\'>';
		$form .= "<tr><td>".wfMsgHtml('username')."</td>";
		$form .= "<td>".$this->skin->makeLinkObj( $user->getUserPage(), $user->getUserPage()->getText() )."</td></tr>\n";
		
		$econf = $row->acd_email_authenticated ? ' <strong>'.wfMsgHtml('confirmaccount-econf').'</strong>' : '';
		$form .= "<tr><td>".wfMsgHtml('usercredentials-email')."</td>";
		$form .= "<td>".htmlspecialchars($row->acd_email).$econf."</td></tr>\n";
		
		$form .= $grouplist;
		
		$form .= '</table></fieldset>';
		
		$areaSet = RequestAccountPage::expandAreas( $row->acd_areas );
		
		if( !wfEmptyMsg( 'requestaccount-areas', wfMsg('requestaccount-areas') ) ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml('confirmaccount-leg-areas') . '</legend>';
			
			$areas = explode("\n*","\n".wfMsg('requestaccount-areas'));
			$form .= "<div style='height:150px; overflow:scroll; background-color:#f9f9f9;'>";
			$form .= "<table cellspacing='5' cellpadding='0' style='background-color:#f9f9f9;'><tr valign='top'>";
			$count = 0;
			
			$att = array('disabled' => 'disabled');
			foreach( $areas as $area ) {
				$set = explode("|",$area,3);
				if( $set[0] && isset($set[1]) ) {
					$count++;
					if( $count > 5 ) {
						$form .= "</tr><tr valign='top'>";
						$count = 1;
					}
					$formName = "wpArea-" . htmlspecialchars(str_replace(' ','_',$set[0]));
					if( isset($set[1]) ) {
						$pg = $this->skin->makeKnownLink( $set[1], wfMsgHtml('requestaccount-info') );
					} else {
						$pg = '';
					}
					$form .= "<td>".wfCheckLabel( $set[0], $formName, $formName, in_array($formName,$areaSet), $att )." {$pg}</td>\n";
				}
			}
			$form .= "</tr></table></div>";
			$form .= '</fieldset>';
		}
		
		$form .= '<fieldset>';
		$form .= '<legend>' . wfMsgHtml('usercredentials-leg-person') . '</legend>';
		$form .= '<table cellpadding=\'4\'>';
		$form .= "<tr><td>".wfMsgHtml('usercredentials-real')."</td>";
		$form .= "<td>".htmlspecialchars($row->acd_real_name)."</td></tr>\n";
		$form .= '</table>';
		$form .= "<p>".wfMsgHtml('usercredentials-bio')."</p>";
		$form .= "<p><textarea tabindex='1' readonly='readonly' name='wpBio' id='wpNewBio' rows='10' cols='80' style='width:100%'>" .
			htmlspecialchars($row->acd_bio) .
			"</textarea></p>\n";
		$form .= '</fieldset>';
		
		$form .= '<fieldset>';
		$form .= '<legend>' . wfMsgHtml('usercredentials-leg-other') . '</legend>';
		$form .= '<p>'.wfMsgHtml('usercredentials-attach') . ' ';
		if( $row->acd_filename ) {
			$form .= $this->skin->makeKnownLinkObj( $titleObj, htmlspecialchars($row->acd_filename),
				'file=' . $row->acd_storage_key );
		} else {
			$form .= wfMsgHtml('confirmaccount-none-p');
		}
		$form .= "</p><p>".wfMsgHtml('usercredentials-notes')."</p>\n";
		$form .= "<p><textarea tabindex='1' readonly='readonly' name='wpNotes' id='wpNotes' rows='3' cols='80' style='width:100%'>" .
			htmlspecialchars($row->acd_notes) .
			"</textarea></p>\n";
		$form .= "<p>".wfMsgHtml('usercredentials-urls')."</p>\n";
		$form .= ConfirmAccountsPage::parseLinks($row->acd_urls);
		if( $wgUser->isAllowed( 'requestips' ) ) {
			$blokip = SpecialPage::getTitleFor( 'blockip' );
			$form .= "<p>".wfMsgHtml('usercredentials-ip')." ".htmlspecialchars($row->acd_ip)."</p>\n";
		}
		$form .= '</fieldset>';
		
		$wgOut->addHTML( $form );
	}
	
	/**
	 * Format a link to a group description page
	 *
	 * @param string $group
	 * @return string
	 */
	private static function buildGroupLink( $group ) {
		static $cache = array();
		if( !isset( $cache[$group] ) )
			$cache[$group] = User::makeGroupLinkHtml( $group, User::getGroupMember( $group ) );
		return $cache[$group];
	}
	
	/**
	 * Show a private file requested by the visitor.
	 */
	function showFile( $key ) {
		global $wgOut, $wgRequest;
		$wgOut->disable();
		
		# We mustn't allow the output to be Squid cached, otherwise
		# if an admin previews a private image, and it's cached, then
		# a user without appropriate permissions can toddle off and
		# nab the image, and Squid will serve it
		$wgRequest->response()->header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', 0 ) . ' GMT' );
		$wgRequest->response()->header( 'Cache-Control: no-cache, no-store, max-age=0, must-revalidate' );
		$wgRequest->response()->header( 'Pragma: no-cache' );
		
		$store = FileStore::get( 'accountcreds' );
		if( !$store ) {
			wfDebug( __METHOD__.": invalid storage group '{$store}'.\n" );
			return false;
		}
		$store->stream( $key );
	}
	
	function getRequest() {
		$uid = User::idFromName( $this->target );
		if( !$uid )
			return false;
		# For now, just get the first revision...
		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow( 'account_credentials', '*', 
			array( 'acd_user_id' => $uid ), 
			__METHOD__,
			array( 'ORDER BY' => 'acd_user_id,acd_id ASC' ) );
		return $row;
	}

}
