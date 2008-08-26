<?php
/*
 * MV_SequencePlayer.php Created on Nov 2, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 //make sure the parent class mv_component is included
 
 class MV_SequencePlayer extends MV_Component{
 	function render_menu(){
		return wfMsg('mv_sequence_player_title');
	}
	function getHTML(){
 		global $wgOut, $wgTitle, $wgRequest;
 		$article = & $this->mv_interface->article; 		
 		$title = Title::MakeTitle(NS_SPECIAL, 'MvExportSequence/'.$article->mTitle->getDBKey() );
 		$title_url = $title->getFullURL();
 		
 		
 		$oldid = $wgRequest->getVal( 'oldid' );
		if ( isset( $oldid ) ) {	
 			//@@ugly hack .. but really this whole sequencer needs a serious rewrite)
			$ss = (strpos($title_url, '?')===false)?'?':'&';
			$title_url.=$ss.'oldid='.$oldid;
 		}
 		//'<playlist id="mv_pl">'.  
 		//@@todo look at mv_interface context to get what to display in tool box:
 		$wgOut->addHTML(''. 
	 		'<div style="position:absolute;width:320px;height:270px;" id="mv_video_container">'.
	 			//'<div style="display:none;" id="mv_inline_pl_txt">'.$article->getSequenceText().'</div>'.
	 			'<div style="display:none;" id="mv_pl_url">'.$title_url.'</div>'.
			'</div>' ."\n");
	}
 }
?>
