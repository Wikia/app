<?php
/**
 * @author Sean Colombo
 * @date 20110707
 *
 * Customize the values for the OpenGraphMeta extension.  This gives us some control over
 * what is put into the open-graph meta tags used by Facebook when an article is shared.
 */

if ( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'OpenGraphMetaCustomizations',
	'version' => '0.1',
	'author' => '[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]',
	//'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	'descriptionmsg' => 'ogmc-desc',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['OpenGraphMetaCustomizations'] = $dir . '/OpenGraphMetaCustomizations.i18n.php';

$wgHooks['ParserAfterTidy'][] = 'egOgmcParserAfterTidy';


/**
 * Adds an output-hook so that the parser knows to apply the customizations.
 */
function egOgmcParserAfterTidy( &$parser, &$text ) {
	$pOut = $parser->getOutput();
	$pOut->addOutputHook("applyOpenGraphMetaCustomizations");

	return true;
} // end egOgmcParserAfterTidy

/**
 * Now that the page is far enough along, use the ImageServing and ArticleService to set
 * the mainImage and description (respectively) on the OuptutPage.  These values will then
 * be used by the OpenGraphMeta extension.
 */
$wgParserOutputHooks['applyOpenGraphMetaCustomizations'] = 'egOgmcParserOutputApplyValues';
function egOgmcParserOutputApplyValues( $out, $parserOutput, $data ) {
	global $wgTitle;
	$articleId = $wgTitle->getArticleID();

	// Get image from ImageServing
	// TODO: Make sure we automatically respect these restrictions from Facebook:
	// 		"An image URL which should represent your object within the graph.
	//		The image must be at least 50px by 50px and have a maximum aspect ratio of 3:1.
	//		We support PNG, JPEG and GIF formats."
	$imageServing = new ImageServing( array( $articleId ) );
	foreach ( $imageServing->getImages( 1 ) as $key => $value ){
		$imgTitle = Title::newFromText( $value[0]['name'], NS_FILE );
	}
	if(!empty($imgTitle) && is_object($imgTitle)){
		$mainImage = wfFindFile($imgTitle);
		if($mainImage !== false){
			$parserOutput->setProperty("mainImage", $mainImage);
			$out->mMainImage = $parserOutput->getProperty("mainImage");
		}
	}

	// Get description from ArticleService
	$DESC_LENGTH = 100;
	$articleService = new ArticleService( $articleId );
	$desc = $articleService->getTextSnippet( $DESC_LENGTH );
	if(!empty($desc)){
		$parserOutput->setProperty("description", $desc);
		$out->mDescription = $parserOutput->getProperty("description");
	}
	
	if ($page_id = Wikia::getFacebookDomainId()) {
		$out->addMeta("property:fb:page_id",$page_id);
	}
} // end egOgmcParserOutputApplyValues()
