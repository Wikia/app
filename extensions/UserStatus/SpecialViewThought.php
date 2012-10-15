<?php
/**
 * A special page for viewing an individual status update.
 *
 * @file
 * @ingroup Extensions
 */
class ViewThought extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'ViewThought' );
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
		$us_id = $wgRequest->getInt( 'id', $par );
		$page = $wgRequest->getInt( 'page', 1 );

		// No ID? Show an error message then.
		if( !$us_id || !is_numeric( $us_id ) ) {
			$wgOut->addHTML( wfMsg( 'userstatus-invalid-link' ) );
			return false;
		}

		/**
		 * Config for the page
		 */
		$per_page = $messages_show;

		$s = new UserStatus();
		$message = $s->getStatusMessage( $us_id );
		$user_name = $message['user_name'];
		$user = Title::makeTitle( NS_USER, $user_name );

		// Different page title, depending on whose status updates we're
		// viewing
		if ( !( $wgUser->getName() == $user_name ) ) {
			$wgOut->setPageTitle( wfMsg( 'userstatus-user-thoughts', $user_name ) );
		} else {
			$wgOut->setPageTitle( wfMsg( 'userstatus-your-thoughts' ) );
		}

		// Add CSS
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModuleStyles( 'ext.userStatus.viewThought' );
		} else {
			$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/UserStatus/ViewThought.css' );
		}

		$output .= "<div class=\"view-thought-links\">
			<a href=\"{$user->getFullURL()}\">" .
				wfMsg( 'userstatus-user-profile', $user_name ) .
			'</a>
		</div>';
		$output .= '<div class="user-status-container">';
		$output .= '<div class="user-status-row">

				<div class="user-status-logo">

					<a href="' . SportsTeams::getNetworkURL( $message['sport_id'], $message['team_id'] ) . '">' .
						SportsTeams::getLogo( $message['sport_id'], $message['team_id'], 'm' ) .
					"</a>

				</div>

				<div class=\"user-status-message\">

					{$message['text']}

					<div class=\"user-status-date\">" .
						wfMsg( 'userstatus-ago', UserStatus::getTimeAgo( $message['timestamp'] ) ) .
					'</div>

				</div>

				<div class="cleared"></div>

		</div>
		</div>';

		$output .= '<div class="who-agrees">';
		$output .= '<h1>' . wfMsg( 'userstatus-who-agrees' ) . '</h1>';
		$voters = $s->getStatusVoters( $us_id );
		// Get the people who agree with this status update, if any
		if( $voters ) {
			foreach ( $voters as $voter ) {
				$user = Title::makeTitle( NS_USER, $voter['user_name'] );
				$avatar = new wAvatar( $voter['user_id'], 'm' );

				$output .= "<div class=\"who-agrees-row\">
					<a href=\"{$user->getFullURL()}\">{$avatar->getAvatarURL()}</a>
					<a href=\"{$user->getFullURL()}\">{$voter['user_name']}</a>
				</div>";
			}
		} else {
			$output .= '<p>' . wfMsg( 'userstatus-nobody-agrees' ) . '</p>';
		}

		$output .= '</div>';

		$wgOut->addHTML( $output );
	}

}