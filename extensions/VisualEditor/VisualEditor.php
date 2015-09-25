<?php
// Wikia change begin, @author: Inez Korczyński
require_once( __DIR__ . '/registration/Processor.php' );
require_once( __DIR__ . '/registration/ExtensionProcessor.php' );
require_once( __DIR__ . '/registration/ExtensionRegistry.php' );

ExtensionRegistry::getInstance()->queue( __DIR__ . '/extension.json' );

$wgExtensionMessagesFiles['VisualEditor'] = __DIR__ . '/VisualEditor.i18n.php';
// Keep i18n globals so mergeMessageFileList.php doesn't break
$wgMessagesDirs['VisualEditor'] = array(
	__DIR__ . '/lib/ve/i18n',
	__DIR__ . '/modules/ve-mw/i18n',
	__DIR__ . '/modules/ve-wmf/i18n'
);

ExtensionRegistry::getInstance()->loadFromQueue();
// Wikia change end
