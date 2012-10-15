<?php
/**
 * A parser hook that allows showing up to 50 weekly or monthly top users.
 *
 * Usage: <topusers limit=15 period=monthly />
 *
 * @file
 * @ingroup Extensions
 * @date 5 August 2011
 * @author Jack Phoenix <jack@countervandalism.net>
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

$wgHooks['ParserFirstCallInit'][] = 'wfRegisterTopUsersTag';

/**
 * Register the new <topusers /> parser hook with the Parser.
 *
 * @param $parser Parser: instance of Parser (not necessarily $wgParser)
 * @return Boolean: true
 */
function wfRegisterTopUsersTag( &$parser ) {
	$parser->setHook( 'topusers', 'getTopUsersForTag' );
	return true;
}

/**
 * Get the given amount of top users for the given timeframe.
 *
 * @return String: HTML
 */
function getTopUsersForTag( $input, $args, $parser ) {
	global $wgLang;

	// Don't allow showing OVER 9000...I mean, over 50 users, duh.
	// Performance and all that stuff.
	if (
		!empty( $args['limit'] ) &&
		is_numeric( $args['limit'] ) &&
		$args['limit'] < 50
	)
	{
		$limit = intval( $args['limit'] );
	} else {
		$limit = 5;
	}

	if ( !empty( $args['period'] ) && strtolower( $args['period'] ) == 'monthly' ) {
		$period = 'monthly';
	} else {
		// "period" argument not supplied/it's not "monthly", so assume weekly
		$period = 'weekly';
	}

	$fans = UserStats::getTopFansListPeriod( $limit, $period );
	$x = 1;
	$topfans = '';

	foreach( $fans as $fan ) {
		$avatar = new wAvatar( $fan['user_id'], 'm' );
		$user = Title::makeTitle( NS_USER, $fan['user_name'] );

		$topfans .= "<div class=\"top-fan\">
				<span class=\"top-fan-number\">{$x}.</span>
				<a href=\"{$user->getFullURL()}\">{$avatar->getAvatarURL()}</a>
				<span class=\"top-fans-user\"><a href=\"{$user->getFullURL()}\">{$fan['user_name']}</a></span>
				<span class=\"top-fans-points\"><b>+" . $wgLang->formatNum( $fan['points'] ) . '</b> ' .
				wfMsg( 'top-fans-points' ) . '</span>
			</div>';
		$x++;
	}

	return $topfans;
}