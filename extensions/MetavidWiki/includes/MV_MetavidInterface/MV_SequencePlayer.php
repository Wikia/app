<?php
/*
 * MV_SequencePlayer.php Created on Nov 2, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 // make sure the parent class mv_component is included

 class MV_SequencePlayer{
 	private $oldid='';
 	function __construct( &$seqTitle ){
 		$this->seqTitle = $seqTitle; 		
 	}
 	function getEmbedSeqHtml( $options=array() ){ 	
 		global $mvDefaultVideoPlaybackRes;
 		if( isset( $options['oldid'] ) ) 
 			$this->oldid  = $options['oldid'];			 										
		
		if ( isset( $options['size'] ) ){			
			list($width, $height) = explode( 'x', $options['size'] );
		}else{			
			list($width, $height) = explode( 'x', $mvDefaultVideoPlaybackRes);
		}		
		return '<playlist width="' . htmlspecialchars($width) . '" height="'. htmlspecialchars($height) .'" '.
					'src="' . $this->getExportUrl() . '"></playlist>';
 	}
 	function getExportUrl(){
 		$exportTitle = Title::MakeTitle( NS_SPECIAL, 'MvExportSequence/' . $this->seqTitle->getDBKey() );
 		$export_url = $exportTitle->getFullURL();
 		if($this->oldid!=''){
 			$ss = ( strpos( $export_url, '?' ) === false ) ? '?':'&';
			$export_url .= $ss . 'oldid=' . htmlspecialchars( $this->oldid );
 		}
 		return $export_url;
 	}
 }
?>
