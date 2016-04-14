<?php
/**
* Hooks
*/
$wgAutoloadClasses['Wikia\VisualEditorTourExperiment\Hooks'] = __DIR__ . '/VisualEditorTourExperiment.hooks.php';
$wgHooks['BeforePageDisplay'][] = 'Wikia\VisualEditorTourExperiment\Hooks::onBeforePageDisplay';
