<?php
/**
 * Article Exporter Extension
 *
 * @author Lore team
 */

$dir = __DIR__ . '/';


/**
 * Wikia API controllers
 */
$wgAutoloadClasses['ArticleExporterApiController'] = $dir . 'ArticleExporterApiController.class.php';
$wgAutoloadClasses['ArticleExporter'] = $dir . 'ArticleExporter.class.php';
$wgWikiaApiControllers['ArticleExporterApiController'] = $dir . 'ArticleExporterApiController.class.php';
