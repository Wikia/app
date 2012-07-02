<?php

class UpdatePoll extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'UpdatePoll' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgPollScripts;

		// Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		/**
		 * Redirect Non-logged in users to Login Page
		 * It will automatically return them to the UpdatePoll page
		 */
		if( $wgUser->getID() == 0 ) {
			$wgOut->setPageTitle( wfMsgHtml( 'poll-woops' ) );
			$login = SpecialPage::getTitleFor( 'Userlogin' );
			$wgOut->redirect( $login->getFullURL( 'returnto=Special:UpdatePoll' ) );
			return false;
		}

		// Add CSS & JS
		$wgOut->addScriptFile( $wgPollScripts . '/Poll.js' );
		$wgOut->addExtensionStyle( $wgPollScripts . '/Poll.css' );

		if( $wgRequest->wasPosted() && $_SESSION['alreadysubmitted'] == false ) {
			$_SESSION['alreadysubmitted'] = true;
			$p = new Poll();
			$poll_info = $p->getPoll( $wgRequest->getInt( 'id' ) );

			// Add Choices
			for( $x = 1; $x <= 10; $x++ ) {
				if( $wgRequest->getVal( "poll_answer_{$x}" ) ) {
					$dbw = wfGetDB( DB_MASTER );

					$dbw->update(
						'poll_choice',
						array( 'pc_text' => $wgRequest->getVal( "poll_answer_{$x}" ) ),
						array(
							'pc_poll_id' => intval( $poll_info['id'] ),
							'pc_order' => $x
						),
						__METHOD__
					);
				}
			}

			// Update image
			if( $wgRequest->getVal( 'poll_image_name' ) ) {
				$dbw = wfGetDB( DB_MASTER );

				$dbw->update(
					'poll_question',
					array( 'poll_image' => $wgRequest->getVal( 'poll_image_name' ) ),
					array( 'poll_id' => intval( $poll_info['id'] ) ),
					__METHOD__
				);
			}

			$prev_qs = '';
			$poll_page = Title::newFromID( $wgRequest->getInt( 'id' ) );
			if( $wgRequest->getInt( 'prev_poll_id' ) ) {
				$prev_qs = 'prev_id=' . $wgRequest->getInt( 'prev_poll_id' );
			}

			// Redirect to new Poll Page
			$wgOut->redirect( $poll_page->getFullURL( $prev_qs ) );
		} else {
			$_SESSION['alreadysubmitted'] = false;
			$wgOut->addHTML( $this->displayForm() );
		}
	}

	/**
	 * Display the form for updating a given poll (via the id parameter in the
	 * URL).
	 * @return String: HTML
	 */
	function displayForm() {
		global $wgUser, $wgOut, $wgRequest, $wgScriptPath, $wgHooks;

		$p = new Poll();
		$poll_info = $p->getPoll( $wgRequest->getInt( 'id' ) );

		if(
			!$poll_info['id'] ||
			!( $wgUser->isAllowed( 'polladmin' ) || $wgUser->getID() == $poll_info['user_id'] )
		) {
			$wgOut->setPageTitle( wfMsgHtml( 'poll-woops' ) );
			$wgOut->addHTML( wfMsg( 'poll-edit-invalid-access' ) );
			return false;
		}

		$poll_image_tag = '';
		if( $poll_info['image'] ) {
			$poll_image_width = 150;
			$poll_image = wfFindFile( $poll_info['image'] );
			$poll_image_url = $width = '';
			if ( is_object( $poll_image ) ) {
				$poll_image_url = $poll_image->createThumb( $poll_image_width );
				if ( $poll_image->getWidth() >= $poll_image_width ) {
					$width = $poll_image_width;
				} else {
					$width = $poll_image->getWidth();
				}
			}
			$poll_image_tag = '<img width="' . $width . '" alt="" src="' . $poll_image_url . '"/>';
		}

		$poll_page = Title::newFromID( $wgRequest->getInt( 'id' ) );
		$prev_qs = '';
		if( $wgRequest->getInt( 'prev_poll_id' ) ) {
			$prev_qs = 'prev_id=' . $wgRequest->getInt( 'prev_poll_id' );
		}

		// i18n for JS (by SpecialCreatePoll.php, to reduce code duplication)
		$wgHooks['MakeGlobalVariablesScript'][] = 'CreatePoll::addJSGlobals';

		$wgOut->setPageTitle( wfMsg( 'poll-edit-title', $poll_info['question'] ) );

		$form = "<div class=\"update-poll-left\">
			<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\">
			<input type=\"hidden\" name=\"poll_id\" value=\"{$poll_info['id']}\" />
			<input type=\"hidden\" name=\"prev_poll_id\" value=\"" . $wgRequest->getInt( 'prev_id' ) . '" />
			<input type="hidden" name="poll_image_name" id="poll_image_name" />

			<h1>' . wfMsg( 'poll-edit-answers' ) . '</h1>';

		$x = 1;
		foreach( $poll_info['choices'] as $choice ) {
			$form .= "<div class=\"update-poll-answer\">
					<span class=\"update-poll-answer-number\">{$x}.</span>
					<input type=\"text\" tabindex=\"{$x}\" id=\"poll_answer_{$x}\" name=\"poll_answer_{$x}\" value=\"" .
						htmlspecialchars( $choice['choice'], ENT_QUOTES ) . '" />
				</div>';
			$x++;
		}

		global $wgRightsText;
		if ( $wgRightsText ) {
			$copywarnMsg = 'copyrightwarning';
			$copywarnMsgParams = array(
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]',
				$wgRightsText
			);
		} else {
			$copywarnMsg = 'copyrightwarning2';
			$copywarnMsgParams = array(
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]'
			);
		}

		$form .= '</div>

			<div class="update-poll-right">
			<h1>' . wfMsg( 'poll-edit-image' ) . "</h1>
			<div id=\"poll_image\" class=\"update-poll-image\">{$poll_image_tag}</div>

			<!--
				<div id=\"fake-form\" style=\"display:block;height:70px;\">
					<input type=\"file\" size=\"40\" disabled=\"disabled\" />
					<div style=\"margin:9px 0px 0px 0px;\">
						<input type=\"button\" value=\"Upload\"/>
					</div>
				</div>
			-->
			<div id=\"real-form\" style=\"display:block;height:90px;\">
				<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"610\"
					scrolling=\"no\" frameborder=\"0\" src=\"" .
					SpecialPage::getTitleFor( 'PollAjaxUpload' )->escapeFullURL( 'wpThumbWidth=75' ) . '">
				</iframe>
			</div>

		</div>
		<div class="cleared"></div>
		<div class="update-poll-warning">' . wfMsgExt( $copywarnMsg, 'parse', $copywarnMsgParams ) . "</div>
		<div class=\"update-poll-buttons\">
			<input type=\"button\" class=\"site-button\" value=\"" . wfMsg( 'poll-edit-button' ) . "\" size=\"20\" onclick=\"document.form1.submit()\" />
			<input type=\"button\" class=\"site-button\" value=\"" . wfMsg( 'poll-cancel-button' ) . "\" size=\"20\" onclick=\"window.location='" . $poll_page->getFullURL( $prev_qs ) . "'\" />
		</div>
		</form>";
		return $form;
	}
}