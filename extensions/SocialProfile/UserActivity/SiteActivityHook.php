<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point.\n" );
}

$wgHooks['ParserFirstCallInit'][] = 'wfSiteActivity';
/**
 * Register <siteactivity> hook with the Parser
 * @param $parser Object: instance of Parser
 * @return true
 */
function wfSiteActivity( &$parser ) {
	$parser->setHook( 'siteactivity', 'getSiteActivity' );
	return true;
}

function getSiteActivity( $input, $args, $parser ) {
	global $wgMemc, $wgScriptPath;

	$parser->disableCache();

	$limit = ( isset( $args['limit'] ) && is_numeric( $args['limit'] ) ) ? $args['limit'] : 10;

	// so that <siteactivity limit=5 /> will return 5 items instead of 4...
	$fixedLimit = $limit + 1;

	$key = wfMemcKey( 'site_activity', 'all', $fixedLimit );
	$data = $wgMemc->get( $key );
	if ( !$data ) {
		wfDebug( "Got site activity from DB\n" );
		$rel = new UserActivity( '', 'ALL', $fixedLimit );

		$rel->setActivityToggle( 'show_votes', 0 );
		$activity = $rel->getActivityListGrouped();
		$wgMemc->set( $key, $activity, 60 * 2 );
	} else {
		wfDebug( "Got site activity from cache\n" );
		$activity = $data;
	}

	$output = '';
	if ( $activity ) {
		$output .= '<div class="mp-site-activity">
			<h2>' . wfMsg( 'useractivity-siteactivity' ) . '</h2>';

		$x = 1;
		foreach ( $activity as $item ) {
			if ( $x < $fixedLimit ) {
				$typeIcon = UserActivity::getTypeIcon( $item['type'] );
				$output .= '<div class="mp-activity' . ( ( $x == $fixedLimit ) ? ' mp-activity-border-fix' : '' ) . '">
				<img src="' . $wgScriptPath . '/extensions/SocialProfile/images/' . $typeIcon . '" alt="' . $typeIcon . '" border="0" />'
				. $item['data'] .
				'</div>';
				$x++;
			}
		}

		$output .= '</div>';
	}

	return $output;
}
