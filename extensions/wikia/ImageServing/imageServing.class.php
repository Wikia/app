<?php
/*
 * Author: Tomek Odrobny
 * Class to serving list of top 5 images for article
 */
class imageServing{
	private $maxCount = 20;
	private $minSize = 100;
	private $articles;
	private $width;
	private $proportion;
	
	/**
	 * @param $articles \type{\arrayof{\int}} List of articles ids to get images
	 * @param $articles \type{\arrayof{\int}} List of articles ids to get images
	 * @param $width \int image width
	 * @param $width \int 
	 */ 
	function __construct($articles, $width = 100, $proportion = array("w" => 1, "h" => 1)){
		$this->articles = $articles;
		$this->width = $width;
		$this->proportion = $proportion;
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
		wfProfileIn(__METHOD__);
		$db = wfGetDB(DB_MASTER, array());
		$res = $db->select(
	            array( 'page_wikia_props' ),
	            array(	'page_id', 
	            		'props'
	            	 ),
	            array(		
					'page_id in('.implode(",", $this->articles).')',
					'propname' => "imageOrder"),
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
		
		$res = $db->select(
	            array( 'imagelinks LEFT JOIN image on il_to = img_name ' ),
	            array(	'count(*) cnt', 
	            		'il_to',
	            		'img_width',
	            		'img_height'
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
				$db_out[$row['il_to']] = $row;
		}
		
		$out = array();

		foreach( $image_list as $key => $value  ) {
			if( isset($db_out[ $key ]) ) {
				foreach($value as $key2 => $value2) {
					if (count($out[$key2]) < $n) {
						$out[$key2][] = array(
							"name" => $key,
							"url" => "http://blblbla");
					}
				}
			}
		}
		wfProfileOut(__METHOD__);		
		return $out;
	}
	
	/**
	 * getUrl - generate url for cut images
	 *
	 * @access public
	 * 
	 * @param $name \string dbkey of image  
	 * @param $width \int dbkey of image   
	 * @param $height \int dbkey of image  
	 *  
	 * @return  \string url for image
	 */
	
	public private function getUrl($name, $width, $height) {
		
	}
}