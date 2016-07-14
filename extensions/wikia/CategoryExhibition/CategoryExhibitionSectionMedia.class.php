<?php
use Wikia\Paginator\Paginator;

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSectionMedia extends CategoryExhibitionSection {

	public $urlParameter = 'media'; // contains section url variable that stores pagination
	public $templateName = 'media';

	public function getHTML() {

		global $wgCategoryExhibitionMediaSectionRows;

		$cachedContent = $this->getFromCache();
		if ( empty( $cachedContent ) ){
			// grabs data for videos and images
			$aTmpData = $this->fetchSectionItems( array( NS_FILE ) ); // we wan't old videos
			if ( is_array( $aTmpData ) && count( $aTmpData ) > 0 ){
				$pages = new Paginator(
					count( $aTmpData ),
					$wgCategoryExhibitionMediaSectionRows * 4,
					$this->sUrl,
					[ 'paramName' => $this->urlParameter ]
				);
				$pages->setActivePage( $this->paginatorPosition );
				$pageData = $pages->getCurrentPage( $aTmpData );
				$aData = array();
				foreach( $pageData as $item ){
					$itemTitle = Title::newFromID($item['page_id']);
					$forceHeight = '';
					$forceWidth = '';
					$isVideo = WikiaFileHelper::isFileTypeVideo( $itemTitle );

					// item is image
					$image = wfFindFile( $itemTitle );
					$elementClass = 'lightbox';

					if ( !is_object( $image ) || $image->height == 0 || $image->width == 0 ){
						$imageSrc = '';
					} else {
						$proportions = $image->width / $image->height;
						if ( $proportions < 1 ){
							$calculatedWidth = floor( $proportions * $this->thumbWidth );
						} else {
							$calculatedWidth = $this->thumbMedia;
						}
						$forceWidth = floor( $calculatedWidth );
						$forceHeight = floor( $calculatedWidth / $proportions );

						$imageServing = new ImageServing( array( $item['page_id'] ), $calculatedWidth , array( "w" => $image->width, "h" => $image->height ) );
						$imageSrc = wfReplaceImageServer(
							$image->getThumbUrl(
								$imageServing->getCut( $image->width, $image->height )."-".$image->getName()
							)
						);

						if ( $isVideo ) {
							$videoSizeClass = ThumbnailHelper::getThumbnailSize( $forceWidth );
							$elementClass .= ' video video-thumbnail ' . $videoSizeClass;
						}
					}
					$linkedFiles = $this->getLinkedFiles( $itemTitle );
					if ( !empty( $linkedFiles ) ){
						$linkText = $linkedFiles->getText();
						$linkFullUrl = $linkedFiles->getFullURL();
					} else {
						$linkText = '';
						$linkFullUrl = '';
					}

					// types casting for proper caching;
					$aData[] = array(
						'id'         => $item['page_id'],
						'title'      => $itemTitle->getText(),
						'key'        => $itemTitle->getDBKey(),
						'img'        => (string)$imageSrc,
						'url'        => $itemTitle->getFullURL(),
						'dimensions' => array('w' => (int)$forceWidth, 'h' => (int)$forceHeight),
						'class'      => $elementClass,
						'data-ref'   => $itemTitle->getPrefixedURL(),
						'targetUrl'  => $linkFullUrl,
						'targetText' => $linkText,
						'isVideo'    => $isVideo,
					);
				};

				$aContent = array (
						'data'		=> $aData,
						'category'	=> $this->categoryTitle->getText(),
						'paginator'	=> $pages->getBarHTML()
					);
				$this->saveToCache( $aContent );
			} else {
				return false;
			}
		} else {
			$aContent = $cachedContent;
		};

		if ( !empty( $aContent ) && is_array( $aContent )){

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( $aContent );
			$oTmpl->set_vars(array('fromAjax' => $this->isFromAjax));
			if ( $this->isFromAjax ){
				return array(
				    'page'	=> $oTmpl->render( $this->templateName ),
				    'paginator'	=> $oTmpl->mVars['paginator']
				);
			} else {
				return $oTmpl->render( $this->templateName );
			}
		}
	}

	public function getSectionHTML(){
		$this->loadPaginationVars();
		return $this->getHTML();
	}

	public function getSectionAxHTML( $paginatorPosition, $sUrl ){
		$this->isFromAjax = true;
		$this->paginatorPosition = $paginatorPosition;
		$this->sUrl = $sUrl;
		return $this->getHTML();
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

	private function getLinkedFiles ( $title ) {

		global $wgUser;

		// The ORDER BY ensures we get NS_MAIN pages first
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
                        array( 'imagelinks', 'page' ),
                        array( 'page_namespace', 'page_title' ),
			'(il_to = ' .  $dbr->addQuotes( $title->getDBKey() ) . ' OR il_to = ' . $dbr->addQuotes( $this->getNameFromTitle( $title ) ) .' OR il_to = ' . $dbr->addQuotes( $title->getPrefixedText() ) . ') AND il_from = page_id',
                        __METHOD__,
                        array( 'LIMIT' => 1)
                );

		while ( $s = $res->fetchObject() ) {
			return  Title::makeTitle( $s->page_namespace, $s->page_title );
		}

		return false;
	}
}
