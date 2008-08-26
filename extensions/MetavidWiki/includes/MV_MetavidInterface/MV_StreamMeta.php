<?php
/*
 * MV_StreamMeta.php Created on Sep 27, 2007
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
 class MV_StreamMeta extends MV_Component{
 	function getHTML(){
 		global $wgOut;
 		$wgOut->addHTML('<div style="overflow:auto" id="mv_stream_cont">');
 		//$mv_interface->
 		$wgOut->addHTML('<b>test</b>');
		$wgOut->addHTML('</div>');
	}
 }
?>
