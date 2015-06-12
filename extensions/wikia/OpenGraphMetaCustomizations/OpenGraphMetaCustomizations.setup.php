<?php
/**
 * @author Sean Colombo
 * @date 20110707
 *
 * Customize the values for the OpenGraphMeta extension.  This gives us some control over
 * what is put into the open-graph meta tags used by Facebook when an article is shared.
 */

if ( !defined( 'MEDIAWIKI' ) ) die( 'This is an extension to the MediaWiki package and cannot be run standalone.' );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'OpenGraphMetaCustomizations',
	'version' => '0.3',
	'author' => array('[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
	'descriptionmsg' => 'ogmc-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/OpenGraphMetaCustomizations'
);

$wgExtensionMessagesFiles['OpenGraphMetaCustomizations'] = __DIR__ . '/OpenGraphMetaCustomizations.i18n.php';

$wgHooks['ParserAfterTidy'][] = 'egOgmcParserAfterTidy';

/**
 * Adds an output-hook so that the parser knows to apply the customizations.
 */
function egOgmcParserAfterTidy( Parser $parser, &$text ) {
	$pOut = $parser->getOutput();
	$pOut->addOutputHook('applyOpenGraphMetaCustomizations');

	return true;
} // end egOgmcParserAfterTidy

/**
 * Now that the page is far enough along, use ArticleService to set
 * the description on the OuptutPage.  This value will then
 * be used by the OpenGraphMeta extension.
 */
$wgParserOutputHooks['applyOpenGraphMetaCustomizations'] = 'egOgmcParserOutputApplyValues';
function egOgmcParserOutputApplyValues( OutputPage $out, ParserOutput $parserOutput, $data ) {
	wfProfileIn(__METHOD__);
	global $wgTitle;

	$articleId = $wgTitle->getArticleID();
	$titleImage = $titleDescription = null;
	wfRunHooks('OpenGraphMeta:beforeCustomFields', array($articleId, &$titleImage, &$titleDescription));

	// Get description from ArticleService
	if (is_null($titleDescription)) {
		$DESC_LENGTH = 500;
		$articleService = new ArticleService( $wgTitle );
		$titleDescription = $articleService->getTextSnippet( $DESC_LENGTH );
	}

	if (!empty($titleDescription)) {
		$parserOutput->setProperty('description', $titleDescription);
		$out->mDescription = $parserOutput->getProperty('description');
	}

	wfProfileOut(__METHOD__);
} // end egOgmcParserOutputApplyValues()
