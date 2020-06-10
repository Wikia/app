<?php

class ImageServingDriverMainNS extends ImageServingDriverBase {
	const QUERY_LIMIT = 50;
	/**
	 * @var array
	 *
	 * Minor MIME types of files that should not be returned by ImageServing
	 */
	static private $mimeTypesBlacklist = null;
	protected $maximumPopularity = 10;

	function __construct( $db, $imageServing ) {
		parent::__construct( $db, $imageServing );

		wfProfileIn( __METHOD__ );

		if ( $this->app->wg->ImageServingMaxReuseCount !== NULL ) {
			$this->maximumPopularity = $this->app->wg->ImageServingMaxReuseCount;
		}

		$this->buildMimeTypesBlacklist();

		wfProfileOut( __METHOD__ );
	}

	private function buildMimeTypesBlacklist() {
		if ( self::$mimeTypesBlacklist === null ) {
			wfProfileIn( __METHOD__ );
			$app = F::app();
			// blacklist types that thumbnailer cannot generate thumbs for (BAC-770)
			$mimeTypesBlacklist = [
				'svg+xml',
				'svg'
			];

			if ( $app->wg->UseMimeMagicLite ) {
				// MimeMagicLite defines all the mMediaTypes in PHP that MimeMagic
				// defines in text files
				$mimeTypes = new MimeMagicLite();
			} else {
				$mimeTypes = new MimeMagic();
			}

			foreach ( [ 'AUDIO', 'VIDEO' ] as $type ) {
				foreach ( $mimeTypes->mMediaTypes[ $type ] as $mime ) {
					// parse mime type - "image/svg" -> "svg"
					list( , $mimeMinor ) = explode( '/', $mime );
					$mimeTypesBlacklist[] = $mimeMinor;
				}
			}

			self::$mimeTypesBlacklist = array_unique( $mimeTypesBlacklist );
			wfDebug( sprintf( "%s: minor MIME types blacklist - %s\n", __CLASS__, join( ', ', self::$mimeTypesBlacklist ) ) );
			wfProfileOut( __METHOD__ );
		}
	}

	protected function loadImagesFromDb( $articleIds = [ ] ) {
		wfProfileIn( __METHOD__ );

		//load infobox images at start, set number of images from infoboxes
		$imageCount = $this->loadImagesFromInfoboxes( $articleIds );

		$articleImageIndex = $this->getImageIndex( $articleIds, 2 * self::QUERY_LIMIT );
		foreach ( $articleImageIndex as $articleId => $imageIndex ) {
			// make sure images are in correct order
			ksort( $imageIndex );
			foreach ( $imageIndex as $imageData ) {
				if ( $this->addImage( $imageData, $articleId, $imageCount, self::QUERY_LIMIT ) ) {
					// increment order count when new image added
					$imageCount++;
				}
			}
		}

		wfProfileOut( __METHOD__ );
	}

	protected function getImageIndex( $articleIds, $limitPerArticle ) {
		wfProfileIn( __METHOD__ );

		$out = [ ];
		if ( !empty ( $articleIds ) && is_array( $articleIds ) ) {
			$res = $this->db->select(
				[ 'page_wikia_props' ],
				[
					'page_id',
					'props'
				],
				[
					'page_id' => $articleIds,
					'propname' => WPP_IMAGE_SERVING
				],
				__METHOD__
			);


			/* build list of images to get info about it */
			while ( $row = $this->db->fetchRow( $res ) ) {
				$imageIndex = unserialize( $row[ 'props' ] );
				if ( is_array( $imageIndex ) ) {
					$out[ $row[ 'page_id' ] ] = array_slice( $imageIndex, 0, $limitPerArticle );
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $out;
	}

	/**
	 * Load image details. Skips images that does not meet the following criteria:
	 *  - image usage is relatively low in content namespaces (fewer than {$this->maxCount} links)
	 *  - image actually exists in DB
	 *
	 * @param array $imageNames
	 */
	protected function loadImageDetails( $imageNames = [ ] ) {
		wfProfileIn( __METHOD__ );

		if ( empty( $imageNames ) ) {
			wfProfileOut( __METHOD__ );

			return;
		}

		$imagePopularity = [ ];
		$imageDetails = [ ];

		// filter out images that are too widely used
		if ( !empty( $imageNames ) ) {
			$imagePopularity = $this->getImagesPopularity( $imageNames, $this->maximumPopularity );
			$imageNames = array_keys( $imagePopularity );
		}

		// collect metadata about images
		if ( !empty( $imageNames ) ) {
			$imageDetails = $this->loadImagesMetadata( $imageNames );

			// if query was terminated - return and abort the process
			if ( !$imageDetails ) {
				wfProfileOut( __METHOD__ );

				return;
			}
			$imageNames = array_keys( $imageDetails );
		}
		// finally record all the information gathered in previous steps
		foreach ( $imageNames as $imageName ) {
			$row = $imageDetails[ $imageName ];
			$this->addImageDetails( $row->img_name, $imagePopularity[ $imageName ],
				$row->img_width, $row->img_height, $row->img_minor_mime );
		}

		wfProfileOut( __METHOD__ );
	}

	protected function loadImagesMetadata( $images ) {
		$imageDetails = [ ];
		$result = $this->db->select(
			[ 'image' ],
			[ 'img_name', 'img_height', 'img_width', 'img_minor_mime' ],
			[
				'img_name' => $images,
			],
			__METHOD__
		);
		// if query was terminated - return and abort the process
		if ( !$result ) {

			return false;
		}

		foreach ( $result as $row ) {
			/* @var mixed $row */
			if ( $row->img_height >= $this->minHeight && $row->img_width >= $this->minWidth ) {
				if ( !in_array( $row->img_minor_mime, self::$mimeTypesBlacklist ) ) {
					$imageDetails[ $row->img_name ] = $row;
				} else {
					wfDebug( __METHOD__ . ": {$row->img_name} - filtered out because of {$row->img_minor_mime} minor MIME type\n" );
				}
			}
		}
		$result->free();

		return $imageDetails;
	}

	/**
	 * Returns the popularity of given set of images (popularity = the number of articles in content namespaces that
	 * use an image)
	 *
	 * $limit is applied - images that have popularity that is higher than $limit will not be returned
	 *
	 * Example:
	 *
	 * $imageNames = [ 'IMG_7303.jpg', 'Goats.jpg' ]
	 * Result: [ 'IMG_7303.jpg' => 1, 'Goats.jpg' => 2 ]
	 *
	 * @param string[] $imageNames
	 * @param int $limit
	 *
	 * @return array associative array [image name] => [popularity]
	 */
	protected function getImagesPopularity( Array $imageNames, $limit ) {
		wfProfileIn( __METHOD__ );

		$imageNames = array_values( $imageNames );

		// MostimagesInContentPage generates daily reports with images
		// that are included at least twice in article in content namespaces
		$ret = $this->db->select(
			'querycache',
			[ 'qc_title as image', 'qc_value as popularity' ],
			[
				'qc_type' => 'MostimagesInContent',
				'qc_title' => $imageNames,
			],
			__METHOD__
		);

		// MostimagesInContent includes images used at least twice
		// - make popularity default to one here
		// - update with the data from query cache
		$result = array_fill_keys( $imageNames, 1 );

		foreach ( $ret as $row ) {
			/* @var mixed $row */
			$popularity = intval( $row->popularity );

			if ( $popularity > $limit ) {
				unset( $result[ $row->image ] );
				wfDebug( __METHOD__ . ": filtered out {$row->image} - used {$popularity} time(s)\n" );
			} else {
				$result[ $row->image ] = $popularity;
			}
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	protected function loadImagesFromInfoboxes( $articleIds ) {
		wfProfileIn( __METHOD__ );
		$images = [ ];
		$imageCount = 0;
		foreach ( $articleIds as $id ) {
			$articleImages = $this->getInfoboxImagesForId( $id );
			foreach ( $articleImages as $image ) {
				$this->addImage( $image, $id, $imageCount++ );
			}
			$images = array_merge( $images, $articleImages );
		}

		if ( $images ) {
			$details = $this->loadImagesMetadata( $images );
			foreach ( $details as $name => $row ) {
				//set popularity to one, to trick image serving
				$this->addImageDetails( $row->img_name, '1', $row->img_width, $row->img_height, $row->img_minor_mime );
			}
		}

		wfProfileOut( __METHOD__ );

		return $imageCount;
	}

	protected function getInfoboxImagesForId( $id ) {
		$articles = $this->getArticles();

		if ( isset( $articles[$id] ) ) {
			// Avoid a redundant DB query for each article ID
			// by utilizing already loaded article data to build the title
			$row = (object)[
				'page_id' => $id,
				'page_namespace' => $articles[$id]['ns'],
				'page_title' => $articles[$id]['title'],
				'page_latest' => $articles[$id]['page_latest'],
			];

			$title = Title::newFromRow( $row );

			$articleImages = PortableInfoboxDataService::newFromTitle( $title )->getImages();

			return $articleImages;
		}

		return []; // page doesn't exist
	}
}
