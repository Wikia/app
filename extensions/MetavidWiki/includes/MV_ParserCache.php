<?php
/*
 * MV_ParserCache.php Created on Feb 27, 2008
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
 //quick hack to shift namespace of inline metavid parse cache 
 //avoids conflicts of inline display with full article display
 class MV_ParserCache extends ParserCache{
 	var $extraKeyOpt='mv';
 	var $addToKey ='';
 	public static function & singleton() {
		static $instance;
		if ( !isset( $instance ) ) {
			global $parserMemc;
			$instance = new MV_ParserCache( $parserMemc );
		}
		//reset addToKey
		$instance->addToKey='';
		return $instance;
	} 	
	function addToKey($opt){
		$this->addToKey=$opt;
	}
 	function getKey( &$article, &$user ) { 	
 		return parent::getKey( $article, $user ).$this->extraKeyOpt.$this->addToKey;
 	}
 }
?>
