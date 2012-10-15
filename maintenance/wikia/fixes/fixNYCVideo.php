<?php

include( '../../commandLine.inc' );

$dbr = wfGetDB( DB_SLAVE );

$dbw = wfGetDB( DB_MASTER );

$res = $dbr->select( 'video', '*', array( 'video_type' => 'youtube' ) );

while ( $row = $dbr->fetchObject( $res ) ) {
	$urlRaw = explode( '&', $row->video_url );
	$urlClean = $urlRaw[0];

	if ( strpos( $urlClean, '/v/' ) ) {
		// TYPE 1
		$videoID = preg_replace( '|http://.*youtube\.com/v/|', '', $urlClean );
	} elseif ( preg_match( '|http://.*youtube\.com/watch\?v=|', $urlClean ) ) {
		$videoID = preg_replace( '|http://.*youtube\.com/watch\?v=|', '', $urlClean );
	}

	if ( empty( $videoID ) ) {
		echo 'ARGH! ' . $row->video_name . "\n";
		continue;
	}

	$input['img_name'] = ':' . $row->video_name;
	$input['img_size'] = 300;
	$input['img_description'] = '';
	$input['img_user'] = $row->video_user_id;
	$input['img_user_text'] = $row->video_user_name;
	$input['img_timestamp'] = $row->video_timestamp;
	$input['img_width'] = 0;
	$input['img_height'] = 0;
	$input['img_bits'] = 0;
	$input['img_metadata'] = '5,' . $videoID . ',';
	$input['img_media_type'] = 'VIDEO';
	$input['img_major_mime'] = 'video';
	$input['img_minor_mime'] = 'swf';
	$input['img_sha1'] = '';

	wfWaitForSlaves( 5 );
	$dbw->insert( 'image', $input, 'fixNYCVideo', 'IGNORE' );

	echo "Inserted video: " . $input['img_name'] . "\n";
}
