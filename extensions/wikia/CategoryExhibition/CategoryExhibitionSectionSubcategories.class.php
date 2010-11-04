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

		$this->loadPaginationVars();
		$oTmpl = $this->getTemplateForNameSpace( NS_CATEGORY, 8  );
		return $this->executeTemplate( $oTmpl );
	}

	/**
	 * Returns section HTML.
	 * Used in ajax requests
	 * 
	 * @return string
	 */

	public function getSectionAxHTML( $paginatorPosition, $sUrl ){

		$this->isFromAjax = true;
		$this->paginatorPosition = $paginatorPosition;
		$this->sUrl = $sUrl;
		$oTmpl = $this->getTemplateForNameSpace( NS_CATEGORY, 8 );
		return $this->executeTemplate( $oTmpl );
	}

	/**
	 * Overides parent class. Returns data displayed in category.
	 * This class uses not only images from page itself, but also form its sub articles and images.
	 *
	 * @param $aTmpData array Array returned by getTemplateFromNameSpace()
	 * @return array
	 */

	protected function getArticles( $aTmpData ){

		$aData = array();
		foreach( $aTmpData as $item ){
			$snippetText = '';
			$imageUrl = $this->getImageFromPageId( $item['page_id'] );

			// if category has no images in page content, look for images and articles in category
			if ( $imageUrl == '' ){
				$resultArray = $this->getCategoryImageOrSnippet( $item['page_id'] );
				$snippetText = $resultArray['snippetText'];
				$imageUrl = $resultArray['imageUrl'];
				if ( empty($snippetText) && empty($imageUrl) ){
					$snippetService = new ArticleService ( $item['page_id'] );
					$snippetText = $snippetService->getTextSnippet();
				}
			}
			$aData[] = array(
			    'id'		=> $item['page_id'],
			    'title'		=> Title::newFromDBkey($item['page_title'])->getText(),
			    'img'		=> $imageUrl,
			    'url'		=> Title::newFromID($item['page_id'])->getFullURL(),
			    'snippet'		=> $snippetText,
			    'sortType'		=> $this->getSortType(),
			    'displayType'	=> $this->getDisplayType()
			);
		};
		return $aData;
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
		$result = CategoryDataService::getMostVisited( $sCategoryDBKey , NS_FILE, 1 );
		if ( !empty($result) ){
			foreach($result as $item){
				$imageServing = new imageServing( array($item['page_id']), $this->thumbWidth , array( "w" => $this->thumbWidth, "h" => $this->thumbHeight ) );
				$itemTitle = Title::newFromID($item['page_id']);
				$image = wfFindFile( $itemTitle );
				$imageSrc = wfReplaceImageServer(
					$image->getThumbUrl(
						$imageServing->getCut($image->width,$image->height)."-".$image->getName()
					)
				);
				return array('imageUrl' => (string)$imageSrc, 'snippetText' => '');
			}
		}

		// if no images found, tries to get image or snippet from artice
		unset($result);
		$result = CategoryDataService::getMostVisited( $sCategoryDBKey , NS_MAIN, 10 );
		if ( !empty($result) ){
			$snippetText = '';
			$imageUrl = '';
			$pageIdList = array();
			foreach($result as $item){
				foreach($result as $item){
					$imageUrl = $this->getImageFromPageId( $item['page_id'] );
					if ( !empty($imageUrl) ){
						break;
					}
					if ( empty($snippetText) ){
						$snippetService = new ArticleService ( $item['page_id'] );
						$snippetText = $snippetService->getTextSnippet();;
					}
				}
			}
			return array('imageUrl' => $imageUrl, 'snippetText' => $snippetText);
		} else {
			return array('imageUrl' => '', 'snippetText' => '');
		}
	}
}