<?php

class ViewUserStatus extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'UserStatus' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser, $wgScriptPath;

		$messages_show = 25;
		$output = '';
		$user_name = $wgRequest->getVal( 'user', $par );
		$page = $wgRequest->getInt( 'page', 1 );

		/**
		 * Redirect Non-logged in users to Login Page
		 * It will automatically return them to their Status page
		 */
		if( $wgUser->getID() == 0 && $user_name == '' ) {
			$wgOut->setPageTitle( wfMsg( 'userstatus-woops' ) );
			$login = SpecialPage::getTitleFor( 'Userlogin' );
			$wgOut->redirect( $login->getFullURL( 'returnto=Special:UserStatus' ) );
			return false;
		}

		/**
		 * If no user is set in the URL, we assume its the current user
		 */
		if( !$user_name ) {
			$user_name = $wgUser->getName();
		}
		$user_id = User::idFromName( $user_name );
		$user = Title::makeTitle( NS_USER, $user_name );

		/**
		 * Error message for username that does not exist (from URL)
		 */
		if( $user_id == 0 ) {
			$wgOut->setPageTitle( wfMsg( 'userstatus-woops' ) );
			$wgOut->addHTML( wfMsg( 'userstatus-no-user' ) );
			return false;
		}

		/**
		 * Config for the page
		 */
		$per_page = $messages_show;

		$stats = new UserStats( $user_id, $user_name );
		$stats_data = $stats->getUserStats();
		$total = $stats_data['user_status_count'];

		$s = new UserStatus();
		$messages = $s->getStatusMessages( $user_id, 0, 0, $messages_show, $page );

		if ( !( $wgUser->getName() == $user_name ) ) {
			$wgOut->setPageTitle( wfMsg( 'userstatus-user-thoughts', $user_name ) );
		} else {
			$wgOut->setPageTitle( wfMsg( 'userstatus-your-thoughts' ) );
		}

		$output .= '<div class="gift-links">';
		if ( !( $wgUser->getName() == $user_name ) ) {
			$output .= "<a href=\"{$user->getFullURL()}\">" .
				wfMsg( 'userstatus-back-user-profile', $user_name ) . '</a>';
		} else {
			$output .= '<a href="' . $wgUser->getUserPage()->getFullURL() . '">' .
				wfMsg( 'userstatus-back-your-profile' ) . '</a>';
		}
		$output .= '</div>';

		if( $page == 1 ) {
			$start = 1;
		} else {
			$start = ( $page - 1 ) * $per_page + 1;
		}

		$end = $start + ( count( $messages ) ) - 1;
		wfDebug( "total = {$total}" );

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
				$output .= '<a href="' . $this->getTitle()->getFullURL( array(
					'user' => $user_name, 'page' => ( $page - 1 ) ) ) . '">' .
					wfMsg( 'userstatus-prev' ) . '</a> ';
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
					$output .= ( $i . ' ' );
				} else {
					$output .= '<a href="' . $this->getTitle()->getFullURL(
						array( 'user' => $user_name, 'page' => $i ) ) .
						"\">$i</a> ";
				}
			}

			if( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . $this->getTitle()->getFullURL( array(
					'user' => $user_name, 'page' => ( $page + 1 ) ) ) . '">' .
					wfMsg( 'userstatus-next' ) . '</a>';
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

		$output .= '<div class="user-status-container">';
		$thought_link = SpecialPage::getTitleFor( 'ViewThought' );
		if( $messages ) {
			foreach ( $messages as $message ) {
				$user = Title::makeTitle( NS_USER, $message['user_name'] );
				$avatar = new wAvatar( $message['user_id'], 'm' );

				$network_link = '<a href="' . SportsTeams::getNetworkURL( $message['sport_id'], $message['team_id'] ) . '">' .
					wfMsg( 'userstatus-all-team-updates', SportsTeams::getNetworkName( $message['sport_id'], $message['team_id'] ) ) .
				'</a>';

				$delete_link = '';
				if( $wgUser->getName() == $message['user_name'] ) {
					$delete_link = "<span class=\"user-board-red\">
						<a href=\"javascript:void(0);\" onclick=\"javascript:delete_message({$message['id']})\">" .
						wfMsg( 'userstatus-delete-thought-text' ) ."</a>
					</span>";
				}

				$message_text = preg_replace_callback(
					'/(<a[^>]*>)(.*?)(<\/a>)/i',
					array( 'UserStatus', 'cutLinkText' ),
					$message['text']
				);
				$vote_count = wfMsgExt( 'userstatus-num-agree', 'parsemag', $message['plus_count'] );

				$vote_link = '';
				if( $wgUser->isLoggedIn() && $wgUser->getName() != $message['user_name'] ) {
					if( !$message['voted'] ) {
						$vote_link = "<a href=\"javascript:void(0);\" onclick=\"vote_status({$message['id']},1)\">[" .
							wfMsg( 'userstatus-_agree' ) . "]</a>";
					} else {
						$vote_link = $vote_count;
					}
				}

				$view_thought_link = '<a href="' . $thought_link->getFullURL( "id={$message['id']}" ) . '">[' .
					wfMsg( 'userstatus-see-who-agrees' ) . ']</a>';

				$output .= '<div class="user-status-row">

					<div class="user-status-logo">

						<a href="' . SportsTeams::getNetworkURL( $message['sport_id'], $message['team_id'] ) . '">' .
							SportsTeams::getLogo( $message['sport_id'], $message['team_id'], 'm' ) .
						"</a>

					</div>

					<div class=\"user-status-message\">

						{$message_text}

						<div class=\"user-status-date\">" . 
							wfMsg( 'userstatus-ago', UserStatus::getTimeAgo( $message['timestamp'] ) ) .
							"<span class=\"user-status-vote\" id=\"user-status-vote-{$message['id']}\">
								{$vote_link}
							</span>
							{$view_thought_link}
							<span class=\"user-status-links\">
								{$delete_link}
							</span>
						</div>

					</div>

					<div class=\"cleared\"></div>

				</div>";
			}
		} else {
			$output .= '<p>' . wfMsg( 'userstatus-no-updates' ) . '</p>';
		}

		$output .= '</div>';

		$wgOut->addHTML( $output );
	}
}