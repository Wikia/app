<?php
/*
 * MV_EditSequencePage.php Created on Dec 5, 2008
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 * @url kaltura.com
 */
class MV_EditSequencePage extends EditPage {
	function edit() {
 		global $wgOut, $wgUser, $wgHooks, $wgTitle;
 		
 		//add some user variables  		
 		$seqPlayer = new MV_SequencePlayer( $wgTitle );		
 		mvAddGlobalJSVariables( array( 'mvSeqExportUrl' => $seqPlayer->getExportUrl() ) );
 		//add the "switch" link to the top of the page 		
 		$wgOut->addHTML('<span id="swich_seq_links">
	 			<a id="swich_seq_text" style="display:none"
	 			    href="javascript:mv_do_sequence_edit_swap(\'text\')">'.
	 			    wfMsg('mv_sequence_edit_text') . 
	 			'</a>' . 		
	 			'<a id="switch_seq_wysiwyg" 
	 				href="javascript:mv_do_sequence_edit_swap(\'seq_update\')">' .
	 			  	wfMsg('mv_sequence_edit_visual_editor') .
	 			'</a>' . 
	 		'</span>'.
	 		'<div id="seq_edit_container" style="display:none;position:relative;width:100%;height:580px;background:#AAA"></div>'
		);
		$wgOut->addHTML('<div id="mv_text_edit_container"> ');
 		parent::edit(); 		
 		$wgOut->addHTML('</div>');
	}
}
