<?php

$wgHooks['UserProfileBeginLeft'][] = 'wfUserProfileLatestThought';
$wgHooks['UserProfileBeginLeft'][] = 'wfUserProfileFavoriteTeams';

function wfUserProfileFavoriteTeams( $user_profile ) {
	global $wgUser, $wgOut, $wgScriptPath, $wgUploadPath;

	$output = '';
	$user_id = $user_profile->user_id;

	// Add JS
	if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
		$wgOut->addModuleScripts( 'ext.sportsTeams.userProfile' );
	} else {
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/SportsTeams/SportsTeamsUserProfile.js' );
	}

	$add_networks_title = SpecialPage::getTitleFor( 'UpdateFavoriteTeams' );

	$favs = SportsTeams::getUserFavorites( $user_id );

	if ( $favs ) {
		$output .= '<div class="user-section-heading">
			<div class="user-section-title">' .
				wfMsg( 'sportsteams-profile-networks' ) .
			'</div>
			<div class="user-section-actions">
				<div class="action-right">';
		if ( $user_profile->isOwner() ) {
			$output .= '<a href="' . $add_networks_title->escapeFullURL() . '">' .
				wfMsg( 'sportsteams-profile-add-network' ) . '</a>';
		}
		$output .= '</div>
				<div class="cleared"></div>
			</div>
		</div>
		<div class="network-container">';

		foreach( $favs as $fav ) {
			$homepage_title = SpecialPage::getTitleFor( 'FanHome' );

			$status_link = '';
			if ( $wgUser->getId() == $user_id ) {
				$onclick = "SportsTeamsUserProfile.showMessageBox({$fav['order']},{$fav['sport_id']},{$fav['team_id']})";
				$status_link = ' <span class="status-message-add"> - <a href="javascript:void(0);" onclick="' .
					$onclick . '" rel="nofollow">' .
					wfMsg( 'sportsteams-profile-add-thought' ) . '</a></span>';
			}

			$network_update_message = '';

			// Originally the following two lines of code were not present and
			// thus $user_updates was always undefined
			$s = new UserStatus();
			$user_updates = $s->getStatusMessages(
				$user_id, $fav['sport_id'], $fav['team_id'], 1, 1
			);

			// Added empty() check
			if ( !empty( $user_updates[$fav['sport_id'] . '-' . $fav['team_id']] ) ) {
				$network_update_message = $user_updates[$fav['sport_id'] . '-' . $fav['team_id']];
			}

			if ( $fav['team_name'] ) {
				$display_name = $fav['team_name'];
				$logo = "<img src=\"{$wgUploadPath}/team_logos/" .
					SportsTeams::getTeamLogo( $fav['team_id'], 's' ) .
					'" border="0" alt="" />';
			} else {
				$display_name = $fav['sport_name'];
				$logo = "<img src=\"{$wgUploadPath}/sport_logos/" .
					SportsTeams::getSportLogo( $fav['sport_id'], 's' ) .
					'" border="0" alt="" />';
			}

			$output .= "<div class=\"network\">
				{$logo}
				<a href=\"" . $homepage_title->escapeFullURL(
					'sport_id=' . $fav['sport_id'] . '&team_id=' . $fav['team_id']
				) . "\" rel=\"nofollow\">{$display_name}</a>
				{$status_link}
			</div>

			<div class=\"status-update-box\" id=\"status-update-box-{$fav['order']}\" style=\"display:none\"></div>";
		}

		$output .= '<div class="cleared"></div>
		</div>';
	} elseif ( $user_profile->isOwner() ) {
		$output .= '<div class="user-section-heading">
			<div class="user-section-title">' .
				wfMsg( 'sportsteams-profile-networks' ) .
			'</div>
			<div class="user-section-actions">
				<div class="action-right">
					<a href="' . $add_networks_title->escapeFullURL() . '">' .
						wfMsg( 'sportsteams-profile-add-network' ) . '</a>
				</div>
				<div class="cleared"></div>
			</div>
		</div>
		<div class="no-info-container">' .
			wfMsg( 'sportsteams-profile-no-networks' ) .
		'</div>';
	}

	$wgOut->addHTML( $output );
	return true;
}

function wfUserProfileLatestThought( $user_profile ) {
	global $wgUser, $wgOut;

	$user_id = $user_profile->user_id;
	$s = new UserStatus();
	$user_update = $s->getStatusMessages( $user_id, 0, 0, 1, 1 );
	$user_update = ( !empty( $user_update[0] ) ? $user_update[0] : array() );

	// Safe URLs
	$more_thoughts_link = SpecialPage::getTitleFor( 'UserStatus' );
	$thought_link = SpecialPage::getTitleFor( 'ViewThought' );

	$output = '';
	if ( $user_update ) {
		$output .= '<div class="user-section-heading">
			<div class="user-section-title">' .
				wfMsg( 'sportsteams-profile-latest-thought' ) .
			'</div>
			<div class="user-section-actions">
				<div class="action-right">
					<a href="' . $more_thoughts_link->escapeFullURL( 'user=' . $user_profile->user_name ) .
					'" rel="nofollow">' . wfMsg( 'sportsteams-profile-view-all' ) . '</a>
				</div>
				<div class="cleared"></div>
			</div>
		</div>';

		$vote_count = $vote_link = '';
		// If someone agrees with the most recent status update, show the count
		// next to the timestamp to the owner of the status update
		// After all, there's no point in showing "0 people agree with this"...
		if(
			$wgUser->getName() == $user_update['user_name'] &&
			$user_update['plus_count'] > 0
		)
		{
			$vote_count = wfMsgExt(
				'sportsteams-profile-num-agree',
				'parsemag',
				$user_update['plus_count']
			);
		}

		$view_thought_link = '<a href="' . $thought_link->escapeFullURL( "id={$user_update['id']}" ) .
			"\" rel=\"nofollow\">{$vote_count}</a>";

		// Allow registered users who are not owners of this status update to
		// vote for it unless they've already voted; if they have voted, show
		// the amount of people who agree with the status update
		if( $wgUser->isLoggedIn() && $wgUser->getName() != $user_update['user_name'] ) {
			if( !$user_update['voted'] ) {
				$vote_link = "<a href=\"javascript:void(0);\" onclick=\"SportsTeamsUserProfile.voteStatus({$user_update['id']},1)\" rel=\"nofollow\">" .
					wfMsg( 'sportsteams-profile-do-you-agree' ) . '</a>';
			} else {
				$vote_count = wfMsgExt(
					'sportsteams-profile-num-agree',
					'parsemag',
					$user_update['plus_count']
				);
			}
		}

		$output .= '<div class="status-container" id="status-update">
			<div id="status-update" class="status-message">' .
				SportsTeams::getLogo( $user_update['sport_id'], $user_update['team_id'], 's' ) .
				"{$user_update['text']}
			</div>
			<div class=\"user-status-profile-vote\">
				<span class=\"user-status-date\">" .
					wfMsg( 'sportsteams-profile-ago', SportsTeams::getTimeAgo( $user_update['timestamp'] ) ) .
				"</span>
				{$vote_link} {$view_thought_link}
			</div>
		</div>";
	} else {
		$output .= "<script type=\"text/javascript\">var __thoughts_text__ = \"" .
			wfMsg( 'sportsteams-profile-latest-thought' ) . '";
		var __view_all__ = "' . wfMsg( 'sportsteams-profile-view-all' ) . '";
		var __more_thoughts_url__ = "' . $more_thoughts_link->escapeFullURL( 'user=' . $user_profile->user_name ) .
		'";</script>';
	}

	$wgOut->addHTML( $output );
	return true;
}