<?php
/**
 * A special page to show either the most popular userboxes (default) or
 * alternatively, the newest userboxes.
 *
 * @file
 * @ingroup Extensions
 */
class TopFanBoxes extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'TopUserboxes' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgFanBoxScripts;

		// Add CSS & JS
		$wgOut->addExtensionStyle( $wgFanBoxScripts . '/FanBoxes.css' );
		$wgOut->addScriptFile( $wgFanBoxScripts . '/FanBoxes.js' );

		$topfanboxId = $wgRequest->getVal( 'id' );
		$topfanboxCategory = $wgRequest->getVal( 'cat' );

		if( $topfanboxId == 'fantag_date' ) {
			$wgOut->setPageTitle( wfMsg( 'most-recent-fanboxes-link' ) );
			$topfanboxes = $this->getTopFanboxes( 'fantag_date' );
		} else {
			$wgOut->setPageTitle( wfMsg( 'topuserboxes' ) );
			$topfanboxes = $this->getTopFanboxes( 'fantag_count' );
		}

		$output = '';

		// Make top right nav bar
		$output .= '<div class="fanbox-nav">
			<h2>' . wfMsg( 'fanbox-nav-header' ) . "</h2>
			<p><a href=\"{$this->getTitle()->escapeFullURL()}\">" .
				wfMsg( 'top-fanboxes-link' ) . '</a></p>
			<p><a href="' . $this->getTitle()->escapeFullURL( 'id=fantag_date' ) . '">' .
				wfMsg( 'most-recent-fanboxes-link' ) . '</a></p>
		</div>';

		// Nothing? That means that no userboxes have been created yet...so
		// show a message to the user about that, prompting them to create some
		// userboxes
		if ( empty( $topfanboxes ) ) {
			$output .= wfMsgExt( 'fanbox-top-list-is-empty', 'parse' );
		}

		if( !$topfanboxCategory ) {
			$x = 1;

			$output .= '<div class="top-fanboxes">';

			$tagParser = new Parser();

			foreach( $topfanboxes as $topfanbox ) {
				$check_user_fanbox = $this->checkIfUserHasFanbox( $topfanbox['fantag_id'] );

				if( $topfanbox['fantag_image_name'] ) {
					$fantag_image_width = 45;
					$fantag_image_height = 53;
					$fantag_image = wfFindFile( $topfanbox['fantag_image_name'] );
					$fantag_image_url = '';
					if ( is_object( $fantag_image ) ) {
						$fantag_image_url = $fantag_image->createThumb(
							$fantag_image_width,
							$fantag_image_height
						);
					}
					$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '"/>';
				}

				if( $topfanbox['fantag_left_text'] == '' ) {
					$fantag_leftside = $fantag_image_tag;
				} else {
					$fantag_leftside = $topfanbox['fantag_left_text'];
					$fantag_leftside = $tagParser->parse(
						$fantag_leftside, $wgTitle,
						$wgOut->parserOptions(), false
					);
					$fantag_leftside = $fantag_leftside->getText();
				}

				if( $topfanbox['fantag_left_textsize'] == 'mediumfont' ) {
					$leftfontsize = '14px';
				}
				if( $topfanbox['fantag_left_textsize'] == 'bigfont' ) {
					$leftfontsize = '20px';
				}

				if( $topfanbox['fantag_right_textsize'] == 'smallfont' ) {
					$rightfontsize = '12px';
				}
				if( $topfanbox['fantag_right_textsize'] == 'mediumfont' ) {
					$rightfontsize = '14px';
				}

				// Get permalink
				$fantag_title = Title::makeTitle( NS_FANTAG, $topfanbox['fantag_title'] );

				// Get creator
				$userftusername = $topfanbox['fantag_user_name'];
				$userftuserid = $topfanbox['fantag_user_id'];
				$user_title = Title::makeTitle( NS_USER, $topfanbox['fantag_user_name'] );
				$avatar = new wAvatar( $topfanbox['fantag_user_id'], 'm' );

				$right_text = $topfanbox['fantag_right_text'];
				$right_text = $tagParser->parse(
					$right_text, $wgTitle, $wgOut->parserOptions(), false
				);
				$right_text = $right_text->getText();

				$output .= "
				<div class=\"top-fanbox-row\">
				<span class=\"top-fanbox-num\">{$x}.</span><span class=\"top-fanbox\">

				<div class=\"fanbox-item\">

				<div class=\"individual-fanbox\" id=\"individualFanbox" . $topfanbox['fantag_id'] . "\">
					<div class=\"show-message-container\" id=\"show-message-container" . $topfanbox['fantag_id'] . "\">
						<div class=\"permalink-container\">
						<a class=\"perma\" style=\"font-size:8px; color:" . $topfanbox['fantag_right_textcolor'] . "\" href=\"" . $fantag_title->escapeFullURL() . "\" title=\"{$topfanbox['fantag_title']}\">" . wfMsg( 'fanbox-perma' ) . "</a>
						<table class=\"fanBoxTable\" onclick=\"javascript:FanBoxes.openFanBoxPopup('fanboxPopUpBox{$topfanbox['fantag_id']}', 'individualFanbox{$topfanbox['fantag_id']}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
						<tr>
							<td id=\"fanBoxLeftSideOutput\" style=\"color:" . $topfanbox['fantag_left_textcolor'] . "; font-size:$leftfontsize\" bgcolor=\"" . $topfanbox['fantag_left_bgcolor'] . "\">" . $fantag_leftside . "</td>
							<td id=\"fanBoxRightSideOutput\" style=\"color:" . $topfanbox['fantag_right_textcolor'] . "; font-size:$rightfontsize\" bgcolor=\"" . $topfanbox['fantag_right_bgcolor'] . "\">" . $right_text . "</td>
						</tr>
						</table>
						</div>
					</div>
				</div>";

				if( $wgUser->isLoggedIn() ) {
					if( $check_user_fanbox == 0 ) {
						$output .= "
					<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox" . $topfanbox['fantag_id'] . "\">
					<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\">
						<tr>
							<td align=\"center\">" . wfMsg( 'fanbox-add-fanbox' ) . "</td>
						</tr>
						<tr>
							<td align=\"center\">
								<input type=\"button\" value=\"" . wfMsg( 'fanbox-add' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$topfanbox['fantag_id']}', 'individualFanbox{$topfanbox['fantag_id']}'); FanBoxes.showAddRemoveMessageUserPage(1, {$topfanbox['fantag_id']}, 'show-addremove-message')\" />
								<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$topfanbox['fantag_id']}', 'individualFanbox{$topfanbox['fantag_id']}')\" />
							</td>
						</tr>
					</table>
					</div>";
					} else {
						$output .= "
					<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox" . $topfanbox['fantag_id'] . "\">
					<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\">
						<tr>
							<td align=\"center\">" . wfMsg( 'fanbox-remove-fanbox' ) . "</td>
						</tr>
						<tr>
							<td align=\"center\">
								<input type=\"button\" value=\"" . wfMsg( 'fanbox-remove' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$topfanbox['fantag_id']}', 'individualFanbox{$topfanbox['fantag_id']}'); FanBoxes.showAddRemoveMessageUserPage(2, {$topfanbox['fantag_id']}, 'show-addremove-message')\" />
								<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$topfanbox['fantag_id']}', 'individualFanbox{$topfanbox['fantag_id']}')\" />
							</td>
						</tr>
					</table>
					</div>";
					}
				}

				if( $wgUser->getID() == 0 ) {
					$login = SpecialPage::getTitleFor( 'Userlogin' );
					$output .= "<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox" . $topfanbox['fantag_id'] . "\">
					<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\">
						<tr>
							<td align=\"center\">" . wfMsg( 'fanbox-add-fanbox-login' ) .
								" <a href=\"{$login->getFullURL()}\">" . wfMsg( 'fanbox-login' ) . "</a>
							</td>
						</tr>
						<tr>
							<td align=\"center\">
								<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$topfanbox['fantag_id']}', 'individualFanbox{$topfanbox['fantag_id']}')\" />
							</td>
						</tr>
					</table>
					</div>";
				}

				$output .= '</div></span>';
				$output .= '<div class="top-fanbox-users">
					<table>
						<tr>
							<td class="centerheight">
								<b><a href="' . $fantag_title->escapeFullURL() . '">' .
									wfMsgExt(
										'fanbox-members',
										'parsemag',
										$topfanbox['fantag_count']
									) .
								'</a></b>
							</td>
						</tr>
					</table>
				</div>';
				$output .= '<div class="cleared"></div>';
				$output .= '</div>';

				$x++;

			}
			$output .= '</div><div class="cleared"></div>';
		}

		if( $topfanboxCategory ) {
			$x = 1;

			$output .= '<div class="top-fanboxes">';

			// This variable wasn't originally defined, I'm not sure that this
			// is 100% correct, but...
			$categoryfanboxes = $this->getFanBoxByCategory( $topfanboxCategory );

			foreach( $categoryfanboxes as $categoryfanbox ) {
				$check_user_fanbox = $this->checkIfUserHasFanbox( $categoryfanbox['fantag_id'] );

				if( $categoryfanbox['fantag_image_name'] ) {
					$fantag_image_width = 45;
					$fantag_image_height = 53;
					$fantag_image = wfFindFile( $categoryfanbox['fantag_image_name'] );
					$fantag_image_url = '';
					if ( is_object( $fantag_image ) ) {
						$fantag_image_url = $fantag_image->createThumb(
							$fantag_image_width,
							$fantag_image_height
						);
					}
					$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '"/>';
				}

				if( $categoryfanbox['fantag_left_text'] == '' ) {
					$fantag_leftside = $fantag_image_tag;
				} else {
					$fantag_leftside = $categoryfanbox['fantag_left_text'];
				}

				if( $categoryfanbox['fantag_left_textsize'] == 'mediumfont' ) {
					$leftfontsize = '14px';
				}
				if( $categoryfanbox['fantag_left_textsize'] == 'bigfont' ) {
					$leftfontsize = '20px';
				}

				if( $categoryfanbox['fantag_right_textsize'] == 'smallfont' ) {
					$rightfontsize = '12px';
				}
				if( $categoryfanbox['fantag_right_textsize'] == 'mediumfont' ) {
					$rightfontsize = '14px';
				}

				// Get permalink
				$fantag_title = Title::makeTitle( NS_FANTAG, $categoryfanbox['fantag_title'] );

				// Get creator
				$userftusername = $categoryfanbox['fantag_user_name'];
				$userftuserid = $categoryfanbox['fantag_user_id'];
				$user_title = Title::makeTitle( NS_USER, $categoryfanbox['fantag_user_name'] );
				$avatar = new wAvatar( $categoryfanbox['fantag_user_id'], 'm' );

				$output .= "
				<div class=\"top-fanbox-row\">
				<span class=\"top-fanbox-num\">{$x}.</span><div class=\"top-fanbox\">

				<div class=\"fanbox-item\">

				<div class=\"individual-fanbox\" id=\"individualFanbox" . $categoryfanbox['fantag_id'] . "\">
				<div class=\"show-message-container\" id=\"show-message-container" . $categoryfanbox['fantag_id'] . "\">
					<div class=\"permalink-container\">
					<a class=\"perma\" style=\"font-size:8px; color:" . $categoryfanbox['fantag_right_textcolor'] . "\" href=\"" . $fantag_title->escapeFullURL() . "\" title=\"{$categoryfanbox['fantag_title']}\">" . wfMsg( 'fanbox-perma' ) . "</a>
					<table class=\"fanBoxTable\" onclick=\"javascript:FanBoxes.openFanBoxPopup('fanboxPopUpBox{$categoryfanbox['fantag_id']}', 'individualFanbox{$categoryfanbox['fantag_id']}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
						<tr>
							<td id=\"fanBoxLeftSideOutput\" style=\"color:" . $categoryfanbox['fantag_left_textcolor'] . "; font-size:$leftfontsize\" bgcolor=\"" . $categoryfanbox['fantag_left_bgcolor'] . "\">" . $fantag_leftside . "</td>
							<td id=\"fanBoxRightSideOutput\" style=\"color:" . $categoryfanbox['fantag_right_textcolor'] . "; font-size:$rightfontsize\" bgcolor=\"" . $categoryfanbox['fantag_right_bgcolor'] . "\">" . $categoryfanbox['fantag_right_text'] . '</td>
						</tr>
					</table>
					</div>
				</div>
				</div>';

				if( $wgUser->isLoggedIn() ) {
					if( $check_user_fanbox == 0 ) {
						$output .= "
					<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox" . $categoryfanbox['fantag_id'] . "\">
					<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\">
						<tr>
							<td align=\"center\">" . wfMsg( 'fanbox-add-fanbox' ) . "</td>
						</tr>
						<tr>
							<td align=\"center\">
								<input type=\"button\" value=\"" . wfMsg( 'fanbox-add' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$categoryfanbox["fantag_id"]}', 'individualFanbox{$categoryfanbox["fantag_id"]}'); FanBoxes.showAddRemoveMessageUserPage(1, {$categoryfanbox["fantag_id"]}, 'show-addremove-message')\" />
								<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$categoryfanbox["fantag_id"]}', 'individualFanbox{$categoryfanbox["fantag_id"]}')\" />
							</td>
						</tr>
					</table>
					</div>";
					} else {
						$output .= "
					<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox" . $categoryfanbox['fantag_id'] . "\">
					<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\">
						<tr>
							<td align=\"center\">" . wfMsg( 'fanbox-remove-fanbox' ) . "</td>
						</tr>
						<tr>
							<td align=\"center\">
								<input type=\"button\" value=\"" . wfMsg( 'fanbox-remove' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$categoryfanbox['fantag_id']}', 'individualFanbox{$categoryfanbox['fantag_id']}'); FanBoxes.showAddRemoveMessageUserPage(2, {$categoryfanbox['fantag_id']}, 'show-addremove-message')\" />
								<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$categoryfanbox['fantag_id']}', 'individualFanbox{$categoryfanbox['fantag_id']}')\" />
							</td>
						</tr>
					</table>
					</div>";
					}
				}

				if( $wgUser->getID() == 0 ) {
					$login = SpecialPage::getTitleFor( 'Userlogin' );
					$output .= "<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox" . $categoryfanbox['fantag_id'] . "\">
					<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\">
						<tr>
							<td align=\"center\">" . wfMsg( 'fanbox-add-fanbox-login' ) .
								" <a href=\"{$login->getFullURL()}\">" . wfMsg( 'fanbox-login' ) . "</a>
							</td>
						</tr>
						<tr>
							<td align=\"center\">
								<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$categoryfanbox['fantag_id']}', 'individualFanbox{$categoryfanbox['fantag_id']}')\" />
							</td>
						</tr>
					</table>
					</div>";
				}

				$output .= '</div></div>';
				$output .= '<div class="top-fanbox-creator">
				<table>
					<tr>
					<td class="centerheight"> <b> ' . wfMsg( 'fanbox-created-by' ) . ' <b> </td>
					<td class="centerheight"> <b> <a href="' . $user_title->escapeFullURL() . "\">
						{$avatar->getAvatarURL()}
						</a></b>
					</td>
					</tr>
				</table>
				</div>";
				$output .= '<div class="top-fanbox-users">
					<table>
						<tr>
							<td class="centerheight">
								<b><a href="' . $fantag_title->escapeFullURL() . '">' .
									wfMsg( 'fanbox-members', $categoryfanbox['fantag_count'] ).
								'</a></b>
							</td>
						</tr>
					</table>
				</div>';
				$output .= '<div class="cleared"></div>';
				$output .= '</div>';

				$x++;

			}
			$output .= '</div><div class="cleared"></div>';

		}
		$wgOut->addHTML( $output );

	}

	function getTopFanboxes( $orderBy ) {
		$dbr = wfGetDB( DB_MASTER );

		$res = $dbr->select(
			'fantag',
			array(
				'fantag_id', 'fantag_title', 'fantag_pg_id', 'fantag_left_text',
				'fantag_left_textcolor', 'fantag_left_bgcolor',
				'fantag_right_text', 'fantag_right_textcolor',
				'fantag_right_bgcolor', 'fantag_image_name',
				'fantag_left_textsize', 'fantag_right_textsize', 'fantag_count',
				'fantag_user_id', 'fantag_user_name', 'fantag_date'
			),
			array(),
			__METHOD__,
			array( 'ORDER BY' => "$orderBy DESC", 'LIMIT' => 50 )
		);

		$topFanboxes = array();
		foreach( $res as $row ) {
			$topFanboxes[] = array(
				'fantag_id' => $row->fantag_id,
				'fantag_title' => $row->fantag_title,
				'fantag_pg_id' => $row->fantag_pg_id,
				'fantag_left_text' => $row->fantag_left_text,
				'fantag_left_textcolor' => $row->fantag_left_textcolor,
				'fantag_left_bgcolor' => $row->fantag_left_bgcolor,
				'fantag_right_text' => $row->fantag_right_text,
				'fantag_right_textcolor' => $row->fantag_right_textcolor,
				'fantag_right_bgcolor' => $row->fantag_right_bgcolor,
				'fantag_image_name' => $row->fantag_image_name,
				'fantag_left_textsize' => $row->fantag_left_textsize,
				'fantag_right_textsize' => $row->fantag_right_textsize,
				'fantag_count' => $row->fantag_count,
				'fantag_user_id' => $row->fantag_user_id,
				'fantag_user_name' => $row->fantag_user_name,
				'fantag_date' => $row->fantag_date,
			);
		}

		return $topFanboxes;
	}

	function checkIfUserHasFanbox( $userft_fantag_id ) {
		global $wgUser;
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'user_fantag',
			array( 'COUNT(*) AS count' ),
			array(
				'userft_user_name' => $wgUser->getName(),
				'userft_fantag_id' => intval( $userft_fantag_id )
			),
			__METHOD__
		);
		$row = $dbr->fetchObject( $res );
		$check_fanbox_count = 0;
		if( $row ) {
			$check_fanbox_count = $row->count;
		}
		return $check_fanbox_count;
	}

	public function getFanBoxByCategory( $category ) {
		$dbr = wfGetDB( DB_MASTER );

		$res = $dbr->select(
			array( 'fantag', 'categorylinks' ),
			array(
				'fantag_id', 'fantag_title', 'fantag_pg_id',
				'fantag_left_text', 'fantag_left_textcolor',
				'fantag_left_bgcolor', 'fantag_right_text',
				'fantag_right_textcolor', 'fantag_right_bgcolor',
				'fantag_image_name', 'fantag_left_textsize',
				'fantag_right_textsize', 'fantag_count',
				'fantag_user_id', 'fantag_user_name'
			),
			array( 'cl_to' => $category ),
			__METHOD__,
			array( 'ORDER BY' => 'fantag_count DESC' ),
			array( 'categorylinks' => array( 'INNER JOIN', 'cl_from = fantag_pg_id' ) )
		);

		$categoryFanboxes = array();
		foreach( $res as $row ) {
			$categoryFanboxes[] = array(
				'fantag_id' => $row->fantag_id,
				'fantag_title' => $row->fantag_title,
				'fantag_pg_id' => $row->fantag_pg_id,
				'fantag_left_text' => $row->fantag_left_text,
				'fantag_left_textcolor' => $row->fantag_left_textcolor,
				'fantag_left_bgcolor' => $row->fantag_left_bgcolor,
				'fantag_right_text' => $row->fantag_right_text,
				'fantag_right_textcolor' => $row->fantag_right_textcolor,
				'fantag_right_bgcolor' => $row->fantag_right_bgcolor,
				'fantag_image_name' => $row->fantag_image_name,
				'fantag_left_textsize' => $row->fantag_left_textsize,
				'fantag_right_textsize' => $row->fantag_right_textsize,
				'fantag_count' => $row->fantag_count,
				'fantag_user_id' => $row->fantag_user_id,
				'fantag_user_name' => $row->fantag_user_name,
			);
		}

		return $categoryFanboxes;
	}
}