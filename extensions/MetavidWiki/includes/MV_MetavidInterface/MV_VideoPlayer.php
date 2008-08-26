<?php
/*
 * Created on Jun 28, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 */
 /*
  * stores all the html for the video player and its associated ajax functions
  */
  if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 class MV_VideoPlayer extends MV_Component{
 	var $name = 'MV_VideoPlayer';  	 	 	
 	function getHTML(){
 		global $wgOut; 	
 		if($this->getReqStreamName()!=null){
 			$wgOut->addHTML($this->embed_html());
 		}else{
 			$wgOut->addHTML('no stream selected');
 		}
	}
	function embed_html(){		
		global $mvDefaultVideoPlaybackRes;
		$out='';
		//give the stream the request information:
		$mvTitle= & $this->mv_interface->article->mvTitle;
		
		$mvTitle->dispVideoPlayerTime=true;			
		$vid_size = (isset($this->mv_interface->smwProperties['playback_resolution']))?
					$this->mv_interface->smwProperties['playback_resolution']:'';		
		return $mvTitle->getEmbedVideoHtml('embed_vid', $vid_size);
	}
	function render_menu(){
		return 'embed video';
	}
	function getStyleOverride(){
		if($this->mv_interface->smwProperties['playback_resolution']!=null){			
			@list($width,$height) = explode('x', $this->mv_interface->smwProperties['playback_resolution']);
			if(isset($width) && isset($height)){
				if(is_numeric($width) && is_numeric($height)){
					//offset info should stored somewhere: 
					$width+=2;
					$height+=30;
					return "style=\"height:{$height}px;width:{$width}\"";
				}	
			}
		}
		return '';
	}
	
 }
?>
