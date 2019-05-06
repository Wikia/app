<?php
/**
 * @author Lore team
 *
 * Something
 */

$wgAutoloadClasses['TaxonomyArticleHooks'] = dirname(__FILE__)."/TaxonomyArticleHooks.class.php";

// Hooks
$wgHooks['ArticleEditUpdates'][] = 'TaxonomyArticleHooks::onArticleEditUpdates';
