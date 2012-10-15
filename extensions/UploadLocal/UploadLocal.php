<?php
if (!defined('MEDIAWIKI')) die();

/*

TODO:
 * Considered more advanced file scanning regexps/recursive searching
 * Allow unzipping without ssh'ing (need a tar library or shell)
 * Migrate repository to Mercurial so we can easily push changes

BUGS:
 * Figure out how to get image overwrites to work properly or fail gracefully
 * Warn when filename contains ampersand. (Apache doesn't like that)

ENHANCEMENTS:
 * Mute extra output from the new page function.
 * Remove debugging info.
 * Dry run capability.

*/

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'UploadLocal',
	'descriptionmsg' => 'uploadlocal-desc',
	//'author' => array( '' ),
	// 'version' => '',
	// 'url' => 'https://www.mediawiki.org/wiki/Extension:UploadLocal'
);
$wgSpecialPages['UploadLocal'] = 'UploadLocal';
$wgExtensionMessagesFiles['UploadLocal'] = dirname( __FILE__ ) . '/UploadLocal.i18n.php';
$wgAutoloadClasses[ 'UploadLocal' ] = dirname( __FILE__ ) . '/UploadLocal_body.php';
$wgAutoloadClasses[ 'WebRequestUploadLocal' ] = dirname( __FILE__ ) . '/WebRequestUploadLocal.php';

$wgUploadLocalDirectory = $IP . '/extensions/UploadLocal/data';

$wgAvailableRights[] = 'uploadlocal';
$wgGroupPermissions['uploader']['uploadlocal'] = true;
$wgGroupPermissions['sysop']   ['uploadlocal'] = true;
$wgSpecialPageGroups['UploadLocal'] = 'media';
