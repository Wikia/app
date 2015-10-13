<?php

/**
 * Hooks
 */
$wgAutoloadClasses['Wikia\TemplateClassification\Hooks'] = __DIR__ . '/TemplateClassification.hooks.php';
$wgExtensionFunctions[] = 'Wikia\TemplateClassification\Hooks::register';
