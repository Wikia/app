<?php
/**
 * MV_LanguageEn.php
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 * 
 */
if ( !defined( 'MEDIAWIKI' ) )  die( 1 );


class MV_LanguageEn extends MV_Language {	

	var $m_Namespaces = array(
		MV_NS_STREAM			=> 'Stream',
		MV_NS_STREAM_TALK 	   	=> 'Stream_talk',
		MV_NS_SEQUENCE			=> 'Sequence',
		MV_NS_SEQUENCE_TALK		=> 'Sequence_talk',
		MV_NS_MVD	 			=> 'MVD',
	    MV_NS_MVD_TALK 			=> 'MVD_talk'
	);
}
?>