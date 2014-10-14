<?php 
/* 
 * Author: Tomek Odrobny
 * it use adapter to easy switch from memCached to other engine 
 * 
 */

class HomePageMemAdapter{ 	
	public static function setMemValue($key,$value,$time = 0){
		global $wgTTCache;
		$wgTTCache->set( $key,$value ,$time );	
	}

	public static function getMemValue($key){
		global $wgTTCache;
		return $wgTTCache->get( $key );	
	}
	
	public static function incMemValue($key,$value,$time = null){
		
	}
}
