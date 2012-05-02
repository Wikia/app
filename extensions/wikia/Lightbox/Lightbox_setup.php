<?php
 
/**
* Lightbox
*
* Lightboxes display media in articles and various modules throught the site. 
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
	'name' => 'Lightbox',
	'version' => '1.0',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:Lightbox',
	'author' => array( 'Liz Lee', 'Hyun Lim' ),
	'descriptionmsg' => 'lightbox-desc',
);

$dir = dirname(__FILE__);

// Interface code
include("$dir/Lightbox.php");

// autoloaded classes
$wgAutoloadClasses['Lightbox'] = "$dir/Lightbox.class.php";

// i18n
$wgExtensionMessagesFiles['Lightbox'] = $dir.'/Lightbox.i18n.php';

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'Lightbox::addJSVariable';
