<?php
/**
 * SoundCloud integration for the Wikia platform
 *
 * @author TK-999
 * @license https://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
$wgExtensionCredits['other'][] = [
	'name'	=> 'SoundCloud',
	'version' => '0.1',
	'author' => 'TK-999',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SoundCloud',
	'descriptionmsg' => 'soundcloud-desc'
];

/**
 * Parameters accepted by SoundCloud's widget API
 * Specify a value to force an override of the SoundCloud default setting
 * if the user didn't provide the parameter
 *
 * @see https://developers.soundcloud.com/docs/api/html5-widget#params
 * @var array
 */
$wgSoundCloudParameterSettings = [
	'color' => '',
	'url' => '',
	'auto_play' => '',
	'buying' => '',
	'liking' => '',
	'download' => '',
	'sharing' => '',
	'show_artwork' => 'false',
	'show_comments' => '',
	'show_playcount' => '',
	'show_user' => '',
	'start_track' => ''
];

// i18n
$wgExtensionMessagesFiles['SoundCloud'] = __DIR__ . '/SoundCloud.i18n.php';

// classes
$wgAutoloadClasses['SoundCloudHooks'] = __DIR__ . '/SoundCloud.hooks.php';

// hooks
$wgHooks['ParserFirstCallInit'][] = 'SoundCloudHooks::onParserFirstCallInit';

// ResourceLoader modules
$wgResourceModules['ext.SoundCloud'] = [
	'styles' => 'modules/ext.SoundCloud.css',
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'extensions/wikia'
];
