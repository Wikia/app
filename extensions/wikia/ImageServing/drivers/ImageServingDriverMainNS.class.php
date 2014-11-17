<?php
class ImageServingDriverMainNS extends ImageServingDriverBase {
	protected $queryLimit = 50;
	protected $maxCount = 10;

	/**
	 * @var array
	 *
	 * Minor MIME types of files that should not be returned by ImageServing
	 */
	private $mimeTypesBlacklist = [];

	function __construct($db, $imageServing, $proportion) {
		parent::__construct( $db, $imageServing, $proportion );

		wfProfileIn(__METHOD__);

		if ( $this->app->wg->ImageServingMaxReuseCount !== NULL ) {
			$this->maxCount = $this->app->wg->ImageServingMaxReuseCount;
		}

		// blacklist types that thumbnailer cannot generate thumbs for (BAC-770)
		$this->mimeTypesBlacklist = [
			'svg+xml',
			'svg'
		];

		if ( $this->app->wg->UseMimeMagicLite ) {
			// MimeMagicLite defines all the mMediaTypes in PHP that MimeMagic
			// defines in text files
			$mimeTypes = new MimeMagicLite();
		} else {
			$mimeTypes = new MimeMagic();
		}

		foreach ( ['AUDIO', 'VIDEO'] as $type ) {
			foreach($mimeTypes->mMediaTypes[$type] as $mime) {
				// parse mime type - "image/svg" -> "svg"
				list(, $mimeMinor) = explode('/', $mime);
				$this->mimeTypesBlacklist[] = $mimeMinor;
			}
		}

		$this->mimeTypesBlacklist = array_unique($this->mimeTypesBlacklist);

		wfDebug( sprintf( "%s: minor MIME types blacklist - %s\n", __CLASS__, join( ', ', $this->mimeTypesBlacklist ) ) );
		wfProfileOut(__METHOD__);
	}

	protected function getImagesFromDB($articles = array()) {
		wfProfileIn( __METHOD__ );

		$props = $this->getArticleProbs($articles, 2*$this->queryLimit);
		foreach($props as  $article => $prop) {
			foreach( $prop as $key => $image  ) {
				$this->addImagesList(  $image, $article, $key, $this->queryLimit );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	protected function getArticleProbs($articles, $limit) {
		wfProfileIn( __METHOD__ );

		$out = array();
		if ( !empty ( $articles ) && is_array( $articles) ) {
			$res = $this->db->select(
				array( 'page_wikia_props' ),
				array(
					'page_id',
					'props'
				),
				array(
					'page_id' => $articles,
					'propname' => 0
				),
				__METHOD__
			);


			/* build list of images to get info about it */
			while ($row =  $this->db->fetchRow( $res ) ) {
				$props = unserialize( $row['props'] );
				if ( is_array( $props ) ) {
					$out[$row['page_id']] = array_slice($props, 0, $limit);
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}

	protected function getImagesPopularity( $imageNames, $limit ) {
		global $wgContentNamespaces;

		wfProfileIn(__METHOD__);
		$result = [];

		$sqlCount = $limit + 1;
		$imageNames = array_values($imageNames);
		$count = count($imageNames);;
		$i = 0;

		$imageLinksTable = $this->db->tableName('imagelinks');
		$pageTable = $this->db->tableName('page');
		$redirectTable = $this->db->tableName('redirect');

		$contentNamespaces = implode(',', $wgContentNamespaces);

		while ( $i < $count ) {
			$batch = array_slice( $imageNames, $i, 100 );
			$i += 100;

			// get all possible redirects for a given image (BAC-589)
			$imageRedirectsMap = []; // from image -> to image
			$sql = [];
			foreach ( $batch as $imageName ) {
				$imageRedirectsMap[$imageName] = $imageName;
				$sql[] = "(SELECT page_title, rd_title FROM {$redirectTable} LEFT JOIN {$pageTable} ON page_id = rd_from WHERE rd_namespace = " . NS_FILE . " AND rd_title = {$this->db->addQuotes($imageName)} LIMIT 5)";
			}
			$sql = implode(' UNION ALL ',$sql);
			$batchResult = $this->db->query($sql, __METHOD__ . '::redirects');

			foreach($batchResult as $row) {
				wfDebug(__METHOD__ . ": redirect found - {$row->page_title} -> {$row->rd_title}\n");
				$imageRedirectsMap[ $row->page_title ] = $row->rd_title;
			}
			$batchResult->free();

			// get image usage
			$sql = [];
			$batchResponse = [];

			foreach ( $imageRedirectsMap as $fromImg => $toImg ) {
				// prepare the results array )see PLATFORM-358)
				$batchResponse[$toImg] = 0;

				$sql[] = "(SELECT {$this->db->addQuotes($toImg)} AS il_to FROM {$imageLinksTable} JOIN {$pageTable} on page.page_id = il_from WHERE il_to = {$this->db->addQuotes($fromImg)} AND page_namespace IN ({$contentNamespaces}) LIMIT {$sqlCount} )";
			}
			$sql = implode(' UNION ALL ',$sql);
			$batchResult = $this->db->query($sql, __METHOD__. '::imagelinks');

			// do a "group by" on PHP side
			foreach ($batchResult as $row) {
				$batchResponse[$row->il_to]++;
			}
			$batchResult->free();

			// remove rows that exceed usage limit
			foreach ($batchResponse as $k => $imageCount) {
				if ( $imageCount > $limit ) {
					wfDebug(__METHOD__ . ": filtered out {$k} - used {$imageCount} time(s)\n");
					unset($batchResponse[$k]);
				}
				else {
					wfDebug(__METHOD__ . ": {$k} - used {$imageCount} time(s)\n");
				}
			}

			$result = array_merge( $result, $batchResponse );
		}
		wfProfileOut(__METHOD__);
		return $result;
	}

	protected function filterImages( $imagesList = array() ) {
		wfProfileIn( __METHOD__ );

		if ( empty( $imagesList ) ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		$imageNames = array_keys($imagesList);
		$imageRefs = array();
		$imageData = array();

		// filter out images that are too widely used
		if ( !empty($imageNames) ) {
			$imageRefs = $this->getImagesPopularity($imageNames,$this->maxCount);
		}

		// collect metadata about images
		if ( !empty($imageRefs) ) {
			$result = $this->db->select(
				array( 'image' ),
				array( 'img_name', 'img_height', 'img_width', 'img_minor_mime' ),
				array(
					'img_name' => array_keys($imageRefs),
				),
				__METHOD__
			);

			foreach ($result as $row) {
				if ( $row->img_height >= $this->minHeight && $row->img_width >= $this->minWidth ) {
					if ( !in_array( $row->img_minor_mime, $this->mimeTypesBlacklist ) ) {
						$imageData[$row->img_name] = $row;
					}
					else {
						wfDebug(__METHOD__ . ": {$row->img_name} - filtered out because of {$row->img_minor_mime} minor MIME type\n");
					}
				}
			}
			$result->free();
		}

		// finally record all the information gathered in previous steps
		if ( !empty($imageData) ) {
			foreach ($imageNames as $imageName) {
				if ( isset($imageRefs[$imageName]) && isset($imageData[$imageName] ) ) {
					$row = $imageData[$imageName];
					$this->addToFiltredList( $row->img_name, $imageRefs[$imageName],
						$row->img_width, $row->img_height, $row->img_minor_mime);

				}
			}
		}

		wfProfileOut( __METHOD__ );
	}

}
