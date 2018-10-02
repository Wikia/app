<?php
namespace Wikia\Tasks\Tasks;

/**
 * Asynchronously update the image serving index for a page after it was edited
 * @see SRE-109
 */
class ImageServingTask extends BaseTask {
	const IMAGES_PER_ARTICLE = 230;

	public function createIndexFromPageContent() {
		$wikiPage = \WikiPage::factory( $this->title );
		$content = $wikiPage->getText();

		\ImageServingHelper::hookSwitch( true );
		$editInfo = $wikiPage->prepareTextForEdit( $content );
		\ImageServingHelper::hookSwitch( false );

		$out = [];
		preg_match_all("/(?<=(image mw=')).*(?=')/U", $editInfo->output->getText(), $out );
		$imageList = $out[0];

		\Hooks::run( "ImageServing::buildAndGetIndex", [ &$imageList, $this->title ] );

		$this->buildIndex( $this->title->getArticleID(), $imageList );
	}

	public function createIndexFromImages( array $images ) {
		$this->buildIndex( $this->title->getArticleID(), $images );
	}

	private function buildIndex( int $articleId, array $images ) {
		// BugId:95164: limit the number of images to be stored serialized in DB
		// keep it under 65535 bytes
		if ( count( $images ) > self::IMAGES_PER_ARTICLE ) {
			$images = array_slice( $images, 0, self::IMAGES_PER_ARTICLE );
		}

		array_walk( $images, function ( &$n ) { $n = urldecode( $n ); } );

		if ( count( $images ) < 1 ) {
			wfDeleteWikiaPageProp( WPP_IMAGE_SERVING, $articleId );
			return [];
		}

		wfSetWikiaPageProp( WPP_IMAGE_SERVING, $articleId, $images );
		return $images;
	}
}
