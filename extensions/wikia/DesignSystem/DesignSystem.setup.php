<?php
/**
 * Design System Extension
 */

$wgExtensionCredits['api'][] = [
	'name' => 'Design System',
	'descriptionmsg' => 'design-system-desc',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/DesignSystem'
];

// i18n
$wgExtensionMessagesFiles['DesignSystem'] = __DIR__ . '/DesignSystem.i18n.php';
$wgMessagesDirs['DesignSystem'] = __DIR__ . '/node_modules/design-system-i18n/i18n';

// controllers
$wgAutoloadClasses[ 'DesignSystemGlobalFooterController' ] = __DIR__ . '/controllers/DesignSystemGlobalFooterController.class.php';

// helpers
$wgAutoloadClasses[ 'DesignSystemHelper' ] = __DIR__ . '/DesignSystemHelper.class.php';
$wgAutoloadClasses[ 'DesignSystemHooks' ] = __DIR__ . '/DesignSystemHooks.class.php';

// hooks
$wgHooks[ 'BeforePageDisplay' ][] = 'DesignSystemHooks::onBeforePageDisplay';
