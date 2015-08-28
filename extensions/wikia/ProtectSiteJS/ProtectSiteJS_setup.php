<?php
/**
 * Set restrictions on editing JS pages.
 *
 * @author Inez
 * @author grunny
 */

$wgHooks['AlternateEdit'][] = 'ProtectSiteJS::handler';
$wgHooks['ArticleSave'][] = 'ProtectSiteJS::handler';
$wgHooks['EditPage::attemptSave'][] = 'ProtectSiteJS::handler';

$wgAutoloadClasses['ProtectSiteJS'] =  __DIR__ . '/ProtectSiteJS.class.php';
