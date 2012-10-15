<?php
/**
 * NewUsersList parser hook extension -- adds <newusers> parser tag to retrieve
 * the list of new users and their avatars.
 * Requires SocialProfile extension in order to work correctly.
 * Works with NewSignupPage extension, i.e. if the user_register_track DB table
 * is present, this extension queries that table, but if it's not, then the
 * core logging table is used instead.
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @link http://www.mediawiki.org/wiki/Extension:NewUsersList Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'NewUsersList',
	'version' => '1.0',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'descriptionmsg' => 'newuserslist-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:NewUsersList'
);

$wgHooks['ParserFirstCallInit'][] = 'wfGetNewUsers';

/**
 * Register the <newusers> tag with MediaWiki's Parser.
 *
 * @param $parser Object: instance of Parser (not necessarily $wgParser)
 * @return Boolean: true
 */
function wfGetNewUsers( &$parser ) {
	$parser->setHook( 'newusers', 'getNewUsers' );
	return true;
}

/**
 * Callback function for the <newusers> tag.
 * Queries the user_register_track database table for new users and renders
 * the list of newest users and their avatars, wrapped in a div with the class
 * "new-users".
 * Disables parser cache and caches the database query results in memcached.
 */
function getNewUsers( $input, $args, $parser ) {
	global $wgMemc;

	$parser->disableCache();

	$count = 10;
	$per_row = 5;

	if ( isset( $args['count'] ) && is_numeric( $args['count'] ) ) {
		$count = intval( $args['count'] );
	}

	if ( isset( $args['row'] ) && is_numeric( $args['row'] ) ) {
		$per_row = intval( $args['row'] );
	}

	// Try cache
	$key = wfMemcKey( 'users', 'new', $count );
	$data = $wgMemc->get( $key );

	if( !$data ) {
		$dbr = wfGetDB( DB_SLAVE );

		if ( $dbr->tableExists( 'user_register_track' ) ) {
			$res = $dbr->select(
				'user_register_track',
				array( 'ur_user_id', 'ur_user_name' ),
				array(),
				__METHOD__,
				array( 'ORDER BY' => 'ur_date', 'LIMIT' => $count )
			);
		} else {
			// If user_register_track table doesn't exist, use the core logging
			// table
			$res = $dbr->select(
				'logging',
				array(
					'log_user AS ur_user_id',
					'log_user_text AS ur_user_name'
				),
				array( 'log_type' => 'newusers' ),
				__METHOD__,
				// DESC to get the *newest* $count users instead of the oldest
				array( 'ORDER BY' => 'log_timestamp DESC', 'LIMIT' => $count )
			);
		}

		$list = array();
		foreach( $res as $row ) {
			$list[] = array(
				'user_id' => $row->ur_user_id,
				'user_name' => $row->ur_user_name
			);
		}

		// Cache in memcached for 10 minutes
		$wgMemc->set( $key, $list, 60 * 10 );
	} else {
		wfDebugLog( 'NewUsersList', 'Got new users from cache' );
		$list = $data;
	}

	$output = '<div class="new-users">';

	if ( !empty( $list ) ) {
		$x = 1;
		foreach( $list as $user ) {
			$avatar = new wAvatar( $user['user_id'], 'ml' );
			$userLink = Title::makeTitle( NS_USER, $user['user_name'] );

			$output .= '<a href="' . $userLink->escapeFullURL() .
				'" rel="nofollow">' . $avatar->getAvatarURL() . '</a>';

			if ( ( $x == $count ) || ( $x != 1 ) && ( $x % $per_row == 0 ) ) {
				$output .= '<div class="cleared"></div>';
			}

			$x++;
		}
	}

	$output .= '<div class="cleared"></div></div>';

	return $output;
}