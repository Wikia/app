<?php 
/* 
 * Author: Tomek Odrobny
 * it use adapter to easy switch from memCached to other engine 
 * 
 */

class HomePageMemAdapter{ 	
	public static function setMemValue($key,$value,$time = 0){
		global $wgMemc;
		$wgMemc->set( $key,$value ,$time );	
	}

	public static function getMemValue($key){
		global $wgMemc;
		return $wgMemc->get( $key );	
	}
	
	public static function incMemValue($key,$value,$time = null){
		
	}
}
?>