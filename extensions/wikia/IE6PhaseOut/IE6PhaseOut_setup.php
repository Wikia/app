<?php
/**
 * IE6PhaseOut
 *
 * This extension shows message for IE6 users (RT #44794)
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/IE6PhaseOut/IE6PhaseOut_setup.php");
 */
$wgExtensionCredits['other'][] = array(
	'name' => 'IE6PhaseOut',
	'author' => 'Maciej Brencz',
	'description' => 'Shows message for Internet Explorer 6 users',
);

$dir = dirname(__FILE__) . '/';

// register extension class
$wgAutoloadClasses['IE6PhaseOut'] = $dir . 'IE6PhaseOut.class.php';

// i18n
$wgExtensionMessagesFiles['IE6PhaseOut'] = $dir . 'IE6PhaseOut.i18n.php';

// hooks
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'IE6PhaseOut::showNotice';
