<?php
/**
 * Wikia NLP Extension
 *
 * @author Robert Elwell <robert(at)wikia-inc.com>
 */

global $wgEnableEntitiesForDFP, $wgEnableNlpPipelineEvents, $wgExtensionCredits, $wgAutoloadClasses, $wgContLang, $wgDevelEnvironment;

$wgExtensionCredits['other'][] = array(
		'name'              => 'Wikia NLP',
		'version'           => '1.0',
		'author'            => '[http://wikia.com/wiki/User:Relwell Robert Elwell]',
		'descriptionmsg'    => 'wikia-nlp-desc',
		'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/NLP'
);

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles["NLP"] = $dir . 'WikiaNLP.i18n.php';

// we still haven't done sensible cross-extension namespace autoloading, grr
$wgAutoloadClasses['Wikia\NLP\Entities\PageEntitiesService'] =  $dir . 'classes/Entities/PageEntitiesService.php';
$wgAutoloadClasses['Wikia\NLP\Entities\WikiEntitiesService'] =  $dir . 'classes/Entities/WikiEntitiesService.php';
$wgAutoloadClasses['Wikia\NLP\Entities\Hooks'] =  $dir . 'classes/Entities/Hooks.php';
$wgAutoloadClasses['Wikia\NLP\ParserPipeline\Hooks'] = $dir . 'classes/ParserPipeline/Hooks.php';

if ( $wgEnableTopicsForDFP ) {
	$wgHooks['ArticleViewHeader'][] = 'Wikia\\NLP\\Entities\\Hooks::onArticleViewHeader';
}

if ( (! $wgDevelEnvironment ) &&  $wgLanguageCode == 'en' && $wgEnableNlpPipelineEvents ) {
	$wgHooks['ArticleEditUpdates'][] = 'Wikia\\NLP\\ParserPipeline\\Hooks::onArticleEditUpdates';
	$wgHooks['ArticleDeleteComplete'][] = 'Wikia\\NLP\\ParserPipeline\\Hooks::onArticleDeleteComplete';
	$wgHooks['ArticleUndelete'][] = 'Wikia\\NLP\\ParserPipeline\\Hooks::onArticleUndelete';
}
