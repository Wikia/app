<?php
class ImageServingDriverMainNS extends ImageServingDriverBase {
	protected $queryLimit = 50;
	protected $maxCount = 10;
	protected $minSize = 75;

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
		$result = array();

		$sqlCount = $limit + 1;
		$imageNames = array_values($imageNames);
		$count = count($imageNames);;
		$i = 0;
		$imageLinksTable = $this->db->tableName('imagelinks');
		while ( $i < $count ) {
			$batch = array_slice( $imageNames, $i, 100 );
			$i += 100;
			$sql = array();
			foreach ( $batch as $imageName ) {
				$sql[] = "(select il_to from {$imageLinksTable} where il_to = {$this->db->addQuotes($imageName)} limit {$sqlCount} )";
			}
			$sql = implode(' UNION ALL ',$sql);
			$batchResult = $this->db->query($sql);

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
					unset($batchResponse[$k]);
				}
			}

			$result = array_merge( $result, $batchResponse );
		}
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
				if ( $row->img_height > $this->minSize && $row->img_width > $this->minSize ) {
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
