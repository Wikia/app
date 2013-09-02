<?php
class ImageServingDriverMainNS extends ImageServingDriverBase {
	protected $queryLimit = 50;
	protected $maxCount = 10;

	function __construct($db, $imageServing, $proportion) {
		parent::__construct( $db, $imageServing, $proportion );
		if ( $this->app->wg->ImageServingMaxReuseCount !== NULL ) {
			$this->maxCount = $this->app->wg->ImageServingMaxReuseCount;
		}
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
		wfProfileIn(__METHOD__);
		$result = array();

		$sqlCount = $limit + 1;
		$imageNames = array_values($imageNames);
		$count = count($imageNames);;
		$i = 0;

		$imageLinksTable = $this->db->tableName('imagelinks');
		$pageTable = $this->db->tableName('page');
		$redirectTable = $this->db->tableName('redirect');

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
			foreach ( $imageRedirectsMap as $fromImg => $toImg ) {
				$sql[] = "(SELECT {$this->db->addQuotes($toImg)} AS il_to FROM {$imageLinksTable} WHERE il_to = {$this->db->addQuotes($fromImg)} LIMIT {$sqlCount} )";
			}
			$sql = implode(' UNION ALL ',$sql);
			$batchResult = $this->db->query($sql, __METHOD__. '::imagelinks');

			// do a "group by" on PHP side
			$batchResponse = array();
			foreach ($batchResult as $row) {
				if ( !isset($batchResponse[$row->il_to]) ) {
					$batchResponse[$row->il_to] = 1;
				} else {
					$batchResponse[$row->il_to]++;
				}
			}
			$batchResult->free();

			// remove rows that exceed usage limit
			foreach ($batchResponse as $k => $imageCount) {
				if ( $imageCount > $limit ) {
					wfDebug(__METHOD__ . ": filtered out {$k} (used {$imageCount} times)\n");
					unset($batchResponse[$k]);
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
					if ( !in_array( $row->img_minor_mime, array( "svg+xml","svg") ) ) {
						$imageData[$row->img_name] = $row;
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
