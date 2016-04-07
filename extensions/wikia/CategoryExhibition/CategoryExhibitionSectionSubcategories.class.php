<?php

/**
 * Category Exhibition sub-categories section class
 */
class CategoryExhibitionSectionSubcategories extends CategoryExhibitionSection {

	public $urlParameter = 'subcategories'; // contains section url variable that stores pagination
	public $templateName = 'subcategories';

	/**
	 * Returns section HTML.
	 *
	 * @return string
	 */

	public function getSectionHTML(){

		global $wgCategoryExhibitionSubCategoriesSectionRows;
		$this->loadPaginationVars();
		$oTmpl = $this->getTemplateForNameSpace( NS_CATEGORY, $wgCategoryExhibitionSubCategoriesSectionRows * 4 );
		return $this->executeTemplate( $oTmpl );
	}

	/**
	 * Returns section HTML.
	 * Used in ajax requests
	 *
	 * @return string
	 */

	public function getSectionAxHTML( $paginatorPosition, $sUrl ){

		global $wgCategoryExhibitionSubCategoriesSectionRows;
		$this->isFromAjax = true;
		$this->paginatorPosition = $paginatorPosition;
		$this->sUrl = $sUrl;
		$oTmpl = $this->getTemplateForNameSpace( NS_CATEGORY, $wgCategoryExhibitionSubCategoriesSectionRows * 4 );
		return $this->executeTemplate( $oTmpl );
	}

	protected function getArticleData( $pageId ){

		$oTitle = Title::newFromID( $pageId );

		$oMemCache = F::App()->wg->memc;
		$sKey = wfSharedMemcKey(
			'category_exhibition_article_cache_0',
			$pageId,
			F::App()->wg->cityId,
			$this->isVerify(),
			$this->getTouched($oTitle)
		);

		$cachedResult = $oMemCache->get( $sKey );

		if ( !empty( $cachedResult ) ) {
			return $cachedResult;
		}

		$snippetText = '';
		$imageUrl = $this->getImageFromPageId( $pageId );

		// if category has no images in page content, look for images and articles in category
		if ( $imageUrl == '' ){
			$resultArray = $this->getCategoryImageOrSnippet( $pageId );
			$snippetText = $resultArray['snippetText'];
			$imageUrl = $resultArray['imageUrl'];
			if ( empty($snippetText) && empty($imageUrl) ){
				$snippetService = new ArticleService ( $oTitle );
				$snippetText = $snippetService->getTextSnippet();
			}
		}

		$returnData = array(
		    'id'		=> $pageId,
		    'title'		=> $oTitle->getText(),
		    'url'		=> $oTitle->getFullURL(),
		    'img'		=> $imageUrl,
			'width'     => $this->thumbWidth,
			'height'    => $this->thumbHeight,
		    'sortType'		=> $this->getSortType(),
		    'displayType'	=> $this->getDisplayType(),
		    'snippet'		=> $snippetText
		);

		// will be purged elsewhere after edit
		$oMemCache->set( $sKey, $returnData, 60*60*24*7 );

		return $returnData ;
	}

	/**
	 * Returns image or snippet for the category on id basis.
	 * Uses in modified getArticle
	 *
	 * @param $iCategoryId int category pageId
	 * @return array
	 */

	protected function getCategoryImageOrSnippet( $iCategoryId ){

		$title = Title::newFromID( $iCategoryId );

		$sCategoryDBKey = $title->getDBKey();

		// tries to get image from images in category
		$result = CategoryDataService::getAlphabetical( $sCategoryDBKey , NS_FILE, 1 );
		if ( !empty( $result ) ){
			$counter = 0;
			foreach( $result as $item ){
				if ( $counter > F::App()->wg->maxCategoryExhibitionSubcatChecks ){
					break;
				}
				$imageServing = new ImageServing( array( $item['page_id'] ), $this->thumbWidth , array( "w" => $this->thumbWidth, "h" => $this->thumbHeight ) );
				$itemTitle = Title::newFromID( $item['page_id'] );
				$image = wfFindFile( $itemTitle );
				if ( !empty( $image ) ){
					$imageSrc = wfReplaceImageServer(
						$image->getThumbUrl(
							$imageServing->getCut( $image->width, $image->height )."-".$image->getName()
						)
					);
					return array( 'imageUrl' => (string)$imageSrc, 'snippetText' => '' );
				}
				$counter++;
			}
		}

		// if no images found, tries to get image or snippet from artice
		unset( $result );
		$result = CategoryDataService::getAlphabetical( $sCategoryDBKey , NS_MAIN, 10 );
		if ( !empty( $result ) ){
			$counter = 0;
			$snippetText = '';
			$imageUrl = '';
			foreach( $result as $item ){
				if ( $counter > F::App()->wg->maxCategoryExhibitionSubcatChecks ){
					break;
				}
				$imageUrl = $this->getImageFromPageId( $item['page_id'] );
				if ( !empty( $imageUrl ) ){
					break;
				}
				if ( empty($snippetText) ){
					$snippetService = new ArticleService ( $item['page_id'] );
					$snippetText = htmlspecialchars( $snippetService->getTextSnippet() );
				}
				$counter++;
			}
			return array('imageUrl' => $imageUrl, 'snippetText' => $snippetText);
		} else {
			return array('imageUrl' => '', 'snippetText' => '');
		}
	}
}
