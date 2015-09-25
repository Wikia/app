<?php
ExtensionRegistry::getInstance()->queue( __DIR__ . '/extension.json' );
ExtensionRegistry::getInstance()->loadFromQueue();

$wgExtensionMessagesFiles['VisualEditorWikia'] = __DIR__ . '/VisualEditor.i18n.php';
