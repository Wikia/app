<?php
/*
 * OggChopRequestHanlder.php is a simple ogg video server for mediawiki
 * it uses the general oggChop class (which we should probably make part of
 * PEAR oggServer or something like that )
 *
 * it takes arguments http arguments:
 * file=WikiFileTitle.ogg
 * t=start_time_npt/end_time_npt
 *
 * if no filename.ogg.meta file is available it generates it.
 * (this can be slow its recommended you pre-generate the .meta files)
 *
 * * This is just a fallback solution / prototypeing for oggz_chop fastCGI.\
 * this will just server from the nearest keyframe
*/

//for now just hard code the request:
$oggPath = '/var/www/house_proceeding_01-04-07.ogg';
//$oggPath = '/var/www/lucky.ogv';
$time = '0:0:10/0:0:20';

require_once( 'OggChop.php' );

$ogg = new OggChop( $oggPath );
$ogg->play();
die();

/*utility functions*/
function npt2seconds( $str_time ) {
	$time_ary = explode( ':', $str_time );
	$hours = $min = $sec = 0;
	if ( count( $time_ary ) == 3 ) {
		$hours 	= (int) $time_ary[0];
		$min 	= (int) $time_ary[1];
		$sec 	= (float) $time_ary[2];
	} else if ( count( $time_ary ) == 2 ) {
		$min 	= (int) $time_ary[0];
		$sec 	= (float) $time_ary[1];
	} else if ( count( $time_ary ) == 1 ) {
		$sec 	= (float) $time_ary[0];
	}
	return ( $hours * 3600 ) + ( $min * 60 ) + $sec;
}
?>