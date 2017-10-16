<?php
use Wikia\Paginator\Paginator;

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSectionMedia extends CategoryExhibitionSection {
	protected $templateName = 'item-media';

	protected function generateSectionData() {
		global $wgCategoryExhibitionMediaSectionRows;
		$this->sectionId = 'mw-images';
		$this->headerMessage = wfMessage( 'category-exhibition-media-header', $this->categoryTitle );
		$this->generateData( NS_FILE, $wgCategoryExhibitionMediaSectionRows * 4 );
	}

	protected function getTemplateVarsForItem( $pageId ) {
		$itemTitle = Title::newFromID( $pageId );
		$forceHeight = '';
		$forceWidth = '';
		$isVideo = WikiaFileHelper::isFileTypeVideo( $itemTitle );

		// item is image
		$image = wfFindFile( $itemTitle );
		$elementClass = 'lightbox';

		if ( !is_object( $image ) || $image->height == 0 || $image->width == 0 ) {
			$imageSrc = '';
		} else {
			$proportions = $image->width / $image->height;
			if ( $proportions < 1 ) {
				$calculatedWidth = floor( $proportions * $this->thumbWidth );
			} else {
				$calculatedWidth = $this->thumbMedia;
			}
			$forceWidth = floor( $calculatedWidth );
			$forceHeight = floor( $calculatedWidth / $proportions );

			$imageServing = new ImageServing( array( $pageId ), $calculatedWidth, array( "w" => $image->width, "h" => $image->height ) );
			$imageSrc = wfReplaceImageServer(
				$image->getThumbUrl(
					$imageServing->getCut( $image->width, $image->height ) . "-" . $image->getName()
				)
			);

			if ( $isVideo ) {
				$videoSizeClass = ThumbnailHelper::getThumbnailSize( $forceWidth );
				$elementClass .= ' video video-thumbnail ' . $videoSizeClass;
			}
		}
		$linkedFiles = $this->getLinkedFiles( $itemTitle );
		if ( !empty( $linkedFiles ) ) {
			$linkText = $linkedFiles->getText();
			$linkFullUrl = $linkedFiles->getFullURL();
		} else {
			$linkText = '';
			$linkFullUrl = '';
		}

		return [
			'id' => $pageId,
			'title' => $itemTitle->getText(),
			'key' => $itemTitle->getDBKey(),
			'img' => (string) $imageSrc,
			'url' => $itemTitle->getFullURL(),
			'dimensions' => array( 'w' => (int) $forceWidth, 'h' => (int) $forceHeight ),
			'class' => $elementClass,
			'data-ref' => $itemTitle->getPrefixedURL(),
			'targetUrl' => $linkFullUrl,
			'targetText' => $linkText,
			'isVideo' => $isVideo,
		];
	}

	private static function getNameFromTitle( $title ) {
		global $wgCapitalLinks;
		if ( !$wgCapitalLinks ) {
			$name = $title->getUserCaseDBKey();
		} else {
			$name = $title->getDBkey();
		}
		return ":" . $name;
	}

	private function getLinkedFiles( $title ) {
		// The ORDER BY ensures we get NS_MAIN pages first
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			array( 'imagelinks', 'page' ),
			array( 'page_namespace', 'page_title' ),
			'(il_to = ' . $dbr->addQuotes( $title->getDBKey() ) . ' OR il_to = ' . $dbr->addQuotes( $this->getNameFromTitle( $title ) ) . ' OR il_to = ' . $dbr->addQuotes( $title->getPrefixedText() ) . ') AND il_from = page_id',
			__METHOD__,
			array( 'LIMIT' => 1 )
		);

		while ( $s = $res->fetchObject() ) {
			return Title::makeTitle( $s->page_namespace, $s->page_title );
		}

		return false;
	}
}
