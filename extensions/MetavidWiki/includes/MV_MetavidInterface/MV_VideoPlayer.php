<?php
/*
 * Created on Jun 28, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 */
 /*
  * stores all the html for the video player and its associated ajax functions
  */
if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 class MV_VideoPlayer extends MV_Component {
 	var $name = 'MV_VideoPlayer';
 	var $embed_id = 'embed_vid';
 	function getHTML() {
 		global $wgOut;
 		if ( $this->getReqStreamName() != null ) {
 			$wgOut->addHTML( $this->embed_html() );
 			// add link helpers
 			$wgOut->addHTML( $this->link_helpers_html() );
 		} else {
 			$wgOut->addHTML( 'no stream selected' );
 		}
	}
	function link_helpers_html() {
		global $wgUser;
		$o = '';
		$sk = & $wgUser->getSkin();
		$mvTitle = & $this->mv_interface->article->mvTitle;
		$file_list = $mvTitle->mvStream->getFileList();
		$o .= '<div id="videoMeta">
				<p class="options">';
		// get file list: 
		global $mvDefaultVideoQualityKey, $mvDefaultFlashQualityKey;
		if ( count( $file_list ) != 0 ) {
			$coma = '';
			/*$o.='<span class="download">Download Segment:';
			$ogg_stream_url = $mvTitle->getWebStreamURL($mvDefaultVideoQualityKey);
			if($ogg_stream_url!=''){	
				$o.=$coma.' <a href="'.htmlspecialchars($ogg_stream_url).'">
					Web Ogg
				</a>';
				$coma=', ';
			}
			$ogg_hq_url = $mvTitle->getWebStreamURL('mv_ogg_high_quality');
			if($ogg_hq_url!=''){	
				$o.=$coma.' <a href="'.htmlspecialchars($ogg_hq_url).'">
					High Quality Ogg
				</a>';
				$coma=', ';
			}
			$flash_stream_url = $mvTitle->getWebStreamURL($mvDefaultFlashQualityKey);
			if($flash_stream_url!=''){		
				$o.=$coma.' <a href="'.htmlspecialchars($flash_stream_url).'">
					Flash Video
				</a>';	
				$coma=', ';
			}
			$o.='</span>';*/
			$o .= '<span class="download"><a href="javascript:$j(\'#' . htmlspecialchars( $this->embed_id ) . '\').get(0).showVideoDownload()">Download Options</a></span>';
		}
		$o .= '<span class="embed"><a href="javascript:$j(\'#' . htmlspecialchars( $this->embed_id ) . '\').get(0).showEmbedCode();">Embed Video</a></span>' .
				'</p>';
		// about file: 
		$talkPage = Title::newFromText( 'Anno_en:' . strtolower( $mvTitle->wiki_title ), MV_NS_MVD_TALK );
		$o .= '<p class="about_file">
					<span class="views">Views:' . htmlspecialchars( number_format( $mvTitle->getViewCount() ) ) . '</span>
					<span class="duration">Duration: ' . htmlspecialchars( $mvTitle->getSegmentDurationNTP() ) . '</span>
					<span class="comments">' . $sk->makeKnownLinkObj( $talkPage, wfMsg( 'talk' ) ) . '</span>
				</p>
			</div>';
		return $o;
	}
	function embed_html() {
		global $mvDefaultVideoPlaybackRes;
		$out = '';
		// give the stream the request information:
		$mvTitle = & $this->mv_interface->article->mvTitle;
		
		$mvTitle->dispVideoPlayerTime = true;
		$vid_size = ( isset( $this->mv_interface->smwProperties['playback_resolution'] ) ) ?
					$this->mv_interface->smwProperties['playback_resolution']:$mvDefaultVideoPlaybackRes;
		list( $width, $height ) = explode( 'x', $vid_size );
		// wrap the video container to prevent moving html on the page:			
		return '<div style="display:block;width:' . $width . 'px;height:' . $height . 'px">' .
					$mvTitle->getEmbedVideoHtml( array( 'id'=>$this->embed_id, 'size'=>$vid_size ) ) .
			'</div>';
	}
	function render_menu() {
		return 'embed video';
	}
	function getStyleOverride() {
		if ( $this->mv_interface->smwProperties['playback_resolution'] != null ) {
			@list( $width, $height ) = explode( 'x', $this->mv_interface->smwProperties['playback_resolution'] );
			if ( isset( $width ) && isset( $height ) ) {
				if ( is_numeric( $width ) && is_numeric( $height ) ) {
					// offset info should stored somewhere: 
					$width += 2;
					$height += 30;
					return "style=\"height:{$height}px;width:{$width}\"";
				}
			}
		}
		return '';
	}
	function render_full() {
		global $wgOut;
 		// "<div >" . 		 		
 		$wgOut->addHTML( "<div id=\"videoContent\">\n" );
 		// do the implemented html 
 		$this->getHTML();
 		$wgOut->addHTML( "</div>\n" );
	}
	
 }
?>
