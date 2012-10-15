<?php

class ConfirmAccountsPage extends SpecialPage {
	protected $queueType = -1;
	protected $acrID = 0;
	protected $file = '';

	protected $showHeld = false;
	protected $showRejects = false;
	protected $showStale = false;

	/** @var UserAccountRequest */
	protected $accountReq;
	protected $reqUsername;
	protected $reqType;
	protected $reqBio;
	/** @var array */
	protected $reqAreas;

	protected $submitType;
	protected $reason;

	function __construct() {
		parent::__construct( 'ConfirmAccounts', 'confirmaccount' );
	}

	function execute( $par ) {
		global $wgAccountRequestTypes;

		$reqUser = $this->getUser();
		$request = $this->getRequest();

		if ( !$reqUser->isAllowed( 'confirmaccount' ) ) {
			throw new PermissionsError( 'confirmaccount' );
		} elseif ( !$reqUser->getID() ) {
			throw new PermissionsError( 'user' );
		}

		$this->setHeaders();

		# Use the special page param to act as a super type.
		# Convert this to its integer form.
		$this->queueType = -1;
		foreach ( $wgAccountRequestTypes as $i => $params ) {
			if ( $params[0] === $par ) {
				$this->queueType = $i;
				break;
			}
		}
		# User account request ID
		$this->acrID = $request->getIntOrNull( 'acrid' );
		# Attachment file name to view
		$this->file = $request->getVal( 'file' );

		# Held requests hidden by default
		$this->showHeld = $request->getBool( 'wpShowHeld' );
		# Show stale requests
		$this->showStale = $request->getBool( 'wpShowStale' );
		# For viewing rejected requests (stale requests count as rejected)
		$this->showRejects = $request->getBool( 'wpShowRejects' );

		// Showing a file
		if ( $this->file ) {
			$this->showFile( $this->file );
			return; // nothing else to do
		// Showing or confirming an account request
		} elseif ( $this->acrID ) {
			# Load areas user plans to be active in...
			$this->reqAreas = array();
			foreach ( ConfirmAccount::getUserAreaConfig() as $name => $conf ) {
				$formName = "wpArea-" . htmlspecialchars( str_replace(' ','_', $name ) );
				$this->reqAreas[$name] = $request->getInt( $formName, -1 );
			}
			# Load in the UserAccountRequest obj
			$this->loadAccountRequest( $this->acrID, $request->wasPosted() );
			if ( $request->wasPosted() ) {
				# For renaming to alot for collisions with other local requests
				# that were accepted and added to some global $wgAuth system first
				$this->reqUsername = trim( $request->getText( 'wpNewName' ) );
				# For changing the position recieved by requester
				$this->reqType = $request->getIntOrNull( 'wpType' );
				if ( !isset( $wgAccountRequestTypes[$this->reqType] ) ) {
					$this->reqType = null;
				}
				# For removing private info or such from bios
				$this->reqBio = $request->getText( 'wpNewBio' );
				# Action the admin is taking and why
				$this->submitType = $request->getVal( 'wpSubmitType' );
				$this->reason = $request->getText( 'wpReason' );
				# Check if this is a valid submission...
				$token = $request->getVal( 'wpEditToken' );
				if ( $reqUser->matchEditToken( $token, $this->acrID ) ) {
					$this->doAccountConfirmSubmit();
				} else {
					$this->showAccountConfirmForm( wfMsgHtml( 'sessionfailure' ) );
				}
			} else {
				$this->showAccountConfirmForm();
			}
		// Showing all account requests in a queue
		} elseif ( $this->queueType != -1 ) {
			$this->showList();
		// Showing all account request queues
		} else {
			$this->showQueues();
		}

		// Show what queue we are in and links to the others
		$this->addQueueSubtitleLinks();

		$this->getOutput()->addModules( 'ext.confirmAccount' ); // CSS
	}

	protected function addQueueSubtitleLinks() {
		$titleObj = $this->getFullTitle();

		# Show other sub-queue links. Grey out the current one.
		# When viewing a request, show them all.
		if ( $this->acrID || $this->showStale || $this->showRejects || $this->showHeld ) {
			$listLink = Linker::link( $titleObj,
				wfMsgHtml( 'confirmaccount-showopen' ), array(), array(), "known" );
		} else {
			$listLink = wfMsgHtml( 'confirmaccount-showopen' );
		}
		if ( $this->acrID || !$this->showHeld ) {
			$listLink = $this->getLang()->pipeList( array(
				$listLink,
				Linker::makeKnownLinkObj( $titleObj,
					wfMsgHtml( 'confirmaccount-showheld' ),
					wfArrayToCGI( array( 'wpShowHeld' => 1 ) ) )
			) );
		} else {
			$listLink = $this->getLang()->pipeList( array(
				$listLink,
				wfMsgHtml( 'confirmaccount-showheld' )
			) );
		}
		if ( $this->acrID || !$this->showRejects ) {
			$listLink = $this->getLang()->pipeList( array(
				$listLink,
				Linker::makeKnownLinkObj( $titleObj,
					wfMsgHtml( 'confirmaccount-showrej' ),
					wfArrayToCGI( array( 'wpShowRejects' => 1 ) ) )
			) );
		} else {
			$listLink = $this->getLang()->pipeList( array(
				$listLink,
				wfMsgHtml( 'confirmaccount-showrej' )
			) );
		}
		if ( $this->acrID || !$this->showStale ) {
			$listLink = $this->getLang()->pipeList( array(
				$listLink,
				Linker::makeKnownLinkObj( $titleObj,
					wfMsgHtml( 'confirmaccount-showexp' ),
					wfArrayToCGI( array( 'wpShowStale' => 1 ) ) )
			) );
		} else {
			$listLink = $this->getLang()->pipeList( array(
				$listLink,
				wfMsgHtml( 'confirmaccount-showexp' )
			) );
		}

		# Say what queue we are in...
		if ( $this->queueType != -1 ) {
			$viewall = Linker::makeKnownLinkObj(
				$this->getTitle(), wfMsgHtml('confirmaccount-all') );

			$this->getOutput()->setSubtitle(
				"<strong>" . wfMsgHtml('confirmaccount-type') . " <i>" .
				wfMsgHtml("confirmaccount-type-{$this->queueType}") .
				"</i></strong> [{$listLink}] <strong>{$viewall}</strong>" );
		}
	}

	protected function showQueues() {
		global $wgAccountRequestTypes;

		$out = $this->getOutput();

		$out->addWikiMsg( 'confirmaccount-maintext' );
		$out->addHTML( '<p><strong>' . wfMsgHtml('confirmaccount-types') . '</strong></p>' );

		# List each queue and some information about it...
		$out->addHTML( '<ul>' );
		foreach ( $wgAccountRequestTypes as $i => $params ) {
			$titleObj = SpecialPage::getTitleFor( 'ConfirmAccounts', $params[0] );
			$counts = ConfirmAccount::getOpenRequestCount( $i );

			$open = '<b>' . Linker::makeKnownLinkObj( $titleObj,
				wfMsgHtml( 'confirmaccount-q-open' ),
				wfArrayToCGI( array( 'wpShowHeld' => 0 ) ) ) . '</b>';
			$open .= ' [' . $counts['open'] . ']';

			$held = Linker::makeKnownLinkObj( $titleObj,
				wfMsgHtml( 'confirmaccount-q-held' ),
				wfArrayToCGI( array( 'wpShowHeld' => 1 ) ) );
			$held .= ' [' . $counts['held'] . ']';

			$rejects = Linker::makeKnownLinkObj( $titleObj,
				wfMsgHtml( 'confirmaccount-q-rej' ),
				wfArrayToCGI( array( 'wpShowRejects' => 1 ) ) );
			$rejects .= ' [' . $counts['rejected'] . ']';

			$stale = '<i>'.Linker::makeKnownLinkObj( $titleObj,
				wfMsgHtml( 'confirmaccount-q-stale' ),
				wfArrayToCGI( array( 'wpShowStale' => 1 ) ) ).'</i>';

			$out->addHTML( "<li><i>".wfMsgHtml("confirmaccount-type-$i")."</i> (" .
				$this->getLang()->pipeList( array( $open, $held, $rejects, $stale ) ) . ")</li>" );
		}
		$out->addHTML( '</ul>' );
	}

	/**
	 * @param $msg string
	 */
	protected function showAccountConfirmForm( $msg = '' ) {
		global $wgAccountRequestTypes;

		$out = $this->getOutput();
		$reqUser = $this->getUser();
		$titleObj = $this->getFullTitle();

		$accountReq = $this->accountReq; // convenience
		if ( !$accountReq || $accountReq->isDeleted() && !$this->showRejects ) {
			$out->addHTML( wfMsgHtml('confirmaccount-badid') );
			$out->returnToMain( true, $titleObj );
			return;
		}

		# Output any failure message
		if( $msg != '' ) {
			$out->addHTML( '<div class="errorbox">' . $msg . '</div><div class="visualClear"></div>' );
		}

		$out->addWikiMsg( 'confirmaccount-text' );

		$rejectTimestamp = $accountReq->getRejectTimestamp();
		$heldTimestamp = $accountReq->getHeldTimestamp();
		$reason = strlen( $accountReq->getHandlingComment() )
			? htmlspecialchars( $accountReq->getHandlingComment() )
			: wfMsgHtml( 'confirmaccount-noreason' );
		$adminId = $accountReq->getHandlingUser();

		if ( $rejectTimestamp ) {
			$datim = $this->getLang()->timeanddate( $rejectTimestamp, true );
			$date = $this->getLang()->date( $rejectTimestamp, true );
			$time = $this->getLang()->time( $rejectTimestamp, true );
			# Auto-rejected requests have a user ID of zero
			if ( $adminId ) {
				$out->addHTML('<p><b>'.wfMsgExt( 'confirmaccount-reject', array('parseinline'),
					User::whoIs( $adminId ), $datim, $date, $time ).'</b></p>');
				$out->addHTML( '<p><strong>' . wfMsgHtml('confirmaccount-rational') . '</strong><i> ' .
					$reason . '</i></p>' );
			} else {
				$out->addHTML( "<p><i> $reason </i></p>" );
			}
		} elseif ( $heldTimestamp ) {
			$datim = $this->getLang()->timeanddate( $heldTimestamp, true );
			$date = $this->getLang()->date( $heldTimestamp, true );
			$time = $this->getLang()->time( $heldTimestamp, true );

			$out->addHTML('<p><b>'.wfMsgExt( 'confirmaccount-held', array('parseinline'),
				User::whoIs( $adminId ), $datim, $date, $time ).'</b></p>');
			$out->addHTML( '<p><strong>' . wfMsgHtml('confirmaccount-rational') . '</strong><i> ' .
				$reason . '</i></p>' );
		}

		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'name' => 'accountconfirm',
			'action' => $titleObj->getLocalUrl() ) );
		$form .= "<fieldset>";
		$form .= '<legend>' . wfMsgHtml('confirmaccount-leg-user') . '</legend>';
		$form .= '<table cellpadding=\'4\'>';
		$form .= "<tr><td>".Xml::label( wfMsgHtml('username'), 'wpNewName' )."</td>";
		$form .= "<td>".Xml::input( 'wpNewName', 30, $this->reqUsername, array('id' => 'wpNewName') )."</td></tr>\n";

		$econf = '';
		if ( $accountReq->getEmailAuthTimestamp() ) {
			$econf = ' <strong>'.wfMsgHtml('confirmaccount-econf').'</strong>';
		}
		$form .= "<tr><td>".wfMsgHtml('confirmaccount-email')."</td>";
		$form .= "<td>".htmlspecialchars( $accountReq->getEmail() ).$econf."</td></tr>\n";
		if( count($wgAccountRequestTypes) > 1 ) {
			$options = array();
			$form .= "<tr><td><strong>".wfMsgHtml('confirmaccount-reqtype')."</strong></td><td>";
			foreach( $wgAccountRequestTypes as $i => $params ) {
				$options[] = Xml::option( wfMsg( "confirmaccount-pos-$i" ), $i, ($i == $this->reqType) );
			}
			$form .= Xml::openElement( 'select', array( 'name' => "wpType" ) );
			$form .= implode( "\n", $options );
			$form .= Xml::closeElement('select')."\n";
			$form .= "</td></tr>\n";
		}

		$form .= '</table></fieldset>';

		$userAreas = ConfirmAccount::getUserAreaConfig();
		if ( count( $userAreas ) > 0 ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml('confirmaccount-leg-areas') . '</legend>';

			$form .= "<div style='height:150px; overflow:scroll; background-color:#f9f9f9;'>";
			$form .= "<table cellspacing='5' cellpadding='0' style='background-color:#f9f9f9;'><tr valign='top'>";
			$count = 0;
			foreach ( $userAreas as $name => $conf ) {
				$count++;
				if ( $count > 5 ) {
					$form .= "</tr><tr valign='top'>";
					$count = 1;
				}
				$formName = "wpArea-" . htmlspecialchars( str_replace(' ','_', $name ) );
				if ( $conf['project'] != '' ) {
					$pg = Linker::link( Title::newFromText( $conf['project'] ),
						wfMsgHtml('requestaccount-info'), array(), array(), "known" );
				} else {
					$pg = '';
				}
				$form .= "<td>" .
					Xml::checkLabel( $name, $formName, $formName, $this->reqAreas[$name] > 0 ) .
					" {$pg}</td>\n";
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
			$form .= "<td>".htmlspecialchars( $accountReq->getRealName() )."</td></tr>\n";
			$form .= '</table>';
		}
		$form .= "<p>".wfMsgHtml('confirmaccount-bio')."\n";
		$form .= "<textarea tabindex='1' name='wpNewBio' id='wpNewBio' rows='12' cols='80' style='width:100%; background-color:#f9f9f9;'>" .
			htmlspecialchars($this->reqBio) .
			"</textarea></p>\n";
		$form .= '</fieldset>';
		global $wgAccountRequestExtraInfo;
		if ($wgAccountRequestExtraInfo || $reqUser->isAllowed( 'requestips' ) ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml('confirmaccount-leg-other') . '</legend>';
			if( $wgAccountRequestExtraInfo ) {
				$form .= '<p>'.wfMsgHtml('confirmaccount-attach') . ' ';
				if( $accountReq->getFileName() !== null ) {
					$form .= Linker::makeKnownLinkObj( $titleObj,
						htmlspecialchars( $accountReq->getFileName() ),
						'file=' . $accountReq->getFileStorageKey() );
				} else {
					$form .= wfMsgHtml('confirmaccount-none-p');
				}
				$form .= "</p><p>".wfMsgHtml('confirmaccount-notes')."\n";
				$form .= "<textarea tabindex='1' readonly='readonly' name='wpNotes' id='wpNotes' rows='3' cols='80' style='width:100%'>" .
					htmlspecialchars( $accountReq->getNotes() ) .
					"</textarea></p>\n";
				$form .= "<p>".wfMsgHtml('confirmaccount-urls')."</p>\n";
				$form .= self::parseLinks( $accountReq->getUrls() );
			}
			if( $reqUser->isAllowed( 'requestips' ) ) {
				$blokip = SpecialPage::getTitleFor( 'Block' );
				$form .= "<p>".wfMsgHtml('confirmaccount-ip') .
					" " . htmlspecialchars( $accountReq->getIP() ).
					" (" . Linker::makeKnownLinkObj( $blokip, wfMsgHtml('blockip'),
					'ip=' . $accountReq->getIP() . '&wpCreateAccount=1' ).")</p>\n";
			}
			$form .= '</fieldset>';
		}

		$form .= '<fieldset>';
		$form .= '<legend>' . wfMsgHtml('confirmaccount-legend') . '</legend>';
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
			htmlspecialchars($this->reason) . "</textarea></p></div>\n";
		$form .= "<p>".Xml::submitButton( wfMsgHtml( 'confirmaccount-submit') )."</p>\n";
		$form .= '</fieldset>';

		$form .= Html::Hidden( 'title', $titleObj->getPrefixedDBKey() )."\n";
		$form .= Html::Hidden( 'action', 'reject' );
		$form .= Html::Hidden( 'acrid', $accountReq->getId() );
		$form .= Html::Hidden( 'wpShowRejects', $this->showRejects );
		$form .= Html::Hidden( 'wpEditToken', $reqUser->editToken( $accountReq->getId() ) )."\n";
		$form .= Xml::closeElement( 'form' );

		$out->addHTML( $form );

		global $wgMemc;
		# Set a key to who is looking at this request.
		# Have it expire in 10 minutes...
		$key = wfMemcKey( 'acctrequest', 'view', $accountReq->getId() );
		$wgMemc->set( $key, $reqUser->getID(), 60*10 );
	}

	/**
	 * Show a private file requested by the visitor.
	 * @param $key string
	 */
	protected function showFile( $key ) {
		global $wgConfirmAccountFSRepos;

		$out = $this->getOutput();
		$request = $this->getRequest();

		$out->disable();

		# We mustn't allow the output to be Squid cached, otherwise
		# if an admin previews a private image, and it's cached, then
		# a user without appropriate permissions can toddle off and
		# nab the image, and Squid will serve it
		$request->response()->header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', 0 ) . ' GMT' );
		$request->response()->header( 'Cache-Control: no-cache, no-store, max-age=0, must-revalidate' );
		$request->response()->header( 'Pragma: no-cache' );

		$repo = new FSRepo( $wgConfirmAccountFSRepos['accountreqs'] );
		$path = $repo->getZonePath( 'public' ) . '/' .
			UserAccountRequest::relPathFromKey( $key );

		$repo->streamFile( $path );
	}

	protected function doAccountConfirmSubmit() {
		if ( !$this->accountReq ) {
			$this->showAccountConfirmForm( wfMsgHtml( 'confirmaccount-badid' ) );
			return;
		}

		# Build submission object...
		$areaSet = array(); // make a simple list of interests
		foreach ( $this->reqAreas as $area => $val ) {
			if ( $val > 0 ) {
				$areaSet[] = $area;
			}
		}
		$submission = new AccountConfirmSubmission(
			$this->getUser(),
			$this->accountReq,
			array(
				'userName' => $this->reqUsername,
				'bio'      => $this->reqBio,
				'type'     => $this->reqType,
				'areas'    => $areaSet,
				'action'   => $this->submitType,
				'reason'   => $this->reason
			)
		);

		# Actually submit!
		list( $status, $msg ) = $submission->submit( $this->getContext() );

		# Check for error messages
		if ( $status !== true ) {
			$this->showAccountConfirmForm( $msg );
			return;
		}

		# Done!
		$this->showSuccess( $this->submitType, $this->reqUsername, (array)$msg );
	}

	/**
	 * Get requested account request row and load some fields
	 * @param $id int
	 * @param $wasPosted bool
	 * @return void
	 */
	protected function loadAccountRequest( $id, $wasPosted ) {
		$from = $wasPosted ? 'dbmaster' : 'dbslave';
		$this->accountReq = UserAccountRequest::newFromId( $id, $from );
		# Check if parameters are to be overridden
		if ( $this->accountReq ) {
			$this->reqUsername = ( $this->reqUsername != '' )
				? $this->reqUsername // overriden by admin
				: $this->accountReq->getName();
			$this->reqBio = ( $this->reqBio != '' )
				? $this->reqBio // overriden by admin
				: $this->accountReq->getBio();
			$this->reqType = !is_null( $this->reqType )
				? $this->reqType // overriden by admin
				: $this->accountReq->getType();

			$origAreas = $this->accountReq->getAreas();
			foreach ( $this->reqAreas as $area => $within ) {
				# If admin didn't set any of these checks, go back to how the user set them.
				# On GET requests, the admin probably didn't set anything.
				if ( $within == -1 ) {
					if ( in_array( $area, $origAreas ) ) {
						$this->reqAreas[$area] = 1;
					} else {
						$this->reqAreas[$area] = 0;
					}
				}
			}
		}
	}

	/**
	 * Extract a list of all recognized HTTP links in the text.
	 * @param string $text
	 * @return string $linkList, list of clickable links
	 */
	public static function parseLinks( $text ) {
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
				// @FIXME: other protocals
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

	/**
	 * @param $submitType string
	 * @param $name string User name
	 * @param $errors array
	 */
	protected function showSuccess( $submitType, $name = null, $errors = array() ) {
		$out = $this->getOutput();

		$out->setPagetitle( wfMsgHtml('actioncomplete') );
		if( $this->submitType == 'accept' ) {
			$out->addWikiMsg( 'confirmaccount-acc', $name );
		} elseif( $this->submitType == 'reject' || $this->submitType == 'spam' ) {
			$out->addWikiMsg( 'confirmaccount-rej' );
		} else {
			$out->redirect( $this->getFullTitle()->getFullUrl() );
			return;
		}
		# Output any errors
		foreach( $errors as $error ) {
			$out->addHTML( '<p>' . $error . '</p>' );
		}
		# Give link to see other requests
		$out->returnToMain( true, $this->getFullTitle() );
	}

	protected function showList() {
		$out = $this->getOutput();

		# Output the list
		$pager = new ConfirmAccountsPager( $this, array(),
			$this->queueType, $this->showRejects, $this->showHeld, $this->showStale );

		if( $pager->getNumRows() ) {
			if( $this->showStale ) {
				$out->addHTML( wfMsgExt('confirmaccount-list3', array('parse') ) );
			} elseif( $this->showRejects ) {
				$out->addHTML( wfMsgExt('confirmaccount-list2', array('parse') ) );
			} else {
				$out->addHTML( wfMsgExt('confirmaccount-list', array('parse') ) );
			}
			$out->addHTML( $pager->getNavigationBar() );
			$out->addHTML( $pager->getBody() );
			$out->addHTML( $pager->getNavigationBar() );
		} else {
			if( $this->showRejects ) {
				$out->addHTML( wfMsgExt('confirmaccount-none-r', array('parse')) );
			} elseif( $this->showStale ) {
				$out->addHTML( wfMsgExt('confirmaccount-none-e', array('parse')) );
			} elseif( $this->showHeld ) {
				$out->addHTML( wfMsgExt('confirmaccount-none-h', array('parse')) );
			} else {
				$out->addHTML( wfMsgExt('confirmaccount-none-o', array('parse')) );
			}
		}

		# Every 30th view, prune old deleted items
		if( 0 == mt_rand( 0, 29 ) ) {
			ConfirmAccount::runAutoMaintenance();
		}
	}

	/**
	 * @param $row
	 * @return string
	 */
	public function formatRow( $row ) {
		global $wgUseRealNamesOnly, $wgAllowRealName, $wgMemc;

		if ( $this->showRejects || $this->showStale ) {
			$link = Linker::makeKnownLinkObj(
				$this->getFullTitle(),
				wfMsgHtml('confirmaccount-review'),
				'acrid=' . (int)$row->acr_id . '&wpShowRejects=1' );
		} else {
			$link = Linker::makeKnownLinkObj(
				$this->getFullTitle(),
				wfMsgHtml( 'confirmaccount-review' ),
				'acrid=' . (int)$row->acr_id );
		}
		$time = $this->getLang()->timeanddate( wfTimestamp(TS_MW, $row->acr_registration), true );

		$r = "<li class='mw-confirmaccount-type-{$this->queueType}'>";

		$r .= $time." (<strong>{$link}</strong>)";
		# Auto-rejected accounts have a user ID of zero
		if( $row->acr_rejected && $row->acr_user ) {
			$datim = $this->getLang()->timeanddate( wfTimestamp(TS_MW, $row->acr_rejected), true );
			$date = $this->getLang()->date( wfTimestamp(TS_MW, $row->acr_rejected), true );
			$time = $this->getLang()->time( wfTimestamp(TS_MW, $row->acr_rejected), true );
			$r .= ' <b>'.wfMsgExt( 'confirmaccount-reject', array('parseinline'), $row->user_name, $datim, $date, $time ).'</b>';
		} elseif( $row->acr_held && !$row->acr_rejected ) {
			$datim = $this->getLang()->timeanddate( wfTimestamp(TS_MW, $row->acr_held), true );
			$date = $this->getLang()->date( wfTimestamp(TS_MW, $row->acr_held), true );
			$time = $this->getLang()->time( wfTimestamp(TS_MW, $row->acr_held), true );
			$r .= ' <b>'.wfMsgExt( 'confirmaccount-held', array('parseinline'), User::whoIs($row->acr_user), $datim, $date, $time ).'</b>';
		}
		# Check if someone is viewing this request
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
		$preview = $this->getLang()->truncate( $bio, 400, '' );
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

	function __construct(
		$form, $conds = array(), $type, $rejects=false, $showHeld=false, $showStale=false
	) {
		$this->mForm = $form;
		$this->mConds = $conds;

		$this->mConds['acr_type'] = $type;

		$this->rejects = $rejects;
		$this->stale = $showStale;
		if( $rejects || $showStale ) {
			$this->mConds['acr_deleted'] = 1;
		} else {
			$this->mConds['acr_deleted'] = 0;
			if( $showHeld ) {
				$this->mConds[] = 'acr_held IS NOT NULL';
			} else {
				$this->mConds[] = 'acr_held IS NULL';
			}

		}
		parent::__construct();
		# Treat 20 as the default limit, since each entry takes up 5 rows.
		$urlLimit = $this->mRequest->getInt( 'limit' );
		$this->mLimit = $urlLimit ? $urlLimit : 20;
	}

	/**
	 * @return Title
	 */
	function getTitle() {
		return $this->mForm->getFullTitle();
	}

	/**
	 * @param $row
	 * @return string
	 */
	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	/**
	 * @return string
	 */
	function getStartBody() {
		if ( $this->getNumRows() ) {
			return '<ul>';
		} else {
			return '';
		}
	}

	/**
	 * @return string
	 */
	function getEndBody() {
		if ( $this->getNumRows() ) {
			return '</ul>';
		} else {
			return '';
		}
	}

	/**
	 * @return array
	 */
	function getQueryInfo() {
		$conds = $this->mConds;
		$tables = array( 'account_requests' );
		$fields = array( 'acr_id','acr_name','acr_real_name','acr_registration','acr_held','acr_user',
			'acr_email','acr_email_authenticated','acr_bio','acr_notes','acr_urls','acr_type','acr_rejected' );
		# Stale requests have a user ID of zero
		if( $this->stale ) {
			$conds[] = 'acr_user = 0';
		} elseif( $this->rejects ) {
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

	/**
	 * @return string
	 */
	function getIndexField() {
		return 'acr_registration';
	}
}
