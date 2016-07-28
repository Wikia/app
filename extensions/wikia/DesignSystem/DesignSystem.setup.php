<?php
/**
 * Design System Extension
 */
$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['api'][] = [
	'name' => 'Design System',
	'descriptionmsg' => 'design-system-desc',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/DesignSystem'
];

// i18n
$wgExtensionMessagesFiles['DesignSystem'] = $dir . 'DesignSystem.i18n.php';

// helpers
$wgAutoloadClasses[ 'DesignSystemHooks' ] = $dir . 'DesignSystemHooks.class.php';

// hooks
$wgHooks[ 'BeforePageDisplay' ][] = 'DesignSystemHooks::onBeforePageDisplay';
$wgHooks[ 'GetHTMLAfterBody' ][] = 'DesignSystemHooks::onGetHTMLAfterBody';
