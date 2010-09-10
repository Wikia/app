<?php

class ImageOneBox {

	private $images;
	private $searchTerm;
	private $imageLimit;
	static private $instance = null;

	private function __construct( $searchTerm, $imageLimit = 5 ) {
		$this->images = array();
		$this->searchTerm = $searchTerm;
		$this->imageLimit = $imageLimit;
	}

	private function __clone() {
	}

	/**
	 * get class instance
	 * @param string $searchTerm search term
	 * @return ImageOneBox
	 */
	static public function getInstance( $searchTerm = '' ) {
		if(self::$instance == null) {
			self::$instance = new ImageOneBox( $searchTerm );
		}
		return self::$instance;
	}

	public static function examineSearchResults ( $term, &$titleMatches, &$textMatches ) {
		wfProfileIn(__METHOD__);

		$box = ImageOneBox::getInstance( $term );

		if ( isset($titleMatches) ) {
			$box->getImagesFromResultSet($titleMatches);
		}

		if ( isset($textMatches) ) {
			$box->getImagesFromResultSet($textMatches);
		}

		if ( !$box->isEnoughImages() ) {
			// perform normal search only when there's not enough images provided by ImageServing logic
			$box->getImagesFromFileSearch();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function showImageOneBox ( &$out, $result, $terms, $num ) {
		// load dependencies (CSS and JS)
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/Search/ImageOneBox.css?{$wgStyleVersion}");

		if ($num == 3) {
			$out .= ImageOneBox::getInstance()->render();
		}

		return true;
	}

	/**
	 * perform NS_FILE namespace search for images
	 */
	public function getImagesFromFileSearch() {
		wfProfileIn(__METHOD__);

		$search = SearchEngine::create();
		$search->setLimitOffset( $this->imageLimit, 0 );
		$search->setNamespaces( array(NS_FILE) );
		$search->showRedirects = null;
		$search->prefix = '';
		$term = $search->transformSearchTerm( $this->searchTerm );
		$rewritten = $search->replacePrefixes($term);
		$titleMatches = $search->searchTitle( $rewritten );
		$textMatches = $search->searchText( $rewritten );

		if (isset($titleMatches)) {
			while ($match = $titleMatches->next()) {
				$textform = $match->mTitle->mTextform;
				$textform = preg_replace('/^File:/', '', $textform);

				$img = wfFindFile($textform);
				if ($img != null) {
					$this->images[] = array( 'image' => $img, 'pages' => $this->filesForImage($textform) );
				}
			}
		}

		if (isset($textMatches)) {
			while ($match = $textMatches->next()) {
				$textform = $match->mTitle->mTextform;
				$textform = preg_replace('/^File:/', '', $textform);

				$img = wfFindFile($textform);
				if ($img != null) {
					$this->images[] = array( 'image' => $img, 'pages' => $this->filesForImage($textform) );
				}
			}
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * get all the images assocaited with articles from the result set, using ImageServing extension
	 * @param SearchResultSet $resultSet result set
	 * @return array
	 */
	public function getImagesFromResultSet ( SearchResultSet $resultSet ) {
		wfProfileIn(__METHOD__);

		if( !class_exists('imageServing') ) {
			// ImageServing extension disabled, skipping
			wfProfileOut(__METHOD__);
			return null;
		}

		$pages = array();
		while( $result = $resultSet->next() ) {
			$titleText = $result->mTitle->mTextform;
			$title = Title::newFromText($titleText, $result->mTitle->mNamespace);

			$pages[] = $title->getArticleID();
		}
		$resultSet->rewind( true );

		$imageServing = new imageServing( $pages );
		$images = $imageServing->getImages(  ); // get just one image per article
		foreach( $pages as $pageId ) {
			if( isset( $images[$pageId] ) ) {
				$image = $images[$pageId][0];
				$this->images[] = array( 'image' => wfFindFile( $image['name'] ), 'url' => $image['url'], 'pages' => $this->filesForImage( $image['name'] ) );
			}
		}

		wfProfileOut(__METHOD__);
		return $this->images;
	}

	// TODO: consider of moving this part to ImageServing
	private function filesForImage ( $name ) {
		$dbs = wfGetDB(DB_SLAVE);
		$res = $dbs->select(
			array( 'imagelinks' ),
			array( 'il_from' ),
			array( 'il_to' => $name ),
			__METHOD__
		);

		$files = array();
		while($row = $dbs->fetchObject($res)) {
			$f = $row->il_from;
			$files[] = $f;
		}

		return $files;
	}

	public function render ( $num = 5 ) {
		if ( count($this->images) == 0 ) {
			return '';
		}

		$num_images = 0;
		$image_data = array();

		foreach ($this->images as $info) {
			$data = array('titles' => array());

			$img = $info['image'];

			if( empty($info['url']) ) {
				$thumb = $img->transform( array( 'width' => 100, 'height' => 100) );
				$thumbUrl = $thumb->getUrl();
			}
			else {
				$thumbUrl = $info['url'];
			}

			$fileUrl = $img->getTitle()->getLocalUrl();

			if (count($info['pages']) > 0) {
				// If there are more than 4 pages, include a See More link
				$data['seeMore'] = count($info['pages']) > 4 ? $fileUrl : false;

				// Take only the first 4 pages
				$num_pages = 0;
				$first_title;
				foreach ($info['pages'] as $page_id) {
					$title = Title::newFromID($page_id);
					if ($num_pages == 0)
						$first_title = $title;

					if ($title->getNamespace() == NS_MAIN) {
						$data['titles'][] = $title;
						$num_pages++;
					}
					if ($num_pages == 4) break;
				}
				$data['lightBox'] = false;
				$data['mainImageLink'] = $first_title->getLocalUrl();
			} else {
				$data['lightBox'] = true;
				$data['mainImageLink'] = $fileUrl;
			}

			$data['thumbUrl'] = $thumbUrl;

			$image_data[] = $data;

			$num_images++;
			if ($num_images >= $num) break;
		}

		$oTmpl = new EasyTemplate( dirname(__FILE__) . "/templates/" );
		$oTmpl->set_vars( array( 'searchTerm' => $this->searchTerm, 'images' => $image_data) );

		return $oTmpl->render("image-one-box");
	}

	public function isEnoughImages() {
		return ( count( $this->images ) >= $this->imageLimit ) ? true : false;
	}

	public function getImageLimit() {
		return $this->imageLimit;
	}

}