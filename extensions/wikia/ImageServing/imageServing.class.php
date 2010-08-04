<?php
/*
 * Author: Tomek Odrobny
 * Class to serving list of top 5 images for article
 */
class imageServing{
	/**
	 * @param $articles \type{\arrayof{\int}} List of articles ids to get images
	 * @param $articles \type{\arrayof{\int}} List of articles ids to get images
	 * @param $width \int image width
	 * @param $width \int 
	 */ 
	function __construct($articles, $width, $proportion){
		
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
		
	}
}