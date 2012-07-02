<?php
/**
 * A special page for viewing the fanboxes of a user, either someone else or
 * yourself.
 *
 * @file
 * @ingroup Extensions
 */
class ViewFanBoxes extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ViewUserBoxes' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgFanBoxScripts;

		// Redirect Non-logged in users to Login Page
		if( $wgUser->getID() == 0 && $user_name == '' ) {
			$login = SpecialPage::getTitleFor( 'Userlogin' );
			$wgOut->redirect( $login->escapeFullURL( 'returnto=Special:ViewUserBoxes' ) );
			return false;
		}

		$tagParser = new Parser();
		$wgOut->addScriptFile( $wgFanBoxScripts . '/FanBoxes.js' );
		$wgOut->addExtensionStyle( $wgFanBoxScripts . '/FanBoxes.css' );

		$wgOut->setPageTitle( wfMsgHtml( 'fanbox-nav-header' ) );

		// Code for viewing fanboxes for each user
		$output = '';
		$user_name = $wgRequest->getVal( 'user', $par );
		$page = $wgRequest->getInt( 'page', 1 );

		// If no user is set in the URL, we assume it's the current user
		if( !$user_name ) {
			$user_name = $wgUser->getName();
		}
		$user_id = User::idFromName( $user_name );
		$user = Title::makeTitle( NS_USER, $user_name );

		// Error message for username that does not exist (from URL)
		if( $user_id == 0 ) {
			$wgOut->setPageTitle( wfMsg( 'fanbox-woops' ) );
			$wgOut->addHTML( wfMsg( 'fanbox-userdoesnotexist' ) );
			return false;
		}

		// Config for the page
		$per_page = 30;

		// Get all FanBoxes for this user into the array
		// Calls the FanBoxesClass file
		$userfan = new UserFanBoxes( $user_name );
		$userFanboxes = $userfan->getUserFanboxes( 0, $per_page, $page );
		$total = $userfan->getFanBoxCountByUsername( $user_name );
		$per_row = 3;

		// Page title and top part
		$wgOut->setPageTitle( wfMsgHtml( 'f-list-title', $userfan->user_name ) );
		$output .= '<div class="back-links">
				<a href="' . $user->getFullURL() . '">' .
					wfMsgHtml( 'f-back-link', $userfan->user_name ) .
				'</a>
			</div>
			<div class="fanbox-count">' .
				wfMsgExt( 'f-count', 'parsemag', $userfan->user_name, $total ) .
			'</div>

			<div class="view-fanboxes-container clearfix">';

		if( $userFanboxes ) {
			$x = 1;

			foreach( $userFanboxes as $userfanbox ) {
				$check_user_fanbox = $userfan->checkIfUserHasFanbox( $userfanbox['fantag_id'] );

				if( $userfanbox['fantag_image_name'] ) {
					$fantag_image_width = 45;
					$fantag_image_height = 53;
					$fantag_image = wfFindFile( $userfanbox['fantag_image_name'] );
					$fantag_image_url = '';
					if ( is_object( $fantag_image ) ) {
						$fantag_image_url = $fantag_image->createThumb(
							$fantag_image_width,
							$fantag_image_height
						);
					}
					$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '" />';
				}

				if( $userfanbox['fantag_left_text'] == '' ) {
					$fantag_leftside = $fantag_image_tag;
				} else {
					$fantag_leftside = $userfanbox['fantag_left_text'];
					$fantag_leftside = $tagParser->parse(
						$fantag_leftside, $wgTitle,
						$wgOut->parserOptions(), false
					);
					$fantag_leftside = $fantag_leftside->getText();
				}

				$leftfontsize = '12px';
				if( $userfanbox['fantag_left_textsize'] == 'mediumfont' ) {
					$leftfontsize = '14px';
				}
				if( $userfanbox['fantag_left_textsize'] == 'bigfont' ) {
					$leftfontsize = '20px';
				}

				$rightfontsize = '10px';
				if( $userfanbox['fantag_right_textsize'] == 'smallfont' ) {
					$rightfontsize = '12px';
				}
				if( $userfanbox['fantag_right_textsize'] == 'mediumfont' ) {
					$rightfontsize = '14px';
				}

				// Get permalink
				$fantag_title = Title::makeTitle( NS_FANTAG, $userfanbox['fantag_title'] );

				$right_text = $userfanbox['fantag_right_text'];
				$right_text = $tagParser->parse(
					$right_text,
					$wgTitle,
					$wgOut->parserOptions(),
					false
				);
				$right_text = $right_text->getText();

				// Output fanboxes
				$output .= '<span class="top-fanbox">
				<div class="fanbox-item">
				<div class="individual-fanboxtest" id="individualFanbox' . $userfanbox['fantag_id'] . '">
				<div class="show-message-container" id="show-message-container' . $userfanbox['fantag_id'] . '">
				<div class="permalink-container">
				<a class="perma" style="font-size:8px; color:' . $userfanbox['fantag_right_textcolor'] . '" href="' . $fantag_title->escapeFullURL() . "\" title=\"{$userfanbox['fantag_title']}\">" . wfMsg( 'fanbox-perma' ) . "</a>
				<table class=\"fanBoxTable\" onclick=\"javascript:FanBoxes.openFanBoxPopup('fanboxPopUpBox{$userfanbox['fantag_id']}', 'individualFanbox{$userfanbox['fantag_id']}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
					<tr>
						<td id=\"fanBoxLeftSideOutput\" style=\"color:" . $userfanbox['fantag_left_textcolor'] . "; font-size:$leftfontsize\" bgcolor=\"" . $userfanbox['fantag_left_bgcolor'] . '">' . $fantag_leftside . "</td>
						<td id=\"fanBoxRightSideOutput\" style=\"color:" . $userfanbox['fantag_right_textcolor'] . "; font-size:$rightfontsize\" bgcolor=\"" . $userfanbox['fantag_right_bgcolor'] . '">' . $right_text . '</td>
					</tr>
				</table>
				</div>
				</div>
				</div>';

				if( $wgUser->isLoggedIn() ) {
					if( $check_user_fanbox == 0 ) {
						$output .= '
					<div class="fanbox-pop-up-box" id="fanboxPopUpBox' . $userfanbox['fantag_id'] . '">
					<table cellpadding="0" cellspacing="0" width="258px">
						<tr>
							<td align="center">' . wfMsg( 'fanbox-add-fanbox' ) . '</td>
						</tr>
						<tr>
							<td align="center">
								<input type="button" value="' . wfMsg( 'fanbox-add' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$userfanbox['fantag_id']}', 'individualFanbox{$userfanbox['fantag_id']}'); FanBoxes.showAddRemoveMessageUserPage(1, {$userfanbox['fantag_id']}, 'show-addremove-message')\" />
								<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$userfanbox['fantag_id']}', 'individualFanbox{$userfanbox['fantag_id']}')\" />
							</td>
						</tr>
					</table>
					</div>";
					} else {
						$output .= '
					<div class="fanbox-pop-up-box" id="fanboxPopUpBox' . $userfanbox['fantag_id'] . '">
					<table cellpadding="0" cellspacing="0" width="258px">
						<tr>
							<td align="center">' . wfMsg( 'fanbox-remove-fanbox' ) . '</td>
						</tr>
						<tr>
							<td align="center">
								<input type="button" value="' . wfMsg( 'fanbox-remove' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$userfanbox['fantag_id']}', 'individualFanbox{$userfanbox['fantag_id']}'); FanBoxes.showAddRemoveMessageUserPage(2, {$userfanbox['fantag_id']}, 'show-addremove-message')\" />
								<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$userfanbox['fantag_id']}', 'individualFanbox{$userfanbox['fantag_id']}')\" />
							</td>
						</tr>
					</table>
					</div>";
					}
				}

				if( $wgUser->getID() == 0 ) {
					$login = SpecialPage::getTitleFor( 'Userlogin' );
					$output .= '<div class="fanbox-pop-up-box" id="fanboxPopUpBox' . $userfanbox['fantag_id'] . '">
					<table cellpadding="0" cellspacing="0" width="258px">
						<tr>
							<td align="center">' .
								wfMsg( 'fanbox-add-fanbox-login' ) .
								"<a href=\"{$login->getFullURL()}\">" .
								wfMsg( 'fanbox-login' ) . '</a></td>
						</tr>
						<tr>
							<td align="center">
								<input type="button" value="' . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$userfanbox['fantag_id']}', 'individualFanbox{$userfanbox['fantag_id']}')\" />
							</td>
						</tr>
					</table>
				</div>";
				}

				$output .= '</div></span>';

				if( $x == count( $userFanboxes ) || $x != 1 && $x % $per_row == 0 ) {
					$output .= '<div class="cleared"></div>';
				}
				$x++;
			}
		}

		$output .= '</div>';

		// Build next/prev nav
		$numofpages = $total / $per_page;

		if( $numofpages > 1 ) {
			$output .= '<div class="page-nav">';
			if( $page > 1 ) {
				$output .= '<a href="' . $this->getTitle()->escapeFullURL(
					array( 'user' => $user_name, 'page' => ( $page - 1 ) ) ) .
					'">' . wfMsg( 'fanbox-prev' ) . '</a> ';
			}

			if( ( $total % $per_page ) != 0 ) {
				$numofpages++;
			}
			if( $numofpages >= 9 && $page < $total ) {
				$numofpages = 9 + $page;
			}
			if( $numofpages >= ( $total / $per_page ) ) {
				$numofpages = ( $total / $per_page ) + 1;
			}

			for( $i = 1; $i <= $numofpages; $i++ ) {
				if( $i == $page ) {
					$output .= ( $i . ' ' );
				} else {
					$output .= '<a href="' . $this->getTitle()->escapeFullURL(
						array( 'user' => $user_name, 'page' => $i ) ) .
						"\">$i</a> ";
				}
			}

			if( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . $this->getTitle()->escapeFullURL(
					array( 'user' => $user_name, 'page' => ( $page + 1 ) ) ) .
					'">' . wfMsg( 'fanbox-next' ) . '</a>';
			}
			$output .= '</div>';
		}

		// Output everything
		$wgOut->addHTML( $output );
	}

}