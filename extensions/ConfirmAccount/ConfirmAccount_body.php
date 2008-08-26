<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "ConfirmAccount extension\n";
	exit( 1 );
}

# Add messages
wfLoadExtensionMessages( 'ConfirmAccount' );

class ConfirmAccountsPage extends SpecialPage
{

    function __construct() {
        SpecialPage::SpecialPage('ConfirmAccounts','confirmaccount');
    }

    function execute( $par ) {
        global $wgRequest, $wgOut, $wgUser, $wgAccountRequestTypes;
        
		if( !$wgUser->isAllowed( 'confirmaccount' ) ) {
			$wgOut->permissionRequired( 'confirmaccount' );
			return;
		}
		if( !$wgUser->getID() ) {
			$wgOut->permissionRequired( 'user' );
			return;
		}
		
		$this->setHeaders();
		
		$this->specialPageParameter = $par;
		# Use the special page param to act as a super type.
		# Convert this to its integer form.
		$this->queueType = -1;
		foreach( $wgAccountRequestTypes as $i => $params ) {
			if( $params[0] == $par ) {
				$this->queueType = $i;
				break;
			}
		}
		
		# A target user
		$this->acrID = $wgRequest->getIntOrNull( 'acrid' );
		# Attachments
		$this->file = $wgRequest->getVal( 'file' );
		# For renaming to alot for collisions with other local requests
		# that were added to some global $wgAuth system first.
		$this->mUsername = trim( $wgRequest->getText( 'wpNewName' ) );
		# Position sought
		$this->mType = $wgRequest->getIntOrNull( 'wpType' );
		$this->mType = ( !is_null($this->mType) && isset($wgAccountRequestTypes[$this->mType]) ) ? 
			$this->mType : null;
		# For removing private info or such from bios
		$this->mBio = $wgRequest->getText( 'wpNewBio' );
		# Held requests hidden by default
		$this->showHeld = $wgRequest->getBool( 'wpShowHeld' );
		# Show stale requests
		$this->showStale = $wgRequest->getBool( 'wpShowStale' );
		# For viewing rejected requests (stale requests count as rejected)
		$this->showRejects = $wgRequest->getBool( 'wpShowRejects' );

		$this->submitType = $wgRequest->getVal( 'wpSubmitType' );
		$this->reason = $wgRequest->getText( 'wpReason' );
		
		# Load areas user plans to be active in...
		$this->mAreas = $this->mAreaSet = array();
		if( !wfEmptyMsg( 'requestaccount-areas', wfMsg('requestaccount-areas') ) ) {
			$areas = explode("\n*","\n".wfMsg('requestaccount-areas'));
			foreach( $areas as $area ) {
				$set = explode("|",$area,2);
				if( $set[0] && isset($set[1]) ) {
					$formName = "wpArea-" . htmlspecialchars(str_replace(' ','_',$set[0]));
					$this->mAreas[$formName] = $wgRequest->getInt( $formName, -1 );
					# Make a simple list of interests
					if( $this->mAreas[$formName] > 0 )
						$this->mAreaSet[] = str_replace( '_', ' ', $set[0] );
				}
			}
		}

		$this->skin = $wgUser->getSkin();
		
		$titleObj = Title::makeTitle( NS_SPECIAL, "ConfirmAccounts/{$this->specialPageParameter}" );
		
		# Show other sub-queue links. Grey out the current one.
		# When viewing a request, show them all.
		if( $this->acrID || $this->showStale || $this->showRejects || $this->showHeld ) {
			$listLink = $this->skin->makeKnownLinkObj( $titleObj, wfMsgHtml( 'confirmaccount-showopen' ) );
		} else {
			$listLink = wfMsgHtml( 'confirmaccount-showopen' );
		}
		if( $this->acrID || !$this->showHeld ) {
			$listLink .= ' | '.$this->skin->makeKnownLinkObj( $titleObj, 
				wfMsgHtml( 'confirmaccount-showheld' ), wfArrayToCGI( array( 'wpShowHeld' => 1 ) ) );
		} else {
			$listLink .= ' | '.wfMsgHtml( 'confirmaccount-showheld' );
		}
		if( $this->acrID || !$this->showRejects ) {
			$listLink .= ' | '.$this->skin->makeKnownLinkObj( $titleObj, wfMsgHtml( 'confirmaccount-showrej' ),
				wfArrayToCGI( array( 'wpShowRejects' => 1 ) ) );
		} else {
			$listLink .= ' | '.wfMsgHtml( 'confirmaccount-showrej' );
		}
		if( $this->acrID || !$this->showStale ) {
			$listLink .= ' | '.$this->skin->makeKnownLinkObj( $titleObj, wfMsgHtml( 'confirmaccount-showexp' ),
				wfArrayToCGI( array( 'wpShowStale' => 1 ) ) );
		} else {
			$listLink .= ' | '.wfMsgHtml( 'confirmaccount-showexp' );
		}
		
		# Say what queue we are in...
		if( $this->queueType != -1 ) {
			$titleObj = Title::makeTitle( NS_SPECIAL, 'ConfirmAccounts' );
			$viewall = $this->skin->makeKnownLinkObj( $titleObj, wfMsgHtml('confirmaccount-all') );
		
			$wgOut->setSubtitle( "<strong>" . wfMsgHtml('confirmaccount-type') . " <i>" .
				wfMsgHtml("confirmaccount-type-{$this->queueType}") . 
				"</i></strong> [{$listLink}] <strong>{$viewall}</strong>" );
		}

		if( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			$this->doSubmit();
		} else if( $this->file ) {
			$this->showFile( $this->file );
		} else if( $this->acrID ) {
			$this->showForm();
		} else if( $this->queueType != -1 ) {
			$this->showList();
		} else {
			$this->showQueues();
		}
	}
	
	function showQueues() {
		global $wgOut, $wgAccountRequestTypes;
		
		$wgOut->addWikiText( wfMsg('confirmaccount-maintext') );
		
		$wgOut->addHTML( '<p><strong>' . wfMsgHtml('confirmaccount-types') . '</strong></p>' );
		$wgOut->addHTML( '<ul>' );
		
		$dbr = wfGetDB( DB_SLAVE );
		# List each queue
		foreach( $wgAccountRequestTypes as $i => $params ) {
			$titleObj = Title::makeTitle( NS_SPECIAL, "ConfirmAccounts/{$params[0]}" );
		
			$open = '<b>'.$this->skin->makeKnownLinkObj( $titleObj, wfMsgHtml( 'confirmaccount-q-open' ),
				wfArrayToCGI( array('wpShowHeld' => 0) ) ).'</b>';
			$held = $this->skin->makeKnownLinkObj( $titleObj, wfMsgHtml( 'confirmaccount-q-held' ),
				wfArrayToCGI( array('wpShowHeld' => 1) ) );
			$rejects = $this->skin->makeKnownLinkObj( $titleObj, wfMsgHtml( 'confirmaccount-q-rej' ),
				wfArrayToCGI( array('wpShowRejects' => 1) ) );
			$stale = '<i>'.$this->skin->makeKnownLinkObj( $titleObj, wfMsgHtml( 'confirmaccount-q-stale' ),
				wfArrayToCGI( array('wpShowStale' => 1) ) ).'</i>';;
			
			$count = $dbr->selectField( 'account_requests', 'COUNT(*)',
				array( 'acr_type' => $i, 'acr_deleted' => 0, 'acr_held IS NULL' ),
				__METHOD__ );
			$open .= " [$count]";
			
			$count = $dbr->selectField( 'account_requests', 'COUNT(*)',
				array( 'acr_type' => $i, 'acr_deleted' => 0, 'acr_held IS NOT NULL' ),
				__METHOD__ );
			$held .= " [$count]";
			
			$count = $dbr->selectField( 'account_requests', 'COUNT(*)',
				array( 'acr_type' => $i, 'acr_deleted' => 1, 'acr_user != 0' ),
				__METHOD__ );
			$rejects .= " [$count]";
				
			$wgOut->addHTML( "<li><i>".wfMsgHtml("confirmaccount-type-$i")."</i> ($open | $held | $rejects | $stale)</li>" );
		}
		$wgOut->addHTML( '</ul>' );
	}
	
	function showForm( $msg='' ) {
		global $wgOut, $wgUser, $wgLang, $wgAccountRequestTypes;
		
		$titleObj = Title::makeTitle( NS_SPECIAL, "ConfirmAccounts/{$this->specialPageParameter}" );
		
		$row = $this->getRequest();
		if( !$row || $row->acr_rejected && !$this->showRejects ) {
			$wgOut->addHTML( wfMsgHtml('confirmaccount-badid') );
			$wgOut->returnToMain( true, $titleObj );
			return;
		}
		
		# Output any failure message
		if( $msg ) {
			$wgOut->addHTML( '<div class="errorbox">' . $msg . '</div><div class="visualClear"></div>' );
		}
		
		$wgOut->addWikiText( wfMsg( "confirmaccount-text" ) );
		
		if( $row->acr_rejected ) {
			$time = $wgLang->timeanddate( wfTimestamp(TS_MW, $row->acr_rejected), true );
			$reason = $row->acr_comment ? $row->acr_comment : wfMsgHtml('confirmaccount-noreason');
			# Auto-rejected requests have a user ID of zero
			if( $row->acr_user ) {
				$wgOut->addHTML('<p><b>'.wfMsgExt( 'confirmaccount-reject', array('parseinline'), 
					User::whoIs($row->acr_user), $time ).'</b></p>');
				$wgOut->addHTML( '<p><strong>' . wfMsgHtml('confirmaccount-rational') . '</strong><i> ' . 
					$reason . '</i></p>' );
			} else {
				$wgOut->addHTML( '<p><i> ' . $reason . '</i></p>' );
			}
		} else if( $row->acr_held ) {
			$time = $wgLang->timeanddate( wfTimestamp(TS_MW, $row->acr_held), true );
			$reason = $row->acr_comment ? $row->acr_comment : wfMsgHtml('confirmaccount-noreason');
			
			$wgOut->addHTML('<p><b>'.wfMsgExt( 'confirmaccount-held', array('parseinline'), 
				User::whoIs($row->acr_user), $time ).'</b></p>');
			$wgOut->addHTML( '<p><strong>' . wfMsgHtml('confirmaccount-rational') . '</strong><i> ' . 
				$reason . '</i></p>' );
		}
		
		$form  = wfOpenElement( 'form', array( 'method' => 'post', 'name' => 'accountconfirm',
			'action' => $titleObj->getLocalUrl() ) );
		$form .= "<fieldset>";
		$form .= '<legend>' . wfMsgHtml('confirmaccount-leg-user') . '</legend>';
		$form .= '<table cellpadding=\'4\'>';
		$form .= "<tr><td>".Xml::label( wfMsgHtml('username'), 'wpNewName' )."</td>";
		$form .= "<td>".Xml::input( 'wpNewName', 30, $this->mUsername, array('id' => 'wpNewName') )."</td></tr>\n";
		
		$econf = $row->acr_email_authenticated ? ' <strong>'.wfMsgHtml('confirmaccount-econf').'</strong>' : '';
		$form .= "<tr><td>".wfMsgHtml('confirmaccount-email')."</td>";
		$form .= "<td>".htmlspecialchars($row->acr_email).$econf."</td></tr>\n";
		if( count($wgAccountRequestTypes) > 1 ) {
			$options = array();
			$form .= "<tr><td><strong>".wfMsgHtml('confirmaccount-reqtype')."</strong></td><td>";
			foreach( $wgAccountRequestTypes as $i => $params ) {
				$options[] = Xml::option( wfMsg( "confirmaccount-pos-$i" ), $i, ($i == $this->mType) );
			}
			$form .= Xml::openElement( 'select', array( 'name' => "wpType" ) );
			$form .= implode( "\n", $options );
			$form .= Xml::closeElement('select')."\n";
			$form .= "</td></tr>\n";
		}
		
		$form .= '</table></fieldset>';
		
		if( !wfEmptyMsg( 'requestaccount-areas', wfMsg('requestaccount-areas') ) ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml('confirmaccount-leg-areas') . '</legend>';
			
			$areas = explode("\n*","\n".wfMsg('requestaccount-areas'));
			$form .= "<div style='height:150px; overflow:scroll; background-color:#f9f9f9;'>";
			$form .= "<table cellspacing='5' cellpadding='0' style='background-color:#f9f9f9;'><tr valign='top'>";
			$count = 0;
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
					
					$form .= "<td>".wfCheckLabel( $set[0], $formName, $formName, $this->mAreas[$formName] > 0 )." {$pg}</td>\n";
				}
			}
			$form .= "</tr></table></div>";
			$form .= '</fieldset>';
		}
		
		$form .= '<fieldset>';
		$form .= '<legend>' . wfMsgHtml('confirmaccount-leg-person') . '</legend>';
		global $wgUseRealNamesOnly, $wgAllowRealName;
		if( $wgUseRealNamesOnly || $wgAllowRealName ) {
			$form .= '<table cellpadding=\'4\'>';
			$form .= "<tr><td>".wfMsgHtml('confirmaccount-real')."</td>";
			$form .= "<td>".htmlspecialchars($row->acr_real_name)."</td></tr>\n";
			$form .= '</table>';
		}
		$form .= "<p>".wfMsgHtml('confirmaccount-bio')."\n";
		$form .= "<textarea tabindex='1' name='wpNewBio' id='wpNewBio' rows='12' cols='80' style='width:100%; background-color:#f9f9f9;'>" .
			htmlspecialchars($this->mBio) .
			"</textarea></p>\n";
		$form .= '</fieldset>';
		global $wgAccountRequestExtraInfo;
		if ($wgAccountRequestExtraInfo || $wgUser->isAllowed( 'requestips' ) ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml('confirmaccount-leg-other') . '</legend>';
			if( $wgAccountRequestExtraInfo ) {
				$form .= '<p>'.wfMsgHtml('confirmaccount-attach') . ' ';
				if( $row->acr_filename ) {
					$form .= $this->skin->makeKnownLinkObj( $titleObj, htmlspecialchars($row->acr_filename),
						'file=' . $row->acr_storage_key );
				} else {
					$form .= wfMsgHtml('confirmaccount-none-p');
				}
				$form .= "</p><p>".wfMsgHtml('confirmaccount-notes')."\n";
				$form .= "<textarea tabindex='1' readonly='readonly' name='wpNotes' id='wpNotes' rows='3' cols='80' style='width:100%'>" .
					htmlspecialchars($row->acr_notes) .
					"</textarea></p>\n";
				$form .= "<p>".wfMsgHtml('confirmaccount-urls')."</p>\n";
				$form .= self::parseLinks($row->acr_urls);
			}
			if( $wgUser->isAllowed( 'requestips' ) ) {
				$blokip = SpecialPage::getTitleFor( 'blockip' );
				$form .= "<p>".wfMsgHtml('confirmaccount-ip')." ".htmlspecialchars($row->acr_ip).
				" (" . $this->skin->makeKnownLinkObj( $blokip, wfMsgHtml('blockip'), 
					'ip=' . $row->acr_ip . '&wpCreateAccount=1' ).")</p>\n";
			}
			$form .= '</fieldset>';
		}
		
		$form .= "<strong>".wfMsgExt( 'confirmaccount-confirm', array('parseinline') )."</strong>\n";
		$form .= "<table cellpadding='5'><tr>";
		$form .= "<td>".Xml::radio( 'wpSubmitType', 'accept', $this->submitType=='accept', 
			array('id' => 'submitCreate','onclick' => 'document.getElementById("wpComment").style.display="block"') );
		$form .= ' '.Xml::label( wfMsg('confirmaccount-create'), 'submitCreate' )."</td>\n";
		$form .= "<td>".Xml::radio( 'wpSubmitType', 'reject', $this->submitType=='reject', 
			array('id' => 'submitDeny','onclick' => 'document.getElementById("wpComment").style.display="block"') );
		$form .= ' '.Xml::label( wfMsg('confirmaccount-deny'), 'submitDeny' )."</td>\n";
		$form .= "<td>".Xml::radio( 'wpSubmitType', 'hold', $this->submitType=='hold', 
			array('id' => 'submitHold','onclick' => 'document.getElementById("wpComment").style.display="block"') );
		$form .= ' '.Xml::label( wfMsg('confirmaccount-hold'), 'submitHold' )."</td>\n";
		$form .= "<td>".Xml::radio( 'wpSubmitType', 'spam', $this->submitType=='spam', 
			array('id' => 'submitSpam','onclick' => 'document.getElementById("wpComment").style.display="none"') );
		$form .= ' '.Xml::label( wfMsg('confirmaccount-spam'), 'submitSpam' )."</td>\n";
		$form .= "</tr></table>";

		$form .= "<div id='wpComment'><p>".wfMsgHtml('confirmaccount-reason')."</p>\n";
		$form .= "<p><textarea name='wpReason' id='wpReason' rows='3' cols='80' style='width:80%; display=block;'>" .
			htmlspecialchars($this->reason) .
			"</textarea></p></div>\n";
		$form .= "<p>".Xml::submitButton( wfMsgHtml( 'confirmaccount-submit') )."</p>\n";
		$form .= Xml::hidden( 'title', $titleObj->getPrefixedUrl() )."\n";
		$form .= Xml::hidden( 'action', 'reject' );
		$form .= Xml::hidden( 'acrid', $row->acr_id );
		$form .= Xml::hidden( 'wpShowRejects', $this->showRejects );
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() )."\n";
		$form .= wfCloseElement( 'form' );
		
		$wgOut->addHTML( $form );
		
		global $wgMemc;
		# Set a key to who is looking at this request.
		# Have it expire in 10 minutes...
		$key = wfMemcKey( 'acctrequest', 'view', $row->acr_id );
		$wgMemc->set( $key, $wgUser->getID(), 60*10 );
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
		
		$store = FileStore::get( 'accountreqs' );
		if( !$store ) {
			wfDebug( __METHOD__.": invalid storage group '{$store}'.\n" );
			return false;
		}
		$store->stream( $key );
	}
	
	function doSubmit() {
		global $wgOut;

		$titleObj = Title::makeTitle( NS_SPECIAL, "ConfirmAccounts/{$this->specialPageParameter}" );
		$row = $this->getRequest( true );
		if( !$row ) {
			$wgOut->addHTML( wfMsgHtml('confirmaccount-badid') );
			$wgOut->returnToMain( true, $titleObj );
			return;
		}
		$errors = array();

		if( $this->submitType == 'reject' || $this->submitType == 'spam' ) {
			global $wgUser;
			# Make proxy user to email a rejection message :(
			$u = User::newFromName( $row->acr_name, 'creatable' );
			$u->setEmail( $row->acr_email );
			# Do not send multiple times, don't send for "spam" requests
			if( !$row->acr_rejected && $this->submitType != 'spam' ) {
				if( $this->reason ) {
					$result = $u->sendMail( wfMsg( 'confirmaccount-email-subj' ),
						wfMsgExt( 'confirmaccount-email-body4', array('parsemag'), $u->getName(), $this->reason ) );
				} else {
					$result = $u->sendMail( wfMsg( 'confirmaccount-email-subj' ),
						wfMsgExt( 'confirmaccount-email-body3', array('parsemag'), $u->getName() ) );
				}
				if( WikiError::isError( $result ) ) {
					$error = wfMsg( 'mailerror', htmlspecialchars( $result->toString() ) );
					$this->showForm( $error );
					return false;
				}
			}
			$dbw = wfGetDB( DB_MASTER );
			# Request can later be recovered
			$dbw->update( 'account_requests', 
				array( 'acr_rejected' => $dbw->timestamp(),
					'acr_user' => $wgUser->getID(),
					'acr_comment' => ($this->submitType == 'spam') ? '' : $this->reason,
					'acr_deleted' => 1 ), 
				array( 'acr_id' => $this->acrID, 'acr_deleted' => 0 ),
				__METHOD__ );
			# Clear cache for notice of how many account requests there are
			global $wgMemc;
			$key = wfMemcKey( 'confirmaccount', 'noticecount' );
			$wgMemc->delete( $key );

			$this->showSuccess( $this->submitType );
		} else if( $this->submitType == 'accept' ) {
			global $wgAuth;
			# Now create user and check if the name is valid
			$user = User::newFromName( $this->mUsername, 'creatable' );	
			if( is_null($user) ) {
				$this->showForm( wfMsgHtml('noname') );
				return;
			}
			# Make a random password
			$p = User::randomPassword();
			# Check if already in use
			if( 0 != $user->idForName() || $wgAuth->userExists( $user->getName() ) ) {
				$this->showForm( wfMsgHtml('userexists') );
				return;
			}
			# Add user to DB
			$user = User::createNew( $user->getName() );
			# VERY important to set email now. Otherwise user will have to request
			# a new password at the login screen...
			$user->setEmail( $row->acr_email );
			# Set password and realname
			$user->setNewpassword( $p );
			$user->setRealName( $row->acr_real_name );
			$user->saveSettings(); // Save this into the DB
			# Check if the user already confirmed email address
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'user',
				array( 'user_email_authenticated' => $row->acr_email_authenticated,
					'user_email_token_expires' => $row->acr_email_token_expires,
					'user_email_token' => $row->acr_email_token ),
				array( 'user_id' => $user->getID() ),
				__METHOD__ );
			# Move to credentials if configured to do so
			global $wgConfirmAccountSaveInfo;
			if( $wgConfirmAccountSaveInfo ) {
				global $wgUser;
				# Copy any attached files to new storage group
				$key = $row->acr_storage_key;
				if( $key ) {
					$storeOld = FileStore::get( 'accountreqs' );
					$storeNew = FileStore::get( 'accountcreds' );
					if( !$storeOld || !$storeNew ) {
						$dbw->delete( 'user', array( 'user_id' => $user->getID() ) );
						wfDebug( __METHOD__.": invalid storage group '{$store}'.\n" );
						return false;
					}
					$transaction = new FSTransaction();
					if( !FileStore::lock() ) {
						$dbw->delete( 'user', array( 'user_id' => $user->getID() ) );
						wfDebug( __METHOD__.": failed to acquire file store lock, aborting\n" );
						return false;
					}
					$path = $storeOld->filePath( $key );
					if( $path && file_exists($path) ) {
						$transaction->add( $storeNew->insert( $key, $path, 0 ) );
					}
				}
				$acd_id = $dbw->nextSequenceValue( 'account_credentials_acd_id_seq' );
				$dbw->begin();
				# Move request data into a separate table
				$dbw->insert( 'account_credentials',
					array( 'acd_user_id' => $user->getID(),
						'acd_real_name' => $row->acr_real_name,
						'acd_email' => $row->acr_email,
						'acd_email_authenticated' => $row->acr_email_authenticated,
						'acd_bio' => $row->acr_bio,
						'acd_notes' => $row->acr_notes,
						'acd_urls' => $row->acr_urls,
						'acd_ip' => $row->acr_ip,
						'acd_filename' => $row->acr_filename,
						'acd_storage_key' => $row->acr_storage_key,
						'acd_areas' => $row->acr_areas,
						'acd_registration' => $row->acr_registration,
						'acd_accepted' => $dbw->timestamp(),
						'acd_user' => $wgUser->getID(),
						'acd_comment' => $this->reason,
						'acd_id' => $acd_id ),
					__METHOD__ );
			}
			# Add to global user login system (if there is one)
			if( !$wgAuth->addUser( $user, $p, $row->acr_email, $row->acr_real_name ) ) {
				$dbw->delete( 'user', array( 'user_id' => $user->getID() ) );
				# Rollback file and row copies from credentials table on failure
				if( $wgConfirmAccountSaveInfo ) {
					$dbw->rollback();
					if( isset($transaction) )
						$transaction->rollback();
				}
				$this->showForm( wfMsgHtml( 'externaldberror' ) );
				return false;
			}
			# Commit these if we make past the CentralAuth system
			if( $wgConfirmAccountSaveInfo ) {
				$dbw->commit();
				if( isset($transaction) )
					$transaction->commit();
			}
			
			# Grant any necessary rights
			$grouptext = $group = '';
			global $wgAccountRequestTypes;
			if( array_key_exists($this->mType,$wgAccountRequestTypes) ) {
				$params = $wgAccountRequestTypes[$this->mType];
				$group = isset($params[1]) ? $params[1] : false;
				$grouptext = isset($params[2]) ? $params[2] : '';
				// Do not add blank or dummy groups
				if( $group && $group !='user' && $group !='*' ) {
					$user->addGroup( $group );
				}
			}
			
			# Send out password
			$ebody = '';
			if( $this->reason ) {
				# If the user is in a group and there is a welcome for that group, use it
				if( $group && !wfEmptyMsg( "confirmaccount-email-body2-pos{$this->mType}", wfMsg("confirmaccount-email-body2-pos{$this->mType}") ) ) {
					$ebody = wfMsgExt("confirmaccount-email-body2-pos{$this->mType}", array('parsemag'), $user->getName(), $p, $this->reason );
				}
				# Use standard if none found...
				if( !$ebody ) {
					$ebody = wfMsgExt( 'confirmaccount-email-body2', array('parsemag'), $user->getName(), $p, $this->reason );
				}
			} else {
				# If the user is in a group and there is a welcome for that group, use it
				if( $group && !wfEmptyMsg( "confirmaccount-email-body-pos{$this->mType}", wfMsg("confirmaccount-email-body-pos{$this->mType}") ) ) {
					$ebody = wfMsgExt("confirmaccount-email-body-pos{$this->mType}", array('parsemag'), $user->getName(), $p, $this->reason );
				}
				# Use standard if none found...
				if( !$ebody ) {
					$ebody = wfMsgExt( 'confirmaccount-email-body', array('parsemag'), $user->getName(), $p, $this->reason );
				}
			}
			$result = $user->sendMail( wfMsg( 'confirmaccount-email-subj' ), $ebody );
			if( WikiError::isError( $result ) ) {
				$errors[] = wfMsg( 'mailerror', htmlspecialchars( $result->toString() ) );
			}
			
			# Safe to hook/log now...
			wfRunHooks( 'AddNewAccount', array( $user ) );
			# OK, now remove the request from the queue
			$dbw->delete( 'account_requests', array('acr_id' => $this->acrID), __METHOD__ );
			# Clear cache for notice of how many account requests there are
			global $wgMemc;
			$key = wfMemcKey( 'confirmaccount', 'noticecount' );
			$wgMemc->delete( $key );
			# Delete any attached file. Do not stop the whole process if this fails
			$key = $row->acr_storage_key;
			if( $key ) {
				$store = FileStore::get( 'accountreqs' );
				if( !$store ) {
					wfDebug( __METHOD__.": invalid storage group '{$store}'.\n" );
				} else {
					$transaction = new FSTransaction();
					if( !FileStore::lock() ) {
						wfDebug( __METHOD__.": failed to acquire file store lock, aborting\n" );
					}
					$path = $store->filePath( $key );
					if( $path && file_exists($path) ) {
						$transaction->addCommit( FSTransaction::DELETE_FILE, $path );
					}
					$transaction->commit();
				}
			}
			# Start up the user's (presumedly brand new) userpages
			# Will not append, so previous content will be blanked
			global $wgMakeUserPageFromBio, $wgAutoUserBioText;
			if( $wgMakeUserPageFromBio ) {
				$usertitle = $user->getUserPage();
				$userpage = new Article( $usertitle );
				
				$autotext = strval($wgAutoUserBioText);
				$body = $autotext ? "{$this->mBio}\n\n{$autotext}" : $this->mBio;
				$body = $grouptext ? "{$body}\n\n{$grouptext}" : $body;
				# Add any interest categories
				if( !wfEmptyMsg( 'requestaccount-areas', wfMsg('requestaccount-areas') ) ) {
					$areas = explode("\n*","\n".wfMsg('requestaccount-areas'));
					foreach( $areas as $n => $line ) {
						$set = explode("|",$line);
						$name = str_replace("_"," ",$set[0]);
						if( in_array($set[0],$this->mAreaSet) ) {
							# General userpage text for anyone with this interest
							if( isset($set[2]) ) {
								$body .= $set[2];
							}
							# Message for users with this interested with the given account type
							# MW: message of format <name>|<wiki page>|<anyone>|<group0>|<group1>...
							if( isset($set[3+$this->mType]) && $set[3+$this->mType] ) {
								$body .= $set[3+$this->mType];
							}
						}
					}
				}
				# Set sortkey and use it on bio
				global $wgConfirmAccountSortkey, $wgContLang;
				if( !empty($wgConfirmAccountSortkey) ) {
					$sortKey = preg_replace($wgConfirmAccountSortkey[0],$wgConfirmAccountSortkey[1],$usertitle->getText());
					$body .= "\n{{DEFAULTSORT:{$sortKey}}}";
					# Clean up any other categories...
					$catNS = $wgContLang->getNSText(NS_CATEGORY);
					$replace = '/\[\['.preg_quote($catNS).':([^\]]+)\]\]/i'; // [[Category:x]]
					$with = "[[{$catNS}:$1|".str_replace('$','\$',$sortKey)."]]"; // [[Category:x|sortkey]]
					$body = preg_replace( $replace, $with, $body );
				}
				# Create userpage!
				$userpage->doEdit( $body, wfMsg('confirmaccount-summary'), EDIT_MINOR );
			}
			# Update user count
			$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
			$ssUpdate->doUpdate();
			# Greet user...
			global $wgAutoWelcomeNewUsers;
			if( $wgAutoWelcomeNewUsers ) {
				$utalk = new Article( $user->getTalkPage() );
				# Is there a custom message?
				$welcome = wfEmptyMsg( "confirmaccount-welc-pos{$this->mType}", wfMsg("confirmaccount-welc-pos{$this->mType}") ) ? 
					wfMsg('confirmaccount-welc') : wfMsg("confirmaccount-welc-pos{$this->mType}");
				# Add user welcome message!
				$utalk->doEdit( $welcome . ' ~~~~', wfMsg('confirmaccount-wsum'), EDIT_MINOR );
			}
			# Finally, done!!!
			$this->showSuccess( $this->submitType, $user->getName(), $errors );
		} else if( $this->submitType == 'hold' ) {
			global $wgUser;
			# Make proxy user to email a message
			$u = User::newFromName( $row->acr_name, 'creatable' );
			$u->setEmail( $row->acr_email );
			# Pointless without a summary...
			if( $row->acr_held || ($row->acr_deleted && $row->acr_deleted !='f') ) {
				$error = wfMsg( 'confirmaccount-canthold' );
				$this->showForm( $error );
				return false;
			} else if( !$this->reason ) {
				$error = wfMsg( 'confirmaccount-needreason' );
				$this->showForm( $error );
				return false;
			}
			# If not already held or deleted, mark as held
			$dbw = wfGetDB( DB_MASTER );
			$dbw->begin();
			$dbw->update( 'account_requests',
				array( 'acr_held' => $dbw->timestamp(), 
					'acr_user' => $wgUser->getID(),
					'acr_comment' => $this->reason ),
				array( 'acr_id' => $this->acrID, 'acr_held IS NULL', 'acr_deleted' => 0 ), 
					__METHOD__ );
			# Do not send multiple times
			if( !$row->acr_held && !($row->acr_deleted && $row->acr_deleted !='f') ) {
				$result = $u->sendMail( wfMsg( 'confirmaccount-email-subj' ),
						wfMsgExt( 'confirmaccount-email-body5', array('parsemag'), $u->getName(), $this->reason ) );
				if( WikiError::isError( $result ) ) {
					$dbw->rollback();
					$error = wfMsg( 'mailerror', htmlspecialchars( $result->toString() ) );
					$this->showForm( $error );
					return false;
				}
			}
			$dbw->commit();
			# Clear cache for notice of how many account requests there are
			global $wgMemc;
			$key = wfMemcKey( 'confirmaccount', 'noticecount' );
			$wgMemc->delete( $key );
			
			$this->showSuccess( $this->submitType );
		} else {
			$this->showForm();
		}
	}
	
	function getRequest( $forUpdate = false ) {
		if( !$this->acrID )
			return false;
		
		$db = $forUpdate ? wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
		$row = $db->selectRow( 'account_requests', '*', 
			array( 'acr_id' => $this->acrID ), 
			__METHOD__ );
		
		# Check if parameters are to be overridden
		if( $row ) {
			$this->mUsername = $this->mUsername ? $this->mUsername : $row->acr_name;
			$this->mBio = $this->mBio ? $this->mBio : $row->acr_bio;
			$this->mType = !is_null($this->mType) ? $this->mType : $row->acr_type;
			$rowareas = RequestAccountPage::expandAreas( $row->acr_areas );	
			
			foreach( $this->mAreas as $area => $within ) {
				# If admin didn't set any of these checks, go back to how the user set them
				if( $within == -1 ) {
					if( in_array($area,$rowareas) )
						$this->mAreas[$area] = 1;
					else
						$this->mAreas[$area] = 0;
				}
			}
		}
		return $row;
	}
	
	/**
	 * Extract a list of all recognized HTTP links in the text.
	 * @param string $text
	 * @return string $linkList, list of clickable links
	 */
	public static function parseLinks( $text ) {
		global $wgParser, $wgUser;
		# Don't let this get flooded
		$max = 10;
		$count = 0;

		$linkList = '';
		# Normalize space characters
		$text = str_replace( array("\r","\t"), array("\n"," "), htmlspecialchars($text) );
		# Split out each line as a link
		$lines = explode( "\n", $text );
		foreach( $lines as $line ) {
			$links = explode(" ",$line,2);
			$link = $links[0];
			# Any explanation text is not part of the link...
			$extra = isset($links[1]) ? ' '.$links[1] : '';
			if( strpos($link,'.') ) {
				$link = ( strpos($link,'http://')===false ) ? 'http://'.$link : $link;
				$linkList .= "<li><a href='$link'>$link</a>$extra</li>\n";
			}
			$count++;
			if( $count >= $max )
				break;
		}
		if( $linkList == '' ) {
			$linkList = wfMsgHtml( 'confirmaccount-none-p' );
		} else {
			$linkList = "<ul>{$linkList}</ul>";
		}

		return $linkList;
	}
	
	function showSuccess( $titleObj, $name = NULL, $errors = array() ) {
		global $wgOut;

		$titleObj = Title::makeTitle( NS_SPECIAL, "ConfirmAccounts/{$this->specialPageParameter}" );
		$wgOut->setPagetitle( wfMsgHtml('actioncomplete') );
		if( $this->submitType == 'accept' ) {
			$wgOut->addWikiText( wfMsg( "confirmaccount-acc", $name ) );
		} else if( $this->submitType == 'reject' || $this->submitType == 'spam' ) {
			$wgOut->addWikiText( wfMsg( "confirmaccount-rej" ) );
		} else {
			$wgOut->redirect( $titleObj->getFullUrl() );
			return;
		}
		# Output any errors
		foreach( $errors as $error ) {
			$wgOut->addHTML( '<p>' . $error . '</p>' );
		}
		# Give link to see other requests
		$wgOut->returnToMain( true, $titleObj );
	}

	function showList() {
		global $wgOut, $wgUser, $wgLang;
		
		$titleObj = Title::makeTitle( NS_SPECIAL, "ConfirmAccounts/{$this->specialPageParameter}" );
		
		# Output the list
		$pager = new ConfirmAccountsPager( $this, array(), 
			$this->queueType, $this->showRejects, $this->showHeld, $this->showStale );
			
		if( $pager->getNumRows() ) {
			if( $this->showStale ) {
				$wgOut->addHTML( wfMsgExt('confirmaccount-list3', array('parse') ) );
			} else if( $this->showRejects ) {
				$wgOut->addHTML( wfMsgExt('confirmaccount-list2', array('parse') ) );
			} else {
				$wgOut->addHTML( wfMsgExt('confirmaccount-list', array('parse') ) );
			}
			$wgOut->addHTML( $pager->getNavigationBar() );
			$wgOut->addHTML( $pager->getBody() );
			$wgOut->addHTML( $pager->getNavigationBar() );
		} else {
			if( $this->showRejects ) {
				$wgOut->addHTML( wfMsgExt('confirmaccount-none-r', array('parse')) );
			} else if( $this->showStale ) {
				$wgOut->addHTML( wfMsgExt('confirmaccount-none-e', array('parse')) );
			} else if( $this->showHeld ) {
				$wgOut->addHTML( wfMsgExt('confirmaccount-none-h', array('parse')) );
			} else {
				$wgOut->addHTML( wfMsgExt('confirmaccount-none-o', array('parse')) );
			}
		}
		
		# Every 50th view, prune old deleted items
		wfSeedRandom();
		if( 0 == mt_rand( 0, 49 ) ) {
			$this->runAutoMaintenance();
		}
	}
	
	/*
	* Move old stale requests to rejected list. Delete old rejected requests.
	*/
	private function runAutoMaintenance() {
		global $wgRejectedAccountMaxAge;

		$dbw = wfGetDB( DB_MASTER );
		$transaction = new FSTransaction();
		if( !FileStore::lock() ) {
			wfDebug( __METHOD__.": failed to acquire file store lock, aborting\n" );
			return;
		}
		# Select all items older than time $cutoff
		$cutoff = $dbw->timestamp( time() - $wgRejectedAccountMaxAge );
		$accountrequests = $dbw->tableName( 'account_requests' );
		$sql = "SELECT acr_storage_key,acr_id FROM $accountrequests WHERE acr_rejected < '{$cutoff}'";
		$res = $dbw->query( $sql );

		$store = FileStore::get( 'accountreqs' );
		if( !$store ) {
			wfDebug( __METHOD__.": invalid storage group '{$store}'.\n" );
			return false;
		}
		# Clear out any associated attachments and delete those rows
		while( $row = $dbw->fetchObject( $res ) ) {
			$key = $row->acr_storage_key;
			if( $key ) {
				$path = $store->filePath( $key );
				if( $path && file_exists($path) ) {
					$transaction->addCommit( FSTransaction::DELETE_FILE, $path );
				}
			}
			$dbw->query( "DELETE FROM $accountrequests WHERE acr_id = {$row->acr_id}" );
		}
		$transaction->commit();
			
		# Select all items older than time $cutoff
		global $wgConfirmAccountRejectAge;
		$cutoff = $dbw->timestamp( time() - $wgConfirmAccountRejectAge );
		# Old stale accounts will count as rejected. If the request was held, give it more time.
		$dbw->update( 'account_requests',
			array( 'acr_rejected' => $dbw->timestamp(),
				'acr_user' => 0, // dummy
				'acr_comment' => wfMsgForContent('confirmaccount-autorej'),
				'acr_deleted' => 1 ), 
			array( "acr_rejected IS NULL", "acr_registration < '{$cutoff}'", "acr_held < '{$cutoff}'" ),
			__METHOD__ );
			
		# Clear cache for notice of how many account requests there are
		global $wgMemc;
		$key = wfMemcKey( 'confirmaccount', 'noticecount' );
		$wgMemc->delete( $key );
	}
	
	function formatRow( $row ) {
		global $wgLang, $wgUser, $wgUseRealNamesOnly, $wgAllowRealName;

		$titleObj = Title::makeTitle( NS_SPECIAL, "ConfirmAccounts/{$this->specialPageParameter}" );
		if( $this->showRejects || $this->showStale ) {
			$link = $this->skin->makeKnownLinkObj( $titleObj, wfMsgHtml('confirmaccount-review'), 
				'acrid='.$row->acr_id.'&wpShowRejects=1' );
		} else {
			$link = $this->skin->makeKnownLinkObj( $titleObj, wfMsgHtml('confirmaccount-review'), 
				'acrid='.$row->acr_id );
		}
		$time = $wgLang->timeanddate( wfTimestamp(TS_MW, $row->acr_registration), true );
		
		$r = "<li class='mw-confirmaccount-time-{$this->queueType}'>";
		
		$r .= $time." (<strong>{$link}</strong>)";
		# Auto-rejected accounts have a user ID of zero
		if( $row->acr_rejected && $row->acr_user ) {
			$time = $wgLang->timeanddate( wfTimestamp(TS_MW, $row->acr_rejected), true );
			$r .= ' <b>'.wfMsgExt( 'confirmaccount-reject', array('parseinline'), $row->user_name, $time ).'</b>';
		} else if( $row->acr_held && !$row->acr_rejected ) {
			$time = $wgLang->timeanddate( wfTimestamp(TS_MW, $row->acr_held), true );
			$r .= ' <b>'.wfMsgExt( 'confirmaccount-held', array('parseinline'), User::whoIs($row->acr_user), $time ).'</b>';
		}
		# Check if someone is viewing this request
		global $wgMemc;
		$key = wfMemcKey( 'acctrequest', 'view', $row->acr_id );
		$value = $wgMemc->get( $key );
		if( $value ) {
			$r .= ' <b>'.wfMsgExt( 'confirmaccount-viewing', array('parseinline'), User::whoIs($value) ).'</b>';
		}
		
		$r .= "<br /><table class='mw-confirmaccount-body-{$this->queueType}' cellspacing='1' cellpadding='3' border='1' width='100%'>";
		if( !$wgUseRealNamesOnly ) {
			$r .= '<tr><td><strong>'.wfMsgHtml('confirmaccount-name').'</strong></td><td width=\'100%\'>' .
				htmlspecialchars($row->acr_name) . '</td></tr>';
		}
		if( $wgUseRealNamesOnly  || $wgAllowRealName ) {
			$r .= '<tr><td><strong>'.wfMsgHtml('confirmaccount-real-q').'</strong></td><td width=\'100%\'>' .
				htmlspecialchars($row->acr_real_name) . '</td></tr>';
		}
		$econf = $row->acr_email_authenticated ? ' <strong>'.wfMsg('confirmaccount-econf').'</strong>' : '';
		$r .= '<tr><td><strong>'.wfMsgHtml('confirmaccount-email-q').'</strong></td><td width=\'100%\'>' .
			htmlspecialchars($row->acr_email) . $econf.'</td></tr>';
		# Truncate this, blah blah...
		$bio = htmlspecialchars($row->acr_bio);
		$preview = $wgLang->truncate( $bio, 400 );
		if( strlen($preview) < strlen($bio) ) {
			$preview = substr( $preview, 0, strrpos($preview,' ') );
			$preview .= " . . .";
		}
		$r .= '<tr><td><strong>'.wfMsgHtml('confirmaccount-bio-q') .
			'</strong></td><td width=\'100%\'><i>'.$preview.'</i></td></tr>';
		$r .= '</table>';
		
		$r .= '</li>';
		
		return $r;
	}
}

/**
 * Query to list out pending accounts
 */
class ConfirmAccountsPager extends ReverseChronologicalPager {
	public $mForm, $mConds;

	function __construct( $form, $conds = array(), $type, $rejects=false, $showHeld=false, $showStale=false ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		
		$this->mConds['acr_type'] = $type;
		
		$this->rejects = $rejects;
		$this->stale = $showStale;
		if( $rejects || $showStale ) {
			$this->mConds['acr_deleted'] = 1;
		} else {
			$this->mConds['acr_deleted'] = 0;
			if( $showHeld )
				$this->mConds[] = 'acr_held IS NOT NULL';
			else
				$this->mConds[] = 'acr_held IS NULL';
			  
		}
		parent::__construct();
		# Treat 20 as the default limit, since each entry takes up 5 rows.
		$urlLimit = $this->mRequest->getInt( 'limit' );
		$this->mLimit = $urlLimit ? $urlLimit : 20;
	}
	
	function getTitle() {
		return Title::makeTitle( NS_SPECIAL, "ConfirmAccounts/{$this->mForm->specialPageParameter}" );
	}
	
	function formatRow( $row ) {
		$block = new Block;
		return $this->mForm->formatRow( $row );
	}
	
	function getStartBody() {
		if ( $this->getNumRows() ) {
			return '<ul>';
		} else {
			return '';
		}
	}

	function getEndBody() {
		if ( $this->getNumRows() ) {
			return '</ul>';
		} else {
			return '';
		}
	}

	function getQueryInfo() {
		$conds = $this->mConds;
		$tables = array( 'account_requests' );
		$fields = array( 'acr_id','acr_name','acr_real_name','acr_registration','acr_held','acr_user',
			'acr_email','acr_email_authenticated','acr_bio','acr_notes','acr_urls','acr_type','acr_rejected' );
		# Stale requests have a user ID of zero
		if( $this->stale ) {
			$conds[] = 'acr_user = 0';
		} else if( $this->rejects ) {
			$conds[] = 'acr_user != 0';
			$tables[] = 'user';
			$conds[] = 'acr_user = user_id';
			$fields[] = 'user_name';
			$fields[] = 'acr_rejected';
		}
		return array(
			'tables' => $tables,
			'fields' => $fields,
			'conds' => $conds
		);
	}

	function getIndexField() {
		return 'acr_registration';
	}
}
