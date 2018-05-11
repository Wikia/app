<?php

/**
 * Category Exhibition sub-categories section class
 */
class CategoryExhibitionSectionSubcategories extends CategoryExhibitionSection {
	protected function generateSectionData() {
		global $wgCategoryExhibitionSubCategoriesSectionRows;
		$this->sectionId = 'mw-subcategories';
		$this->headerMessage = wfMessage( 'category-exhibition-subcategories-header' );
		$this->generateData( NS_CATEGORY, $wgCategoryExhibitionSubCategoriesSectionRows * 4 );
	}

	protected function getTemplateVarsForItem( $oTitle ) {
		$oMemCache = F::App()->wg->memc;
		$sKey = wfMemcKey(
			'category_exhibition_article_cache_0',
			$oTitle->getArticleId(),
			$this->cacheHelper->getTouched( $oTitle ),
			// Display/sort params are passed to the subcategory, cache separately!
			$this->urlParams->getSortParam(),
			$this->urlParams->getDisplayParam(),
			self::CACHE_VERSION
		);

		$cachedResult = $oMemCache->get( $sKey );

		if ( !empty( $cachedResult ) ) {
			return $cachedResult;
		}

		$snippetText = '';
		$imageUrl = $this->getImageFromPageId( $oTitle->getArticleId() );

		// if category has no images in page content, look for images and articles in category
		if ( $imageUrl == '' ) {
			$resultArray = $this->getCategoryImageOrSnippet( $oTitle->getArticleId() );
			$snippetText = $resultArray['snippetText'];
			$imageUrl = $resultArray['imageUrl'];
			if ( empty( $snippetText ) && empty( $imageUrl ) ) {
				$snippetService = new ArticleService ( $oTitle );
				$snippetText = $snippetService->getTextSnippet();
			}
		}

		$returnData = [
			'id' => $oTitle->getArticleId(),
			'title' => $oTitle->getText(),
			// Pass the display/sort params to the subcategory:
			'url' => $oTitle->getFullURL( [
				'display' => $this->urlParams->getDisplayParam(),
				'sort' => $this->urlParams->getSortParam(),
			] ),
			'img' => $imageUrl,
			'width' => $this->thumbWidth,
			'height' => $this->thumbHeight,
			'snippet' => $snippetText,
		];

		// will be purged elsewhere after edit
		$oMemCache->set( $sKey, $returnData, 3600 * 24 * 7 );

		return $returnData;
	}

	/**
	 * Returns image or snippet for the category on id basis.
	 * Uses in modified getArticle
	 *
	 * @param $iCategoryId int category pageId
	 * @return array
	 */

	protected function getCategoryImageOrSnippet( $iCategoryId ) {
		$title = Title::newFromID( $iCategoryId );

		$sCategoryDBKey = $title->getDBKey();

		// tries to get image from images in category
		$result = CategoryDataService::getAlphabetical( $sCategoryDBKey, NS_FILE, 1 )->getAll();
		if ( !empty( $result ) ) {
			$counter = 0;
			foreach ( $result as $itemTitle ) {
				if ( $counter > F::App()->wg->maxCategoryExhibitionSubcatChecks ) {
					break;
				}
				$imageServing = new ImageServing( [ $itemTitle->getArticleID() ], $this->thumbWidth, array( "w" => $this->thumbWidth, "h" => $this->thumbHeight ) );
				$image = wfFindFile( $itemTitle );
				if ( !empty( $image ) ) {
					$imageSrc = wfReplaceImageServer(
						$image->getThumbUrl(
							$imageServing->getCut( $image->width, $image->height ) . "-" . $image->getName()
						)
					);
					return array( 'imageUrl' => (string) $imageSrc, 'snippetText' => '' );
				}
				$counter++;
			}
		}

		// if no images found, tries to get image or snippet from artice
		unset( $result );
		$result = CategoryDataService::getAlphabetical( $sCategoryDBKey, NS_MAIN, 10 )->getArticleIds();
		if ( !empty( $result ) ) {
			$counter = 0;
			$snippetText = '';
			$imageUrl = '';
			foreach ( $result as $pageId ) {
				if ( $counter > F::App()->wg->maxCategoryExhibitionSubcatChecks ) {
					break;
				}
				$imageUrl = $this->getImageFromPageId( $pageId );
				if ( !empty( $imageUrl ) ) {
					break;
				}
				if ( empty( $snippetText ) ) {
					$snippetService = new ArticleService ( $pageId );
					$snippetText = htmlspecialchars( $snippetService->getTextSnippet() );
				}
				$counter++;
			}
			return array( 'imageUrl' => $imageUrl, 'snippetText' => $snippetText );
		} else {
			return array( 'imageUrl' => '', 'snippetText' => '' );
		}
	}
}
