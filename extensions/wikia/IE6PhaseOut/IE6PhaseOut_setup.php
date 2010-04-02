<?php
/**
 * This extension shows message for IE6 users (RT #44794)
 */

$dir = dirname(__FILE__) . '/';

// register extension class
$wgAutoloadClasses['IE6PhaseOut'] = $dir . 'IE6PhaseOut.class.php';

// i18n
$wgExtensionMessagesFiles['IE6PhaseOut'] = $dir . 'IE6PhaseOut.i18n.php';

// hooks
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'IE6PhaseOut::showNotice';
