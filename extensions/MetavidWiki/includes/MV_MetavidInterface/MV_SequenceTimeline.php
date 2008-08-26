<?php
/*
 * MV_SequenceTimeline.php Created on Nov 2, 2007
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
 
 class MV_SequenceTimeline extends MV_Component{
 	function render_menu(){		
		return wfMsg('mv_sequence_timeline');		
	}
 }
?>
