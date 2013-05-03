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
	'version' => '0.2',
	'author' => array('[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
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
	$pOut->addOutputHook('applyOpenGraphMetaCustomizations');

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
	$titleImage = $titleDescription = null;
	wfRunHooks('OpenGraphMeta:beforeCustomFields', array($articleId, &$titleImage, &$titleDescription));

	// Only use ImageServing if no main image is already specified.  This lets people override the image with the parser function: [[File:{{#setmainimage:Whatever.png}}]].
	if(!isset($out->mMainImage)){
		if (is_null($titleImage)) {
			// Get image from ImageServing
			// TODO: Make sure we automatically respect these restrictions from Facebook:
			// 		"An image URL which should represent your object within the graph.
			//		The image must be at least 50px by 50px and have a maximum aspect ratio of 3:1.
			//		We support PNG, JPEG and GIF formats."
			$imageServing = new ImageServing( $articleId );
			foreach ( $imageServing->getImages( 1 ) as $key => $value ) {
				$titleImage = Title::newFromText( $value[0]['name'], NS_FILE );
			}
		}
		
		// If ImageServing was not able to deliver a good match, fall back to the wiki's wordmark.
		if ( empty($titleImage) && !is_object( $titleImage ) && F::app()->checkSkin( 'oasis' ) ){
			$themeSettings = new ThemeSettings();
			$settings = $themeSettings->getSettings();
			if ($settings["wordmark-type"] == "graphic") {
				$titleImage = Title::newFromText( $settings['wordmark-image-name'], NS_FILE );
			}
		}

		// If we have a Title object for an image, convert it to an Image object and store it in mMainImage.
		if (!empty($titleImage) && is_object($titleImage)) {
			$mainImage = wfFindFile($titleImage);
			if ($mainImage !== false) {
				$parserOutput->setProperty('mainImage', $mainImage);
				$out->mMainImage = $parserOutput->getProperty('mainImage');
			}
		} else {
			// Fall back to using a Wikia logo.  There aren't any as "File:" pages, so we use a new config var for one that
			// is being added to skins/common.
			global $wgBigWikiaLogo;
			$logoUrl = wfReplaceImageServer( $wgBigWikiaLogo );
			$parserOutput->setProperty('mainImage', $logoUrl);
			$out->mMainImage = $parserOutput->getProperty('mainImage');
		}
	}

	// Get description from ArticleService
	if (is_null($titleDescription)) {
		$DESC_LENGTH = 100;
		$articleService = new ArticleService( $wgTitle );
		$titleDescription = $articleService->getTextSnippet( $DESC_LENGTH );
	}

	if (!empty($titleDescription)) {
		$parserOutput->setProperty('description', $titleDescription);
		$out->mDescription = $parserOutput->getProperty('description');
	}

	if ($page_id = Wikia::getFacebookDomainId()) {
		$out->addMeta('property:fb:page_id', $page_id);
	}
} // end egOgmcParserOutputApplyValues()