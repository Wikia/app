<?php
/*
 * Author: Tomek Odrobny
 * Class to serving list of top 5 images for article
 */
class imageServing{
	private $maxCount = 20;
	private $minSize = 75;
	private $articles = array();
	private $width;
	private $proportion;
	private $deltaY = 0;
	private $db;

	/**
	 * @param $articles \type{\arrayof{\int}} List of articles ids to get images
	 * @param $articles \type{\arrayof{\int}} List of articles ids to get images
	 * @param $width \int image width
	 * @param $width \int
	 */
	function __construct($articles = null, $width = 100, $proportion = array("w" => 1, "h" => 1), $db = null){

		if( is_array( $articles ) ) {
			foreach($articles as $article){
				$article_id = ( int ) $article;
				$title = Title::newFromID( $article_id );
				$this->articles[] = $article_id;
			}
		}
		
		$this->width = $width;
		$this->proportion = $proportion;
		$this->deltaY = (round($proportion['w']/$proportion['h']) - 1)*0.1;
		$this->db = $db;
	}

	/**
	 * getImages - get array with list of top images for all article pass to construct
	 *
	 * @author Tomek Odrobny
	 * 
	 * @access public
	 *
	 * @param $n \type{\arrayof{\int}} number of images get of each of article
	 * @param $article_lp \int lp number of article pass to construct for 0 get all
	 *
	 * @return  \type{\arrayof{\topImage}}
	 */

	public function getImages( $n = 5, $article_lp = 0 ) {
		global $wgMemc;
		
		wfProfileIn( __METHOD__ );

		$out = array();
		$articles = $this->articles;
		
		if( !empty( $articles ) ) {
			$cache_return = array();

			foreach ( $articles as $key => $value ) {
				$mcOut = $wgMemc->get( $this->_makeKey( $value, $n ), null );

				if($mcOut != null) {
					unset( $articles[ $key ] );
					$cache_return[ $value ] = $mcOut;
				}
			}

			if( count( $articles ) < 1 ) {
				return $cache_return;
			}

			if( $this->db == null ) {
				$db = wfGetDB( DB_SLAVE, array() );
			} else {
				$db = $this->db;
			}

			$image_list = array();
			$images_name = array();

			$res = $db->select(
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



			/* build list of images to get info about it */
			while ($row =  $db->fetchRow( $res ) ) {
				$props = unserialize( $row['props'] );
				foreach( $props as $key => $value ) {
					if( empty($image_list[$value][$row['page_id']]) ) {
						if( empty($image_list[$value]) ) {
							$images_name[] = $db->addQuotes( $value );
						}
						$image_list[$value][$row['page_id']] = $key;
					}
				}
			}

			if ( count( $image_list ) == 0 ) {
				wfProfileOut( __METHOD__ );
				return $cache_return;
			}

			$res = $db->select(
			    array( 'imagelinks LEFT JOIN image on il_to = img_name ' ),
			    array(	'count(*) cnt',
					'il_to',
					'img_width',
					'img_height',
					'img_minor_mime'
				 ),
					array(),
				__METHOD__,
			    array(
				"GROUP BY" => "il_to",
				"HAVING" => implode(' and ',array(
						"il_to in(".implode( ",", $images_name ).")",
						"cnt < ".$this->maxCount,
						"img_height > ".$this->minSize,
						"img_width > ".$this->minSize
					))
			    )
			);

			$db_out = array();

			while ($row =  $db->fetchRow( $res ) ) {
				if(!in_array($row['img_minor_mime'], array( "svg+xml","svg"))) {
					$db_out[$row['il_to']] = $row;
				}
			}

			if (count($db_out) == 0) {
				wfProfileOut(__METHOD__);
				return $cache_return;
			}

			foreach( $image_list as $key => $value  ) {
				if( isset($db_out[ $key ]) ) {
					foreach($value as $key2 => $value2) {
						if (empty($out[$key2]) || count($out[$key2]) < $n) {
							$out[$key2][] = array(
								"name" => $key,
								"url" => $this->getUrl($key, $db_out[$key]['img_width'], $db_out[$key]['img_height']));
						}
					}
				}
			}

			foreach ($out as $key => $value) {
				$wgMemc->set( $this->_makeKey( $key, $n ), $value, 60*60 );
			}

			wfProfileOut(__METHOD__);
			return $out + $cache_return;
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 *  fetches an array with thumbnails and titles for the supplied files
	 *
	 * @author Federico "Lox" Lucignano
	 *
	 * @param Array $fileNames a list of file names to fetch thumbnails for
	 * @return Array an array containing the url to the thumbnail image and the title associated to the file
	 */
	public function getThumbnails( $fileNames = null ) {
		wfProfileIn( __METHOD__ );

		global $wgMemc;
		$ret = array();
		
		if( !empty( $fileNames ) ) {
			foreach ( $fileNames as $fileName ) {
				$title = Title::newFromText( $fileName, NS_FILE );
				$mcKey = $this->_makeKey( uniqid('asd') );
				$mcOut = $wgMemc->get( $mcKey, null );
				
				if( $mcOut != null ) {
					$ret[ $fileName ] = $mcOut;
				} elseif ( $img = wfFindFile( $title ) ) {
					$imageInfo = getimagesize( $img->getPath() );
					
					$ret[ $fileName ] =  array(
						'name' => $title->getText(),
						'url' => wfReplaceImageServer( $img->getThumbUrl( $this->getCut( $imageInfo[ 0 ], $imageInfo[ 1 ]) . "-" . $img->getName() ) )
					);

					$wgMemc->set( $mcKey, $ret[ $fileName ], 60*60 );
				}
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
	 * @param $name \string dbkey of image
	 * @param $width \int
	 * @param $height \int
	 *
	 * @return  \string url for image
	 */

	private function getUrl( $name, $width = 0, $height = 0 ) {
		$file_title = Title::newFromText( $name ,NS_FILE );
		$img = wfFindFile( $file_title  );

		if( $img == null ) {
			return "";
		}
		
		return wfReplaceImageServer( $img->getThumbUrl( $this->getCut( $width, $height ) . "-" . $img->getName() ) );
	}

	/**
	 * Generates a memcache key based on the supplied value
	 *
	 * @author Federico "Lox" Lucignano
	 */
	private function _makeKey( $key, $n = 1 ) {
		return wfMemcKey("imageserving", $this->width, $n, $this->proportion["w"], $this->proportion["h"], $key);
	}

	/**
	 * getUrl - generate cut frame for  Thumb
	 *
	 * @param $width \int
	 * @param $height \int
	 * @param $align \string "center", "origin"
	 *
	 *
	 * @return \string prefix for thumb image
	 */

	public function getCut( $width, $height, $align = "center" ) {
		$pHeight = round(($width)*($this->proportion['h']/$this->proportion['w']));

		if($pHeight >= $height) {
			$pWidth =  round($height*($this->proportion['w']/$this->proportion['h']));
			$top = 0;
			if ($align == "center") {
				$left = round($width/2 - $pWidth/2) + 1;
			} else if ($align == "origin") {
				$left = 0;
			}
			$right = $left + $pWidth + 1;
			$bottom = $height;
		} else {

			if ($align == "center") {
				$deltaYpx = round($height*$this->deltaY);
				$bottom = $pHeight + $deltaYpx;
				$top = $deltaYpx;
			} else if ($align == "origin") {
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
		return "{$this->width}px-$left,$right,$top,$bottom";
	}
}
