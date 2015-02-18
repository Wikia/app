<?php
/*
 * @author: Tomek Odrobny, Sean Colombo
 *
 * Class for getting a list of the top images on a given article.  Also allows
 * retriving thumbnails of those images which are scaled either by an aspect-ratio
 * or specific dimensions.
 */

class ImageServing {
	private $articles = array();
	private $width;
	private $height;
	private $proportion;
	private $deltaY = null;
	private $db;
	private $proportionString;
	/**
	 * @var $tmpDeltaY Integer
	 */
	private $tmpDeltaY;
	/**
	 * @var $articlesByNS array
	 */
	public $articlesByNS;
	/**
	 * @var $imageServingDrivers ImageServingDriverBase
	 */
	private $imageServingDrivers;
	/**
	 * @var $memc MemCache
	 */
	private $memc;

	// store up to 20 images for each article (see BAC-734)
	// ImageServing::getImages() will then take an appropriate slice of them
	const MAX_LIMIT = 20;

	/**
	 * @param $articles Integer[] List of articles ids to get images
	 * @param $width \int image width
	 * @param $proportionOrHight array|Integer can by array with proportion(example: array("w" => 1, "h" => 1)) or just height in pixels (example: 100)  proportion will be
	 * calculated automatically
	 */
	function __construct( $articles = null, $width = 100, $proportionOrHeight = array( "w" => 1, "h" => 1 ), $db = null ){
		if( !is_array( $proportionOrHeight ) ) {
			$height = (int) $proportionOrHeight;
			$this->proportion = array("w" => $width, "h" => $height);
			$this->proportionString = $width.":".$height;
			$this->height = $height;
		} else {
			$this->proportion = $proportionOrHeight;
			$this->proportionString = implode(":", $proportionOrHeight);
			$this->height = (int) round($width / $proportionOrHeight['w'] * $proportionOrHeight['h']);
		}
		$this->articles = array();

		$this->setArticleIds( $articles );

		$this->app = F::app();
		$this->width = $width;
		$this->memc =  $this->app->wg->Memc;
		$this->imageServingDrivers = $this->app->wg->ImageServingDrivers;

		$this->db = $db;
	}

	/**
	 * @return int min width of requested images
	 */
	public function getRequestedWidth() {
		return $this->width;
	}

	/**
	 * @return int min height of requested images
	 */
	public function getRequestedHeight() {
		return $this->height;
	}

	/**
	 * getImages - get array with list of top images for all article passed into the constructor
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 *
	 * @param $limit Integer number of images to get for each article (up to ImageServing::MAX_LIMIT)
	 * @param $driver string ImageServingDriverBase allow to force driver
	 *
	 * @return mixed array of images for each requested article
	 */
	public function getImages( $limit = 5, $driverName = null) {
		wfProfileIn( __METHOD__ );
		$articles = $this->articles;
		$out = array();

		// force ImageServing to return an empty list
		// see PLATFORM-392
		global $wgImageServingForceNoResults;
		if (!empty($wgImageServingForceNoResults)) {
			wfProfileOut(__METHOD__);
			return $out;
		}

		if( !empty( $articles ) ) {
			if( $this->db == null ) {
				$db = wfGetDB( DB_SLAVE, array() );
			} else {
				$db = $this->db;
			}

			$this->articlesByNS = array();

			wfProfileIn( __METHOD__  . '::fetchMetadata');

			// fetch articles metadata (try from cache)
			foreach($articles as $key => $value) {
				$mcValue = $this->memc->get( $this->makeKey($key) );

				if(!empty($mcValue)) {
					unset($articles[$key]);
					$this->addArticleToList($mcValue);
				}
			}

			// fetch articles metadata (from database + cache it)
			if (!empty($articles)) {
				$res = $db->select(
					array( 'page' ),
					array(
						'page_namespace as ns',
						'page_title as title',
						'page_id as id'
					),
					array(
						'page_id' =>  $articles
					),
					__METHOD__
				);

				while ($row =  $db->fetchRow( $res ) ) {
					$this->memc->set( $this->makeKey($row['id']), $row, 86400 );
					$this->addArticleToList($row);
				}
			}

			wfProfileOut( __METHOD__  . '::fetchMetadata');

			if(empty($driverName)) {
				foreach($this->imageServingDrivers as $key => $value ) {
					if(!empty($this->articlesByNS[$key])) {
						/* @var ImageServingDriverBase $driver */
						$driver = new $value($db, $this, $this->proportionString);
						$driver->setArticles($this->articlesByNS[$key]);
						unset($this->articlesByNS[$key]);
						$out = $out + $driver->execute($limit);
					}
				}

				$driver = new ImageServingDriverMainNS($db, $this, $this->proportionString);
			} else {
				$driver = new $driverName($db, $this, $this->proportionString);
			}

			//rest of article in MAIN name spaces
			foreach( $this->articlesByNS as $value ) {
				$driver->setArticles( $value );
				$out = $out + $driver->execute();
			}

			if( empty( $out ) ) {
				// Hook for finding fallback images if there were no matches. - NOTE: should this fallback any time (count($out) < $limit)? Seems like overkill.
				wfRunHooks( 'ImageServing::fallbackOnNoResults', array( &$this, $limit, &$out ) );
			}

			// apply limiting
			foreach($out as &$entry) {
				$entry = array_slice($entry, 0, $limit);
			}
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Adds the article data (from a db row) to the internal mapping of articlesByNS.
	 *
	 * The resulting data is an associative array whose keys are namespaces and whose values
	 * are associative arrays whose keys are article-ids and whose values are associative arrays
	 * of the data which is the same namespace (in key 'ns'), the same article-id (in key 'id'), and
	 * the page_title (in key 'title').
	 *
	 * @TODO: Please refactor this... it's a really weird/confusing datastructure.
	 * @TODO: Is there any reason to store the whole article data instead of just the title at the end?
	 */
	private function addArticleToList($value) {
		if( empty($this->articlesByNS[$value['ns']] )) {
			$this->articlesByNS[$value['ns']]  = array();
		}
		$this->articlesByNS[$value['ns']][$value['id']] = $value;
	}

	/**
	 * Returns memcache key to be used to cache articles metadata (article id + namespace id)
	 *
	 * @param $articleId int
	 * @return String
	 */
	private function makeKey( $articleId ) {
		return wfMemcKey("imageserving-article-metadata", $articleId);
	}

	/**
	 * TODO: remove it image serving work also with FILE_NS we keep this function for backward compatibility
	 * FIXME: this method will return thumbnails for just a single file (despite allowing a list of files to be passed)
	 *
	 * @deprecated use getImages fetches an array with thumbnails and titles for the supplied files
	 * @@author Federico "Lox" Lucignano
	 *
	 * @param Array $fileNames a list of file names to fetch thumbnails for
	 * @return Array an array containing the url to the thumbnail image and the title associated to the file
	 */
	public function getThumbnails( $fileNames = null ) {
		wfProfileIn( __METHOD__ );

		$imagesIds = array();
		if( !empty( $fileNames ) ) {
			/**
			 * @var $fileName LocalFile
			 * @var $title Title
			 */
			foreach ( $fileNames as $fileName ) {
				if(!($fileName instanceof LocalFile)) {
					$title = Title::newFromText( $fileName, NS_FILE );
				} else {
					$img = $fileName;
					$title = $img->getTitle();
				}
			}

			// do not query for page_id = 0
			if ( $title->exists() ) {
				$imagesIds[ $title->getArticleId() ] = $title->getDBkey();
				$this->articles[ $title->getArticleId() ] = $title->getArticleId();
			}
		}

		$out = $this->getImages(1);

		$ret = array();
		foreach($imagesIds as $key => $value) {
			if(!empty($out[$key]) && count($out[$key]) > 0) {
				$ret[ $value ] = $out[$key][0];
			}
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * getUrl - generate url for cut images
	 *
	 * @access public
	 *
	 * @param string|File|GlobalFile $name dbkey of image or File object
	 * @param $width int
	 * @param $height int
	 *
	 * @return  string url for image
	 */
	public function getUrl( $name, $width = 1, $height = 1 ) {
		global $wgEnableVignette;

		wfProfileIn( __METHOD__ );

		if ( $name instanceof File || $name instanceof GlobalFile ) {
			$img = $name;
		} else {
			//TODO: Create files local cache of IS
			$file_title = Title::newFromText( $name, NS_FILE );
			$img = wfFindFile( $file_title  );
			if( empty( $img ) ) {
				wfProfileOut( __METHOD__ );
				return "";
			}
		}

		if (WikiaFileHelper::isVideoFile($img)) {
			$H = ( float )( ( $width ) * ( $this->proportion['h'] / $this->proportion['w'] ) );
			$this->tmpDeltaY = 0.5 - $H / $height / 2;
		}

		if ($wgEnableVignette) {
			$url = $this->getVignetteUrl($img, $width, $height);
		} else {
			$url = $this->getLegacyUrl($img, $width, $height);
		}

		return $url;
	}

	/**
	 * @param File|GlobalFile $image
	 * @param $width
	 * @param $height
	 * @return string
	 */
	private function getVignetteUrl(URLGeneratorInterface $image, $width, $height) {
		list($top, $right, $bottom, $left) = $this->getCutParams($width, $height);

		return $image->getUrlGenerator()
			->windowCrop()
			->width($this->width)
			->xOffset($left)
			->yOffset($top)
			->windowWidth($right - $left)
			->windowHeight($bottom - $top)
			->url();
	}

	/**
	 * @param File $img
	 * @param $width
	 * @param $height
	 * @return String
	 */
	private function getLegacyUrl($img, $width, $height) {
		$issvg = false;
		$mime = strtolower( $img->getMimeType() );
		if( $mime == 'image/svg+xml' || $mime == 'image/svg' ) {
			$issvg = true;
		}

		$sPrefix = '';
		if ( WikiaFileHelper::isVideoFile( $img ) ) {
			// videos has different thumbnail markup
			$sPrefix = 'v,000000,';
		}

		$url = wfReplaceImageServer( $img->getThumbUrl( $sPrefix . $this->getCut( $width, $height ) . "-" . $img->getName().($issvg ? ".png":"") ) );

		wfProfileOut( __METHOD__ );
		return $url;
	}

	/**
	 * getUrl - generate cut frame for Thumb
	 *
	 * @param $width int
	 * @param $height int
	 * @param $align string "center", "origin"
	 * @param $issvg bool
	 *
	 * @return string prefix for thumb image
	 */
	public function getCut( $width, $height, $align = "center", $issvg = false  ) {
		list($top, $right, $bottom, $left) = $this->getCutParams($width, $height, $align, $issvg);
		return "{$this->width}px-$left,$right,$top,$bottom";
	}

	private function getCutParams($width, $height, $align="center", $issvg=false) {
		//rescale of png always use width 512;
		if( $issvg ) {
			$height = round( ( 512 * $height) / $width );
			$width = 512;
		}

		// make sure these are numeric and nonzero (BugId:20644, BugId:25965)
		$width = max(1, intval($width));
		$height = max(1, intval($height));
		// in case we're missing some proportions, maintain the original aspect ratio
		if (empty($this->proportion['h']) && !empty($this->proportion['w'])) {
			$this->proportion['h'] = (float)$height * $this->proportion['w'] / $width;
		}
		if (empty($this->proportion['w']) && !empty($this->proportion['h'])) {
			$this->proportion['w'] = (float)$width * $this->proportion['h'] / $height;
		}

		$pHeight = round( ( $width ) * ( $this->proportion['h'] / $this->proportion['w'] ) );

		if( $pHeight >= $height ) {
			$pWidth =  round( $height * ( $this->proportion['w'] / $this->proportion['h'] ) );
			$top = 0;
			if ( $align == "center" ) {
				$left = round( $width / 2 - $pWidth / 2 );
				if ( $pHeight != $height ) {
					$left++;
				}
			} else if ( $align == "origin" ) {
				$left = 0;
			}
			$right = $left + $pWidth + 1;
			$bottom = $height;
		} else {
			if ( $align == "center" ) {
				$deltaY = isset( $this->tmpDeltaY ) ? $this->tmpDeltaY : $this->getDeltaY();
				unset( $this->tmpDeltaY );
				$deltaYpx = round( $height * $deltaY );
				$bottom = $pHeight + $deltaYpx;
				$top = $deltaYpx;
			} else if ( $align == "origin" ) {
				$bottom = $pHeight;
				$top = 0;
			}

			if( $bottom > $height ) {
				$bottom = $pHeight;
				$top = 0;
			}

			$left = 0;
			$right = $width;
		}

		return [$top, $right, $bottom, $left];
	}

	public function getDeltaY() {
		if (is_null($this->deltaY)) {
			$this->deltaY = ( $this->proportion['w'] / $this->proportion['h'] - 1 ) * 0.1;
		}
		return $this->deltaY;
	}

	public function setDeltaY( $iCenterPosition = 0 ){
		$this->deltaY = $iCenterPosition;
	}

	public function setArticleIds( $articleIds ) {
		if( is_array( $articleIds ) ) {
			foreach ( $articleIds as $article ) {
				$articleId = ( int ) $article;

				if ($articleId > 0) {
					$this->articles[$articleId] = $articleId;
				}
			}
		}
	}

	public function hasArticleIds( $articleIds ) {
		$containsArticleIds = array_diff( $articleIds, array_keys( $this->articles ) );
		return empty( $containsArticleIds );
	}
}
