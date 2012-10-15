<?php
/**
 * A special page to show all status updates from the various users ("fans") of
 * a given network.
 * This special page also allows a user to post an update to a network page
 * without being a member of the network in question.
 *
 * @file
 * @ingroup Extensions
 */
class ViewFanUpdates extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'FanUpdates' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser, $wgScriptPath;

		$messages_show = 25;
		$updates_show = 25; // just an arbitrary value to stop PHP from complaining on 12 August 2011 --ashley
		$output = '';
		$sport_id = $wgRequest->getInt( 'sport_id' );
		$team_id = $wgRequest->getInt( 'team_id' );
		$page = $wgRequest->getInt( 'page', 1 );

		if ( $team_id ) {
			$team = SportsTeams::getTeam( $team_id );
			$network_name = $team['name'];
		} elseif ( $sport_id ) {
			$sport = SportsTeams::getSport( $sport_id );
			$network_name = $sport['name'];
		} else {
			// No sports ID nor team ID...bail out or we'll get a database
			// error...
			$wgOut->setPageTitle( wfMsg( 'userstatus-woops' ) );
			$out = '<div class="relationship-request-message">' .
				wfMsg( 'userstatus-invalid-link' ) . '</div>';
			$out .= '<div class="relationship-request-buttons">';
			$out .= '<input type="button" class="site-button" value="' .
				wfMsg( 'mainpage' ) .
				"\" onclick=\"window.location='" .
				Title::newMainPage()->escapeFullURL() . "'\"/>";
			/* removed because I was too lazy to port the error message over :P
			if ( $wgUser->isLoggedIn() ) {
				$out .= ' <input type="button" class="site-button" value="' .
					wfMsg( 'st_network_your_profile' ) .
					"\" onclick=\"window.location='" .
					Title::makeTitle( NS_USER, $wgUser->getName() )->escapeFullURL() . "'\"/>";
			}
			*/
			$out .= '</div>';
			$wgOut->addHTML( $out );
			return true;
		}

		$wgOut->setPageTitle( wfMsg( 'userstatus-network-thoughts', $network_name ) );

		/**
		 * Config for the page
		 */
		$per_page = $messages_show;

		$s = new UserStatus();
		$total = $s->getNetworkUpdatesCount( $sport_id, $team_id );
		$messages = $s->getStatusMessages(
			0,
			$sport_id,
			$team_id,
			$messages_show,
			$page
		);

		$output .= '<div class="gift-links">';
		$output .= '<a href="' .
			SportsTeams::getNetworkURL( $sport_id, $team_id ) . '">' .
				wfMsg( 'userstatus-back-to-network' ) . '</a>';
		$output .= '</div>';

		if( $page == 1 ) {
			$start = 1;
		} else {
			$start = ( $page - 1 ) * $per_page + 1;
		}
		$end = $start + ( count( $messages ) ) - 1;

		if( $total ) {
			$output .= '<div class="user-page-message-top">
			<span class="user-page-message-count" style="font-size: 11px; color: #666666;">' .
				wfMsgExt( 'userstatus-showing-thoughts', 'parsemag', $start, $end, $total ) .
			'</span>
		</div>';
		}

		/**
		 * Build next/prev navigation
		 */
		$numofpages = $total / $per_page;

		if( $numofpages > 1 ) {
			$output .= '<div class="page-nav">';
			if( $page > 1 ) {
				$output .= '<a href="' .
					SportsTeams::getFanUpdatesURL( $sport_id, $team_id ) .
					'&page=' . ( $page - 1 ) . '">' . wfMsg( 'userstatus-prev' ) .
					'</a> ';
			}

			if( ( $total % $per_page ) != 0 ) {
				$numofpages++;
			}
			if( $numofpages >= 9 && $page < $total ) {
				$numofpages = 9 + $page;
				if( $numofpages >= ( $total / $per_page ) ) {
					$numofpages = ( $total / $per_page ) + 1;
				}
			}

			for( $i = 1; $i <= $numofpages; $i++ ) {
				if( $i == $page ) {
					$output .= ( $i . ' ');
				} else {
					$output .= '<a href="' .
						SportsTeams::getFanUpdatesURL( $sport_id, $team_id ) .
						"&page=$i\">$i</a> ";
				}
			}

			if( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' .
					SportsTeams::getFanUpdatesURL( $sport_id, $team_id ) .
					'&page=' . ( $page + 1 ) . '">' . wfMsg( 'userstatus-next' ) .
					'</a>';
			}
			$output .= '</div><p>';
		}

		// Add CSS & JS
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModuleStyles( 'ext.userStatus' );
			$wgOut->addModuleScripts( 'ext.userStatus' );
		} else {
			$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/UserStatus/UserStatus.css' );
			$wgOut->addScriptFile( $wgScriptPath . '/extensions/UserStatus/UserStatus.js' );
		}

		// Registered users who are not blocked can add status updates when the
		// database is not locked
		if( $wgUser->isLoggedIn() && !$wgUser->isBlocked() && !wfReadOnly() ) {
			$output .= "<script>
				var __sport_id__ = {$sport_id};
				var __team_id__ = {$team_id};
				var __updates_show__ = \"{$updates_show}\";
				var __redirect_url__ = \"" . str_replace( '&amp;', '&', SportsTeams::getFanUpdatesURL( $sport_id, $team_id ) ) . "\";
			</script>";

			$output .= "<div class=\"user-status-form\">
			<span class=\"user-name-top\">{$wgUser->getName()}</span> <input type=\"text\" name=\"user_status_text\" id=\"user_status_text\" size=\"40\"/>
			<input type=\"button\" value=\"" . wfMsg( 'userstatus-btn-add' ) . '" class="site-button" onclick="add_status()" />
			</div>';
		}

		$output .= '<div class="user-status-container">';
		if( $messages ) {
			foreach ( $messages as $message ) {
				$user = Title::makeTitle( NS_USER, $message['user_name'] );
				$avatar = new wAvatar( $message['user_id'], 'm' );

				$messages_link = '<a href="' .
					UserStatus::getUserUpdatesURL( $message['user_name'] ) . '">' .
					wfMsg( 'userstatus-view-all-updates', $message['user_name'] ) .
					'</a>';
				$delete_link = '';
				// Allow the owner of the status update and privileged users to
				// delete it
				if(
					$wgUser->getName() == $message['user_name'] ||
					$wgUser->isAllowed( 'delete-status-updates' )
				)
				{
					$delete_link = "<span class=\"user-board-red\">
							<a href=\"javascript:void(0);\" onclick=\"javascript:delete_message({$message['id']})\">" .
						wfMsg( 'userstatus-delete' ) . '</a>
					</span>';
				}

				$message_text = preg_replace_callback(
					'/(<a[^>]*>)(.*?)(<\/a>)/i',
					array( 'UserStatus', 'cutLinkText' ),
					$message['text']
				);

				$output .= "<div class=\"user-status-row\">
					<a href=\"{$user->getFullURL()}\">{$avatar->getAvatarURL()}</a>
					<a href=\"{$user->getFullURL()}\"><b>{$message['user_name']}</b></a> {$message_text}
					<span class=\"user-status-date\">" .
						wfMsg( 'userstatus-ago', UserStatus::getTimeAgo( $message['timestamp'] ) ) .
					'</span>
				</div>';
			}
		} else {
			$output .= '<p>' . wfMsg( 'userstatus-no-updates' ) . '</p>';
		}

		$output .= '</div>';

		$wgOut->addHTML( $output );
	}

}