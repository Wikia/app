<?php
 
/**
* LightBox
*
* LightBoxes display media in articles and various modules throught the site. 
*
* @author Liz Lee <liz@wikia-inc.com>
* @date 2012-05-02
* @copyright Copyright (C) 2012 Wikia Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
* @package MediaWiki
*
*/

// Extension credits
$wgExtensionCredits['other'][] = array(
	'name' => 'LightBox',
	'version' => '1.0',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:LightBox',
	'author' => array( 'Liz Lee', 'Hyun Lim' ),
	'descriptionmsg' => 'lightbox-desc',
);

$dir = dirname(__FILE__);

// Interface code
include("$dir/LightBox.php");

// autoloaded classes
$wgAutoloadClasses['LightBox'] = "$dir/LightBox.class.php";

// i18n
$wgExtensionMessagesFiles['LightBox'] = $dir.'/LightBox.i18n.php';

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'LightBox::addJSVariable';
