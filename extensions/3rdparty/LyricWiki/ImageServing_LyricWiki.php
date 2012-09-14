<?php
/**
 * @author Sean Colombo
 *
 * This extension hooks into Wikia's ImageServing to provide reasonable fallback images
 * on LyricWiki since there is a logical heirarchy of song -> album -> artist on LyricWiki.
 */


if ( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ImageServing tweaks for LyricWiki',
	'version' => '1.0',
	'author' => '[http://seancolombo.com Sean Colombo]',
	//'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	'descriptionmsg' => 'imageserving-lw-desc',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['ImageServing_LyricWiki'] = $dir . '/ImageServing_LyricWiki.i18n.php';

$wgHooks['ImageServing::fallbackOnNoResults'][] = 'lw_ImageServingFallback';

/**
 * This is called by ImageServing if no representative image is found for a page.
 * If this is a song page, will first check the album page, then the artist page for a good image.
 * If this is an album page, will check the artist page for a good image.
 * If this is an artist page, there is no good fallback, so 'out' will be returned unmodified.
 */
function lw_ImageServingFallback(ImageServing $imageServing, $n, &$out){
	wfProfileIn( __METHOD__ );

	// For Gracenote pages (since they don't have their own images), fall back to the NS_MAIN pages with the same titles.
	$articleTitlesToTry = array();
	if(isset($imageServing->articlesByNS[NS_GRACENOTE])){
		$gnArticles = $imageServing->articlesByNS[ NS_GRACENOTE ];
		foreach($gnArticles as $gnArticleData){
			$title = $gnArticleData['title'];

			// Just pass the page title in directly. By not passing the Gracenote namespace in, we'll get the main-namespace equivalent.
			$articleTitlesToTry[] = $title;
		}
	}

	// For main namespace pages, fall back from song to album to artist.
	if(isset($imageServing->articlesByNS[NS_MAIN])){
		$articles = $imageServing->articlesByNS[ NS_MAIN ];
		foreach($articles as $articleData){
			$title = $articleData['title'];

			// If the title is an album, fall back to the artist... if the title is a song, fall back to the album.
			$matches = array();
			if(0 < preg_match("/^(.*?):.*[ _]\([0-9]{4}\)$/", $title, $matches)){
				$articleTitlesToTry[] = $matches[1];
			} else {

				// TODO: Fall back to the album if there is one in the wikiText (which would automatically fall back to the artist if the album doesn't have a pic).
					// NOTE: At the moment, I actually think artist pics might be better than album pics.
				// TODO: Fall back to the album if there is one in the wikiText (which would automatically fall back to the artist if the album doesn't have a pic).

				// Fall back to the artist if no album could be found in the wikiText.
				// TODO: if we have the wikitext already & the artist can be found in there, use that instead of a regex on the title (it is more likely to be accurate since the artist name may have colons in it).
				// TODO: if we have the wikitext already & the artist can be found in there, use that instead of a regex on the title (it is more likely to be accurate since the artist name may have colons in it).
				if(0 < preg_match("/^(.*?):/", $title, $matches)){
			 		$articleTitlesToTry[] = $matches[1];
				}
			}

		}
	}

	// If we found some reasonable fallback-pages above, pass those into ImageServing.
	if(count($articleTitlesToTry) > 0){
		$articleIds = array();
		foreach($articleTitlesToTry as $titleStr){
			$title = Title::newFromText( $titleStr );
			if(is_object($title)){
				$articleId = $title->getArticleID();
				$article = Article::newFromID( $articleId );
				if(is_object($article)){
					/* @var $article WikiPage */
					// Automatically follow redirects.
					if($article->isRedirect()){
						$title = $article->followRedirect();
						$articleId = $title->getArticleID();
					}

					// The title str could be converted into an article-id, so add it to the array to be processed.
					$articleIds[] = $articleId;
				}
			}
		}

		// Some of the titles were real pages, use ImageServing to get the results and store them (by reference) in '$out'.
		if(count($articleIds) > 0){
			$imageServing = new ImageServing( $articleIds );
			$out = $imageServing->getImages( $n );
		}
	}

	wfProfileOut( __METHOD__ );
	return true; // because this is a hook
} // end lw_ImageServingFallback()
