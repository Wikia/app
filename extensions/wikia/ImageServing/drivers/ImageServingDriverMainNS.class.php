<?php 
class ImageServingDriverMainNS extends ImageServingDriverBase {
	protected $queryLimit = 50;
	protected $maxCount = 10;
	protected $minSize = 75;
	
	protected function getImagesFromDB($articles = array()) {
		$props = $this->getArticleProbs($articles, 2*$this->queryLimit);
		foreach($props as  $article => $prop) {
			foreach( $prop as $key => $image  ) {
				$this->addImagesList(  $image, $article, $key, $this->queryLimit );
			}
		}
	}
	
	protected function getArticleProbs($articles, $limit) {
		$res = $this->db->select(
			array( 'page_wikia_props' ),
			array(
				'page_id',
				'props'
			),
			array(
				'page_id in(' . implode( ",", $articles ) . ')',
				"propname = 'imageOrder' or propname =  0"
			),
			__METHOD__
		);

		$out = array();
		/* build list of images to get info about it */
		while ($row =  $this->db->fetchRow( $res ) ) {
			$props = unserialize( $row['props'] );
			if ( is_array( $props ) ) {
				$out[$row['page_id']] = array_slice($props, 0, $limit);
			}
		}
		return $out;
	}
	
	protected function filterImages($imagesList = array()) {
		# get image names from imagelinks table		
		$imagesName = array_keys($imagesList);
		if ( !empty($imagesName) ) {
			foreach ( $imagesName as $img_name ) {
				$result = $this->db->select(
					array( 'imagelinks' ),
					array( 'il_from' ),
					array(
						'il_to' => $img_name
					),
					__METHOD__,
					array ('LIMIT' => ($this->maxCount + 1))
				);

				# skip images which are too popular
				if ($result->numRows() > $this->maxCount ) continue;
				# check image table
				$oRowImg = $this->db->selectRow(
					array( 'image' ),
					array( 'img_name', 'img_height', 'img_width', 'img_minor_mime' ),
					array(
						'img_name' => $img_name
					),
					__METHOD__
				);

				if ( empty ( $oRowImg ) ) {
					continue;
				}

				if ( $oRowImg->img_height > $this->minSize && $oRowImg->img_width > $this->minSize ) {
					if ( !in_array( $oRowImg->img_minor_mime, array( "svg+xml","svg") ) ) {
						$this->addToFiltredList( $oRowImg->img_name, $result->numRows(), $oRowImg->img_width, $oRowImg->img_height, $oRowImg->img_minor_mime);
					}
				}
			}
		}
	}
}
