<?php
/**
 * @author Lore team
 *
 * Send plaintext versions of articles to RabbitMQ as they are edited on Fandom
 */

$wgAutoloadClasses['TaxonomyArticleHooks'] = dirname( __FILE__ ) . "/TaxonomyArticleHooks.class.php";

// Hooks
$wgHooks['ArticleEditUpdates'][] = 'TaxonomyArticleHooks::onArticleEditUpdates';
