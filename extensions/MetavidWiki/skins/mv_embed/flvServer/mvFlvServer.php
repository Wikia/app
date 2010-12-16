<?php
/*
 * mv_flvServer.php
 *
 * @date Jul 25, 2008
 *
 * this should enable serving segments of flv files
 *
 * called with: mv_flvServer.php?file=myClip.flv&t=0:01:00/0:02:00
 *
 * flash does not like get arguments in media files? so best to use mod-rewrite
 * something like:
 * /flvserver/my_file/start_time/end_time
 */
define('BASE_LOCAL_CLIP_PATH', '/metavid/video_archive');
//define('BASE_LOCAL_CLIP_PATH', '/tmp');

define('WEB_CLIP_PATH', '/flv_cips');
define('FLASH_VIDEO_CONTENT_TYPE', 'video/x-flv');

define('AUDIO_FRAME_INTERVAL', 3);
//what to append to the flv file name to store serialized meta tags:

if(!function_exists('filter_input')){
	die('you version of php lacks <b>filter_input()</b> function</br>');
}
do_request();
function do_request(){
	$file_req = filter_input(INPUT_GET, 'file', FILTER_SANITIZE_STRING);
	$time_req = filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING);

	//try to grab the file from /filename format
	if($file_req==''){
		if(isset($_SERVER['PHP_SELF'])){
			$pathparts = explode('/',$_SERVER['PHP_SELF']);
			$file_req = (strpos($pathparts[count($pathparts)-1], '?')!==false)?
					substr($pathparts[count($pathparts)-1],0, strpos($pathparts[count($pathparts)-1],'?')):
					$pathparts[count($pathparts)-1];
		}
	}
	//additional filtering to avoid directory traversing:
	$file_req = str_replace(array('../','./'), '', $file_req);
	if($file_req=='')
		die('error: missing file name');

	$file_loc =BASE_LOCAL_CLIP_PATH.'/'.$file_req;
	if(!is_file($file_loc))
		die('error: requested file not found:'. $file_loc);

	//if 't' is empty no seeking necessary:
	if( $time_req == '' ){
		header('Content-type: '.FLASH_VIDEO_CONTENT_TYPE);
		header('Content-Length: ' . filesize($file_loc) );
		output_full_file($file_loc);
	}else{
		//@@todo support more time request formats
		if(strpos( $time_req,'/')!==false){
			list($start_time_ntp, $end_time_ntp)=explode('/',$time_req);
			$start_sec 	= npt2seconds($start_time_ntp);
			$end_sec 	= npt2seconds($end_time_ntp);
		}else{
			$start_sec 	= npt2seconds($time_req);
			$end_sec	= null;
			if( $start_sec==0 )
				output_full_file($file_loc);
		}
		if($start_sec > $end_sec)die('error: requested invalid time range');
		//print "DO: $start_sec $end_sec \n";
		require_once('MvFlv.php');
		//open up the metavid Flv object:
		$flv = new MyFLV();
		try {
			$flv->open( $file_loc );
		} catch (Exception $e) {
			die("<pre>The following exception was detected while trying to open a FLV file:\n" . $e->getMessage() . "</pre>");
		}
		header('Content-type: '.FLASH_VIDEO_CONTENT_TYPE);
		$one_year = 60*60*24*365;
		header("Expires: " . gmdate( "D, d M Y H:i:s", time() + $one_year  ) . " GM");
		//small meta file to parse no big deal:
		list($start_byte, $end_byte) = $flv->getKeyFrameByteTimes($start_sec, $end_sec);
		//send out content length:
		header('Content-Length: ' . ($end_byte - $start_byte) );
		$flv->play($start_byte, $end_byte);
		//$end = microtime(true);
		//file_put_contents('/tmp/time.log', "<hr/>EXTRACT METADATA PROCESS TOOK " . number_format(($end-$start), 2) . " seconds<br />");
		$flv->close();
	}
}


function output_full_file($file_loc){
	header('Content-Type: '.FLASH_VIDEO_CONTENT_TYPE);
	while (ob_get_level() > 0) {
   		ob_end_flush();
	} //turn off output buffering
	@readfile($file_loc);
	die();
}

function npt2seconds($str_time){
	$time_ary = explode(':', $str_time);
	$hours=$min=$sec=0;
	if(count($time_ary)==3){
		$hours=$time_ary[0];
		$min=$time_ary[1];
		$sec=$time_ary[2];
	}else if(count($time_ary)==2){
		$min=$time_ary[0];
		$sec=$time_ary[1];
	}else if(count($time_ary)==1){
		$sec=$time_ary[0];
	}
	return ($hours*3600) + ($min*60) + $sec;
}
?>
