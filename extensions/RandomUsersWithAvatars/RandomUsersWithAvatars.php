<?php
/**
 * RandomUsersWithAvatars - displays a number of randomly selected users
 * that have uploaded an avatar though Special:UploadAvatar.
 * Requires SocialProfile extension (see MW.org documentation page for details).
 *
 * @file
 * @ingroup Extensions
 * @version 1.1
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:RandomUsersWithAvatars Documentation
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'RandomUsersWithAvatars',
	'version' => '1.1',
	'author' => array( 'David Pean', 'Jack Phoenix' ),
	'description' => 'Adds <tt>&lt;randomuserswithavatars&gt;</tt> tag to display the avatars of randomly chosen users',
	'url' => 'http://www.mediawiki.org/wiki/Extension:RandomUsersWithAvatars',
	'descriptionmsg' => 'random-users-avatars-desc',
);

// Internationalization messages
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['RandomUsersWithAvatars'] = $dir . 'RandomUsersWithAvatars.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'wfRandomUsersWithAvatars';
function wfRandomUsersWithAvatars( &$parser ) {
	$parser->setHook( 'randomuserswithavatars', 'GetRandomUsersWithAvatars' );
	return true;
}

function GetRandomUsersWithAvatars( $input, $args, $parser ) {
	global $wgUploadDirectory, $wgDBname, $wgMemc;
	wfLoadExtensionMessages( 'RandomUsersWithAvatars' );

	wfProfileIn( __METHOD__ );

	$parser->disableCache();

	$count = ( isset( $args['count'] ) && is_numeric( $args['count'] ) ) ? intval( $args['count'] ) : 10;
	$per_row = ( isset( $args['row'] ) && is_numeric( $args['row'] ) ) ? intval( $args['row'] ) : 4;

	// Try cache
	$key = wfMemcKey( 'users', 'random', 'avatars', $count, $per_row );
	$data = $wgMemc->get( $key );
	if( !$data ) {
		$files = glob( $wgUploadDirectory . "/avatars/{$wgDBname}_*_ml.*" );
		$wgMemc->set( $key, $files, 60 * 60 );
	} else {
		wfDebug( "Got random users with avatars from cache\n" );
		$files = $data;
	}

	$user_array = array();
	$random_users = array();

	$output = '<div class="random-users-avatars">
		<h2>' . wfMsg( 'random-users-avatars-title' ) . '</h2>';

	$x = 1;

	if( count( $files ) < $count ) {
		$count = count( $files );
	}
	if( $count > 0 ) {
		$random_keys = array_rand( $files, $count );
	} else {
		$random_keys = array();
	}

	foreach( $random_keys as $random ) {
		// Extract user ID out of avatar image name
		$avatar_name = basename( $files[$random] );
		preg_match( "/{$wgDBname}_(.*)_/i", $avatar_name, $matches );
		$user_id = $matches[1];

		if( $user_id ) {
			// Load user
			$user = User::newFromId( $user_id );
			$user->loadFromDatabase();
			$user_name = $user->getName();

			$avatar = new wAvatar( $user_id, 'ml' );
			$user_link = Title::makeTitle( NS_USER, $user_name );

			$output .= '<a href="' . $user_link->escapeFullURL() . '" rel="nofollow">' . $avatar->getAvatarURL() . '</a>';

			if( $x == $count || $x != 1 && $x%$per_row == 0 ) {
				$output .= '<div class="cleared"></div>';
			}
			$x++;

		}
	}

	$output .= '<div class="cleared"></div>
	</div>';

	wfProfileOut( __METHOD__ );

	return $output;
}
