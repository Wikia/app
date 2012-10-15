<?php
/*
 * Widget Framework
 * @author Inez Korczyński
 */
if(!defined('MEDIAWIKI')) {
	die(1);
}

$wgExtensionCredits['specialpage'][] = array(
    'name' => 'WidgetFramework',
    'author' => 'Inez Korczyński',
    'descriptionmsg' => 'widgetframework-desc',
);

$wgAutoloadClasses["ReorderWidgets"] = "$IP/extensions/wikia/WidgetFramework/ReorderWidgets.php";
$wgAutoloadClasses["WidgetFramework"] = "$IP/extensions/wikia/WidgetFramework/WidgetFramework.class.php";

$wgExtensionMessagesFiles['WidgetFramework'] = dirname(__FILE__) . '/WidgetFramework.i18n.php';