<?php
/**
 * RandomFeaturedUser extension - adds <randomfeatureduser> parser hook
 * to display a randomly chosen 'featured' user and some info regarding the
 * user, such as their avatar.
 *
 * Meant to be used with the SocialProfile extension, fails without.
 * Make sure to set either $wgUserStatsTrackWeekly or $wgUserStatsTrackMonthly
 * to true in your wiki's LocalSettings.php and before doing so, be sure that
 * you have created the three necessary tables in the database:
 * user_points_archive, user_points_monthly and user_points_weekly.
 * Then add <randomfeatureduser/> tag to whichever page you want to.
 *
 * @file
 * @ingroup Extensions
 * @version 1.1
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @link http://www.mediawiki.org/wiki/Extension:RandomFeaturedUser Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

// What to display on the output of <randomfeatureduser> tag...
$wgRandomFeaturedUser['avatar'] = true;
$wgRandomFeaturedUser['points'] = true;
$wgRandomFeaturedUser['about'] = true;

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'RandomFeaturedUser',
	'version' => '1.1',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'description' => 'Adds <tt>&lt;randomfeatureduser&gt;</tt> parser hook to display a random featured user along with some data',
	'url' => 'https://www.mediawiki.org/wiki/Extension:RandomFeaturedUser',
);

// Internationalization messages
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['RandomFeaturedUser'] = $dir . 'RandomFeaturedUser.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'wfRandomFeaturedUser';
/**
 * Set up the <randomfeatureduser> tag
 * @param $parser Object: instance of Parser (not necessarily $wgParser)
 * @return Boolean: true
 */
function wfRandomFeaturedUser( &$parser ) {
	$parser->setHook( 'randomfeatureduser', 'getRandomUser' );
	return true;
}

function getRandomUser( $input, $args, $parser ) {
	global $wgMemc, $wgRandomFeaturedUser;

	wfProfileIn( __METHOD__ );

	$parser->disableCache();

	$period = ( isset( $args['period'] ) ) ? $args['period'] : '';
	if( $period != 'weekly' && $period != 'monthly' ) {
		return '';
	}

	$user_list = array();
	$count = 20;
	$realCount = 10;

	// Try cache
	$key = wfMemcKey( 'user_stats', 'top', 'points', 'weekly', $realCount );
	$data = $wgMemc->get( $key );

	if( $data != '' ) {
		wfDebug( "Got top $period users by points ({$count}) from cache\n" );
		$user_list = $data;
	} else {
		wfDebug( "Got top $period users by points ({$count}) from DB\n" );

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'user_points_' . $period,
			array( 'up_user_id', 'up_user_name', 'up_points' ),
			array( 'up_user_id <> 0' ),
			__METHOD__,
			array(
				'ORDER BY' => 'up_points DESC',
				'LIMIT' => $count
			)
		);
		$loop = 0;
		foreach( $res as $row ) {
			// Prevent blocked users from appearing
			$user = User::newFromId( $row->up_user_id );
			if( !$user->isBlocked() ) {
				$user_list[] = array(
					'user_id' => $row->up_user_id,
					'user_name' => $row->up_user_name,
					'points' => $row->up_points
				);
				$loop++;
			}
			if( $loop >= 10 ) {
				break;
			}
		}

		if( count( $user_list ) > 0 ) {
			$wgMemc->set( $key, $user_list, 60 * 60 );
		}
	}

	// Make sure we have some data
	if( !is_array( $user_list ) || count( $user_list ) == 0 ) {
		return '';
	}

	$random_user = $user_list[array_rand( $user_list, 1 )];

	// Make sure we have a user
	if( !$random_user['user_id'] ) {
		return '';
	}

	$output = '<div class="random-featured-user">';

	if( $wgRandomFeaturedUser['points'] == true ) {
		$stats = new UserStats( $random_user['user_id'], $random_user['user_name'] );
		$stats_data = $stats->getUserStats();
		$points = $stats_data['points'];
	}

	if( $wgRandomFeaturedUser['avatar'] == true ) {
		$user_title = Title::makeTitle( NS_USER, $random_user['user_name'] );
		$avatar = new wAvatar( $random_user['user_id'], 'ml' );
		$avatarImage = $avatar->getAvatarURL();

		$output .= "<a href=\"{$user_title->escapeFullURL()}\">{$avatarImage}</a>\n";
	}

	$output .= "<div class=\"random-featured-user-title\">
					<a href=\"{$user_title->escapeFullURL()}\">" .
					wordwrap( $random_user['user_name'], 12, "<br />\n", true ) .
					"</a><br /> $points " .
				wfMsg( "random-user-points-{$period}" ) .
			"</div>\n\n";

	if( $wgRandomFeaturedUser['about'] == true ) {
		$p = new Parser();
		$profile = new UserProfile( $random_user['user_name'] );
		$profile_data = $profile->getProfile();
		$about = ( isset( $profile_data['about'] ) ) ? $profile_data['about'] : '';
		// Remove templates
		$about = preg_replace( '@{{.*?}}@si', '', $about );
		if( !empty( $about ) ) {
			global $wgTitle, $wgOut;
			$output .= '<div class="random-featured-user-about-title">' .
				wfMsg( 'random-user-about-me' ) . '</div>' .
				$p->parse( $about, $wgTitle, $wgOut->parserOptions(), false )->getText();
		}
	}

	$output .= '</div><div class="cleared"></div>';

	wfProfileOut( __METHOD__ );

	return $output;
}