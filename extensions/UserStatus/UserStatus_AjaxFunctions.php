<?php
/**
 * AJAX functions used by the UserStatus extension.
 */
$wgAjaxExportList[] = 'wfAddUserStatusProfile';
function wfAddUserStatusProfile( $sport_id, $team_id, $text, $count ) {
	global $wgUser;

	// Don't do anything if the user is blocked or the DB is read-only
	if ( $wgUser->isBlocked() || wfReadOnly() ) {
		return '';
	}

	$text = urldecode( $text );
	$s = new UserStatus();
	$m = $s->addStatus( $sport_id, $team_id, $text );

	$output = '<div class="status-message">' .
		SportsTeams::getLogo( $sport_id, $team_id, 's' ) .
		$s->formatMessage( $text ) .
	'</div>
	<div class="user-status-profile-vote">
		<div class="user-status-date">' .
			wfMsg( 'userstatus-just-added' ) .
		'</div>
	</div>';

	return $output;
}

$wgAjaxExportList[] = 'wfAddUserStatusNetwork';
function wfAddUserStatusNetwork( $sport_id, $team_id, $text, $count ) {
	global $wgUser;

	// Don't do anything if the user is blocked or the DB is read-only
	if ( $wgUser->isBlocked() || wfReadOnly() ) {
		return '';
	}

	$s = new UserStatus();
	$m = $s->addStatus( $sport_id, $team_id, urldecode( $text ) );

	return $s->displayStatusMessages( 0, $sport_id, $team_id, $count, 1 );
}

$wgAjaxExportList[] = 'wfGetUserStatusProfile';
/**
 * This function appears to be unused...I think it was used in ancient history.
 */
function wfGetUserStatusProfile( $user_id, $num ) {
	global $wgScriptPath;

	$s = new UserStatus();

	$update = $s->getStatusMessages( $user_id, 0, 0, 1, $num );
	$update = $update[0];

	return SportsTeams::getLogo( $update['sport_id'], $update['team_id'], 's' ) .
		"<img src=\"{$wgScriptPath}/extensions/UserStatus/quoteIcon.png\" border=\"0\" style=\"margin-left:5px;\" alt=\"\" />
		{$update['text']}
		<img src=\"{$wgScriptPath}/extensions/UserStatus/endQuoteIcon.png\" border=\"0\" alt=\"\" />
		<span class=\"user-status-date\">" . 
			wfMsg( 'userstatus-ago', UserStatus::getTimeAgo( $update['timestamp'] ) ) .
		'</span>';
}

$wgAjaxExportList[] = 'wfVoteUserStatus';
function wfVoteUserStatus( $us_id, $vote ) {
	global $wgUser;

	// Don't do anything if the user is blocked or the DB is read-only
	if ( $wgUser->isBlocked() || wfReadOnly() ) {
		return '';
	}

	$s = new UserStatus();
	$update = $s->addStatusVote( $us_id, $vote );
	$votes = $s->getStatusVotes( $us_id );

	$output = wfMsgExt( 'userstatus-num-agree', 'parsemag', $votes['plus'] );
	return $output;
}

$wgAjaxExportList[] = 'wfDeleteUserStatus';
function wfDeleteUserStatus( $us_id ) {
	global $wgUser;

	// Don't do anything if the user is blocked or the DB is read-only
	if ( $wgUser->isBlocked() || wfReadOnly() ) {
		return '';
	}

	$s = new UserStatus();
	if(
		$s->doesUserOwnStatusMessage( $wgUser->getID(), $us_id ) ||
		$wgUser->isAllowed( 'delete-status-updates' )
	)
	{
		$s->deleteStatus( $us_id );
	}

	return 'ok';
}

$wgAjaxExportList[] = 'wfUpdateStatus';
function wfUpdateStatus( $user_id, $user_name, $text, $date, $next_row ) {
	$user = User::newFromId( $user_id );

	// Don't do anything if the user is blocked or the DB is read-only
	if ( $user->isBlocked() || wfReadOnly() ) {
		return '';
	}

	// Get a database handler
	$dbw = wfGetDB( DB_MASTER );

	// Write new data to user_status
	$dbw->insert(
		'user_status',
		array(
			'us_user_id' => $user_id,
			'us_user_name' => $user_name,
			'us_text' => $text,
			'us_date' => $date,
		),
		__METHOD__
	);

	// Grab all rows from user_status
	$res = $dbw->select(
		'user_status',
		array(
			'us_user_id', 'us_user_name', 'us_text',
			'UNIX_TIMESTAMP(us_date) AS unix_time'
		),
		array( 'us_id' => intval( $next_row ) ),
		__METHOD__
	);

	$x = 1;

	foreach ( $res as $row ) {
		$db_user_id = $row->us_user_id;
		$db_user_name = $row->us_user_name;
		$db_status_text = $row->us_text;
		$user_status_date = $row->unix_time;
		$avatar = new wAvatar( $db_user_id, 'ml' );
		$userTitle = Title::makeTitle( NS_USER, $db_user_name );

		$output .= "<div class=\"user-status-row\">
			{$avatar->getAvatarURL()}
			<a href=\"{$userTitle->escapeFullURL()}\"><b>{$db_user_name}</b></a> {$db_status_text}
			<span class=\"user-status-date\">" .
				wfMsg( 'userstatus-just-added' ) .
			'</span>
		</div>';

		$x++;
	}

	return $output;
}