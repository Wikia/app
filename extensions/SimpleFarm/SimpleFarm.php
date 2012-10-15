<?php
/**
 * A simple farm extension which allows to direct different urls to different wikis which
 * are all using the same MediaWiki base installation and LocalSettings.php
 * Also comes with a useful maintenance script allowing to maintain several farm members
 * with just one command-line command.
 * 
 * Documentation: http://www.mediawiki.org/wiki/Extension:Simple_Farm
 * Support:       http://www.mediawiki.org/wiki/Extension_talk:Simple_Farm
 * Source code:   http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/SimpleFarm
 * 
 * @version: 0.1rc
 * @license: ISC license
 * @author:  Daniel Werner < danweetz@web.de >
 * 
 * @file SimpleFarm.php
 * @ingroup SimpleFarm
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Simple Farm',
	'descriptionmsg' => 'simplefarm-desc',
	'version'        => ExtSimpleFarm::VERSION,
	'author'         => '[http://www.mediawiki.org/wiki/User:Danwe Daniel Werner]',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:SimpleFarm',
);

// language file for extension description:
$wgExtensionMessagesFiles['SimpleFarm'] = ExtSimpleFarm::getDir() . '/SimpleFarm.i18n.php';
/*
 * We don't use $wgExtensionMessagesFiles for more messages since most of this extension happens during
 * localsettings.php , so we can't even be sure the global wiki functions we need for it are available
 * already... This means we output error messages if no wiki farm member was found in English always!
 */

// load default settings:
require ExtSimpleFarm::getDir() . '/SimpleFarm_Settings.php';

// include required classes (not in this file because of maintenance script implications):
require_once ExtSimpleFarm::getDir() . '/SimpleFarm_Classes.php';

/*
 * It's no good, at that stage it is too late to set some global variables like $wgScriptPath
 * because some others depend on it and being set at the beginning of setup.php after default
 * settings and LocalSettings are loaded.
 * That's also why we can't rely on global functions including hook an message system!
 */
// make sure to initialise farm if not manually in 'LocalSettings.php':
// $wgHooks['ParserFirstCallInit'][] = 'SimpleFarm::init';

/**
 * 'Ext...' class representing the 'Simple Farm' extension.
 */
class ExtSimpleFarm {
	
	/**
	 * Version of the 'Simple Farm' extension.
	 * 
	 * @since 0.1
	 */
	const VERSION = '0.1rc';
	
	/**
	 * Returns the extensions base installation directory.
	 *
	 * @since 0.1
	 * 
	 * @return boolean
	 */
	public static function getDir() {
		static $dir = null;		
		if( $dir === null ) {
			$dir = dirname( __FILE__ );
		}
		return $dir;
	}
}