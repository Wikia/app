<?php
/*
 * Author: Tomek Odrobny
 * Class to serving list of top 5 images for article
 */
class imageServing{
	private $maxCount = 20;
	private $minSize = 75;
	private $articles;
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
	function __construct($articles, $width = 100, $proportion = array("w" => 1, "h" => 1), $db = null){

		foreach($articles as $article){
			$this->articles[] = (integer)$article;
		}
		$this->width = $width;
		$this->proportion = $proportion;
		$this->deltaY = (round($proportion['w']/$proportion['h']) - 1)*0.1;
		$this->db = $db;
	}

	/**
	 * getImages - get array with list of top images for all article pass to construct
	 *
	 * @access public
	 *
	 * @param $n \type{\arrayof{\int}} number of images get of each of article
	 * @param $article_lp \int lp number of article pass to construct for 0 get all
	 *
	 * @return  \type{\arrayof{\topImage}}
	 */

	public function getImages($n = 5, $article_lp = 0) {
		global $wgMemc;
		$articles = $this->articles;
		wfProfileIn(__METHOD__);
		$cache_return = array();
		foreach($articles as $key => $value) {
			$mcKey = wfMemcKey("imageserving", $this->width, $n, $this->proportion["w"], $this->proportion["h"], $value);
			$mcOut = $wgMemc->get($mcKey, null);

			if($mcOut != null) {
				unset($articles[$key]);
				$cache_return[$value] = $mcOut;
			}
		}

		if(count($articles) < 1) {
			return $cache_return;
		}


		if($this->db == null) {
			$db = wfGetDB(DB_SLAVE, array());
		} else {
			$db = $this->db;
		}
		
		$res = $db->select(
	            array( 'page_wikia_props' ),
	            array(	'page_id',
	            		'props'
	            	 ),
	            array(
					'page_id in('.implode(",", $articles).')',
					"propname = 'imageOrder' or propname =  0"),
	            __METHOD__
		);

		$image_list = array();
		$images_name = array();

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

		if (count($image_list) == 0) {
			wfProfileOut(__METHOD__);
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

		$out = array();

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
			$mcKey = wfMemcKey("imageserving", $this->width, $n, $this->proportion["w"], $this->proportion["h"], $key);
			$wgMemc->set($mcKey, $value, 60*60);
		}

		wfProfileOut(__METHOD__);
		return $out + $cache_return;
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

	private function getUrl($name, $width = 0, $height = 0) {
		$file_title = Title::newFromText($name ,NS_FILE );
		$img = wfFindFile( $file_title  );
		if($img == null) {
			return "";
		}
		return wfReplaceImageServer($img->getThumbUrl( $this->getCut($width, $height)."-".$img->getName()));
	}

	/**
	 * getUrl - generate cut frame for  Thumb
	 *
	 * @param $width \int
	 * @param $height \int
	 *
	 *
	 * @return \string prefix for thumb image
	 */

	public function getCut($width, $height) {
		$pHeight = round(($width)*($this->proportion['h']/$this->proportion['w']));

		if($pHeight >= $height) {
			$pWidth =  round($height*($this->proportion['w']/$this->proportion['h']));
			$top = 0;
			$left = round($width/2 - $pWidth/2) + 1;
			$right = $left + $pWidth + 1;
			$bottom = $height;
		} else {
			$deltaYpx = round($height*$this->deltaY);

			$bottom = $pHeight + $deltaYpx;
			$top = $deltaYpx;

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
