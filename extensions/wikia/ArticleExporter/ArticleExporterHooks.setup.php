<?php
/**
 * Article Exporter Extension
 *
 * @author Lore team
 */

$dir = __DIR__ . '/';

// Autoload
$wgAutoloadClasses['ArticleExporterHooks'] = dirname( __FILE__ ) . "/ArticleExporterHooks.class.php";

// Hooks
$wgHooks['ArticleSaveComplete'][] = 'ArticleExporterHooks::onArticleSaveComplete';