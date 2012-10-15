<?php
/**
 * <userboxes> parser hook extension -- allows displaying your own userboxes in
 * a wiki page
 *
 * @file
 * @ingroup Extensions
 */
if( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point.\n" );
}

$wgHooks['ParserFirstCallInit'][] = 'wfUserBoxesHook';

/**
 * Register the <userboxes> tag with the Parser.
 *
 * @param $parser Object: instance of Parser (not necessarily $wgParser)
 * @return Boolean: true
 */
function wfUserBoxesHook( &$parser ) {
	$parser->setHook( 'userboxes', 'UserBoxesHook' );
	return true;
}

function UserBoxesHook( $input, $args, $parser ) {
	global $wgOut, $wgUser, $wgTitle, $wgMemc, $wgFanBoxScripts;

	$parser->disableCache();

	$wgOut->addScriptFile( $wgFanBoxScripts . '/FanBoxes.js' );
	$wgOut->addExtensionStyle( $wgFanBoxScripts . '/FanBoxes.css' );

	$user_name = ( isset( $args['user'] ) ? $args['user'] : $wgUser->getName() );

	$limit = 10;
	if ( isset( $args['limit'] ) && is_numeric( $args['limit'] ) ) {
		$limit = intval( $args['limit'] );
	}

	$f = new UserFanBoxes( $user_name );

	// Try cache
	//$key = wfMemcKey( 'user', 'profile', 'fanboxes', $f->user_id );
	//$data = $wgMemc->get( $key );

	//if( !$data ) {
	//	wfDebug( "Got profile fanboxes for user {$user_name} from DB\n" );
	//	$fanboxes = $f->getUserFanboxes( 0, $limit );
	//	$wgMemc->set( $key, $fanboxes );
	//} else {
	//	wfDebug( "Got profile fanboxes for user {$user_name} from cache\n" );
	//	$fanboxes = $data;
	//}

	$fanboxes = $f->getUserFanboxes( 0, $limit );

	$fanbox_count = $f->getFanBoxCountByUsername( $user_name );
	$fanbox_link = SpecialPage::getTitleFor( 'ViewUserBoxes' );
	$per_row = 1;
	$output = '';

	if( $fanboxes ) {
		$output .= '<div class="clearfix"><div class="user-fanbox-container">';

		$x = 1;
		$tagParser = new Parser();

		foreach( $fanboxes as $fanbox ) {
			$check_user_fanbox = $f->checkIfUserHasFanbox( $fanbox['fantag_id'] );

			if( $fanbox['fantag_image_name'] ) {
				$fantag_image_width = 45;
				$fantag_image_height = 53;
				$fantag_image = wfFindFile( $fanbox['fantag_image_name'] );
				$fantag_image_url = '';
				if ( is_object( $fantag_image ) ) {
					$fantag_image_url = $fantag_image->createThumb(
						$fantag_image_width,
						$fantag_image_height
					);
				}
				$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '" />';
			}

			if( $fanbox['fantag_left_text'] == '' ) {
				$fantag_leftside = $fantag_image_tag;
			} else {
				$fantag_leftside = $fanbox['fantag_left_text'];
				$fantag_leftside = $tagParser->parse(
					$fantag_leftside,
					$wgTitle,
					$wgOut->parserOptions(),
					false
				);
				$fantag_leftside = $fantag_leftside->getText();
			}

			$leftfontsize = '10px';
			if( $fanbox['fantag_left_textsize'] == 'mediumfont' ) {
				$leftfontsize = '11px';
			}
			if( $fanbox['fantag_left_textsize'] == 'bigfont' ) {
				$leftfontsize = '15px';
			}
			$rightfontsize = '10px';
			if( $fanbox['fantag_right_textsize'] == 'smallfont' ) {
				$rightfontsize = '10px';
			}
			if( $fanbox['fantag_right_textsize'] == 'mediumfont' ) {
				$rightfontsize = '11px';
			}

			// Get permalink
			$fantag_title = Title::makeTitle( NS_FANTAG, $fanbox['fantag_title'] );

			$right_text = $fanbox['fantag_right_text'];
			$right_text = $tagParser->parse(
				$right_text,
				$wgTitle,
				$wgOut->parserOptions(),
				false
			);
			$right_text = $right_text->getText();

			// Output fanboxes
			$output .= "<span class=\"top-fanbox\"><div class=\"fanbox-item\">
			<div class=\"individual-fanbox\" id=\"individualFanbox" . $fanbox['fantag_id'] . "\">
				<div class=\"show-message-container-profile\" id=\"show-message-container" . $fanbox['fantag_id'] . "\">
					<div class=\"relativeposition\">
					<a class=\"perma\" style=\"font-size:8px; color:" . $fanbox['fantag_right_textcolor'] . "\" href=\"" . $fantag_title->escapeFullURL() . "\" title=\"{$fanbox['fantag_title']}\">" . wfMsg( 'fanbox-perma' ) . "</a>
					<table class=\"fanBoxTableProfile\" onclick=\"javascript:FanBoxes.openFanBoxPopup('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
						<tr>
							<td id=\"fanBoxLeftSideOutputProfile\" style=\"color:" . $fanbox['fantag_left_textcolor'] . "; font-size:$leftfontsize\" bgcolor=\"" . $fanbox['fantag_left_bgcolor'] . "\">" . $fantag_leftside . "</td>
							<td id=\"fanBoxRightSideOutputProfile\" style=\"color:" . $fanbox['fantag_right_textcolor'] . "; font-size:$rightfontsize\" bgcolor=\"" . $fanbox['fantag_right_bgcolor'] . "\">" . $right_text . "</td>
						</tr>
					</table>
					</div>
				</div>
				</div>";

			if( $wgUser->isLoggedIn() ) {
				if( $check_user_fanbox == 0 ) {
					$output .= "
					<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox" . $fanbox['fantag_id'] . "\">
					<table cellpadding=\"0\" cellspacing=\"0\">
						<tr>
							<td style=\"font-size:10px\" align=\"center\">" . wfMsg( 'fanbox-add-fanbox' ) . "</td>
						</tr>
						<tr>
							<td align=\"center\">
								<input type=\"button\" value=\"" . wfMsg( 'fanbox-add' ) . "\" size=\"10\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}'); FanBoxes.showAddRemoveMessageUserPage(1, {$fanbox['fantag_id']}, 'show-addremove-message-half')\" />
								<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"10\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}')\" />
							</td>
						</tr>
					</table>
					</div>";
				} else {
					$output .= "
					<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox" . $fanbox['fantag_id'] . "\">
					<table cellpadding=\"0\" cellspacing=\"0\">
						<tr>
							<td style=\"font-size:10px\" align=\"center\">" . wfMsg( 'fanbox-remove-fanbox' ) . "</td>
						</tr>
						<tr>
							<td align=\"center\">
								<input type=\"button\" value=\"" . wfMsg( 'fanbox-remove' ) . "\" size=\"10\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}'); FanBoxes.showAddRemoveMessageUserPage(2, {$fanbox['fantag_id']}, 'show-addremove-message-half')\" />
								<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"10\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}')\" />
							</td>
						</tr>
					</table>
					</div>";
				}
			}

			if( $wgUser->getID() == 0 ) {
				$login = SpecialPage::getTitleFor( 'Userlogin' );
				$output .= '<div class="fanbox-pop-up-box-profile" id="fanboxPopUpBox' . $fanbox['fantag_id'] . '">
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td style="font-size: 10px" align="center">' .
								wfMsg( 'fanbox-add-fanbox-login' ) .
								"<a href=\"{$login->getFullURL()}\">" .
								wfMsg( 'fanbox-login' ) . '</a>
							</td>
							<tr>
								<td align="center">
									<input type="button" value="' . wfMsg( 'cancel' ) . "\" size=\"10\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}')\" />
								</td>
							</tr>
						</table>
					</div>";
			}

			$output .= '</div></span><div class="cleared"></div>';
			//if( $x == count( $fanboxes ) || $x != 1 && $x % $per_row == 0 ) $output .= '<div class="cleared"></div>';
			$x++;
		}

		$output .= '</div></div>';
	}

	return $output;
}