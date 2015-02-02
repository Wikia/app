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
				foreach ( $mimeTypes->mMediaTypes[$type] as $mime ) {
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

	protected function loadImagesFromDb( $articleIds = array() ) {
		wfProfileIn( __METHOD__ );

		$articleImageIndex = $this->getImageIndex( $articleIds, 2 * self::QUERY_LIMIT );
		foreach ( $articleImageIndex as $articleId => $imageIndex ) {
			foreach ( $imageIndex as $orderKey => $imageData ) {
				$this->addImage( $imageData, $articleId, $orderKey, self::QUERY_LIMIT );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	protected function getImageIndex( $articleIds, $limitPerArticle ) {
		wfProfileIn( __METHOD__ );

		$out = array();
		if ( !empty ( $articleIds ) && is_array( $articleIds ) ) {
			$res = $this->db->select(
				array( 'page_wikia_props' ),
				array(
					'page_id',
					'props'
				),
				array(
					'page_id' => $articleIds,
					'propname' => WPP_IMAGE_SERVING
				),
				__METHOD__
			);


			/* build list of images to get info about it */
			while ( $row = $this->db->fetchRow( $res ) ) {
				$imageIndex = unserialize( $row['props'] );
				if ( is_array( $imageIndex ) ) {
					$out[$row['page_id']] = array_slice( $imageIndex, 0, $limitPerArticle );
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
	protected function loadImageDetails( $imageNames = array() ) {
		wfProfileIn( __METHOD__ );

		if ( empty( $imageNames ) ) {
			wfProfileOut( __METHOD__ );

			return;
		}

		$imagePopularity = array();
		$imageDetails = array();

		// filter out images that are too widely used
		if ( !empty( $imageNames ) ) {
			$imagePopularity = $this->getImagesPopularity( $imageNames, $this->maximumPopularity );
			$imageNames = array_keys( $imagePopularity );
		}

		// collect metadata about images
		if ( !empty( $imageNames ) ) {
			$result = $this->db->select(
				array( 'image' ),
				array( 'img_name', 'img_height', 'img_width', 'img_minor_mime' ),
				array(
					'img_name' => $imageNames,
				),
				__METHOD__
			);

			foreach ( $result as $row ) {
				if ( $row->img_height >= $this->minHeight && $row->img_width >= $this->minWidth ) {
					if ( !in_array( $row->img_minor_mime, self::$mimeTypesBlacklist ) ) {
						$imageDetails[$row->img_name] = $row;
					} else {
						wfDebug( __METHOD__ . ": {$row->img_name} - filtered out because of {$row->img_minor_mime} minor MIME type\n" );
					}
				}
			}
			$result->free();
			$imageNames = array_keys( $imageDetails );
		}

		// finally record all the information gathered in previous steps
		foreach ( $imageNames as $imageName ) {
			$row = $imageDetails[$imageName];
			$this->addImageDetails( $row->img_name, $imagePopularity[$imageName],
				$row->img_width, $row->img_height, $row->img_minor_mime );
		}

		wfProfileOut( __METHOD__ );
	}

	protected function getImagesPopularity( $imageNames, $limit ) {
		global $wgContentNamespaces;

		wfProfileIn( __METHOD__ );
		$result = [ ];

		$sqlCount = $limit + 1;
		$imageNames = array_values( $imageNames );
		$count = count( $imageNames );;
		$i = 0;

		$imageLinksTable = $this->db->tableName( 'imagelinks' );
		$pageTable = $this->db->tableName( 'page' );
		$redirectTable = $this->db->tableName( 'redirect' );

		$contentNamespaces = implode( ',', $wgContentNamespaces );

		while ( $i < $count ) {
			$batch = array_slice( $imageNames, $i, 100 );
			$i += 100;

			// get all possible redirects for a given image (BAC-589)
			$imageRedirectsMap = [ ]; // from image -> to image
			$sql = [ ];
			foreach ( $batch as $imageName ) {
				$imageRedirectsMap[$imageName] = $imageName;
				$sql[] = "(SELECT page_title, rd_title FROM {$redirectTable} LEFT JOIN {$pageTable} ON page_id = rd_from WHERE rd_namespace = " . NS_FILE . " AND rd_title = {$this->db->addQuotes( $imageName )} LIMIT 5)";
			}
			$sql = implode( ' UNION ALL ', $sql );
			$batchResult = $this->db->query( $sql, __METHOD__ . '::redirects' );

			foreach ( $batchResult as $row ) {
				wfDebug( __METHOD__ . ": redirect found - {$row->page_title} -> {$row->rd_title}\n" );
				$imageRedirectsMap[$row->page_title] = $row->rd_title;
			}
			$batchResult->free();

			// get image usage
			$sql = [ ];
			$batchResponse = [ ];

			foreach ( $imageRedirectsMap as $fromImg => $toImg ) {
				// prepare the results array )see PLATFORM-358)
				$batchResponse[$toImg] = 0;

				$sql[] = "(SELECT {$this->db->addQuotes( $toImg )} AS il_to FROM {$imageLinksTable} JOIN {$pageTable} on page.page_id = il_from WHERE il_to = {$this->db->addQuotes( $fromImg )} AND page_namespace IN ({$contentNamespaces}) LIMIT {$sqlCount} )";
			}
			$sql = implode( ' UNION ALL ', $sql );
			$batchResult = $this->db->query( $sql, __METHOD__ . '::imagelinks' );

			// do a "group by" on PHP side
			foreach ( $batchResult as $row ) {
				$batchResponse[$row->il_to]++;
			}
			$batchResult->free();

			// remove rows that exceed usage limit
			foreach ( $batchResponse as $k => $imageCount ) {
				if ( $imageCount > $limit ) {
					wfDebug( __METHOD__ . ": filtered out {$k} - used {$imageCount} time(s)\n" );
					unset( $batchResponse[$k] );
				} else {
					wfDebug( __METHOD__ . ": {$k} - used {$imageCount} time(s)\n" );
				}
			}

			$result = array_merge( $result, $batchResponse );
		}
		wfProfileOut( __METHOD__ );

		return $result;
	}

}
