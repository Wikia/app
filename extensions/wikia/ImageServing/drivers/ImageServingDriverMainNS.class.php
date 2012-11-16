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

	protected function filterImages($imagesList = array()) {
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
			$result = $this->db->select(
				array( 'imagelinks' ),
				array( 'il_to AS img_name', 'count(*) AS img_used_count' ),
				array(
					'il_to' => $imageNames,
				),
				__METHOD__,
				array(
					'GROUP BY' => 'il_to',
				)
			);
			foreach ($result as $row) {
				if ( $row->img_used_count <= $this->maxCount ) {
					$imageRefs[$row->img_name] = intval($row->img_used_count);
				}
			}
			$result->free();
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
