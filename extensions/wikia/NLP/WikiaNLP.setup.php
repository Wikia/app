<?php
/**
 * Wikia NLP Extension
 *
 * @author Robert Elwell <robert(at)wikia-inc.com>
 */


$wgExtensionCredits['other'][] = array(
		'name'              => 'Wikia NLP',
		'version'           => '1.0',
		'author'            => '[http://wikia.com/wiki/User:Relwell Robert Elwell]',
		'descriptionmsg'    => 'wikia-nlp-desc',
);

$dir = dirname(__FILE__) . '/';

// we still haven't done sensible cross-extension namespace autoloading, grr
$wgAutoloadClasses['Wikia\NLP\Entities\PageEntitiesService'] =  $dir . 'classes/Entities/PageEntitiesService.php';
$wgAutoloadClasses['Wikia\NLP\Entities\WikiEntitiesService'] =  $dir . 'classes/Entities/WikiEntitiesService.php';
$wgAutoloadClasses['Wikia\NLP\Entities\Hooks'] =  $dir . 'classes/Entities/Hooks.php';

// this would be for page_wikia_props -- should move to defines if we use it.
define( 'PAGE_ENTITIES_KEY', 22 );

if ( $wgEnableEntitiesForDFP ) {
	$wgHooks['ArticleViewHeader'][] = 'Wikia\NLP\Entities\Hooks::onArticleViewHeader';
}