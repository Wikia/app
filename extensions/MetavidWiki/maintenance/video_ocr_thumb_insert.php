<?php
/*
 * video_ocr_thumb_insert.php  Created on January, 2009
 * based on ogg_thumb_insert
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 * @author Michael Dale, aphid
 * @email dale@ucsc.edu, aphid@ucsc.edu
 * @url http://metavid.org
 */

$cur_path = $IP = dirname( __FILE__ );
// include commandLine.inc from the mediaWiki maintance dir:
require_once ( '../../../maintenance/commandLine.inc' );
require_once ( 'metavid2mvWiki.inc.php' );
	
// include util functions:
require_once( 'maintenance_util.inc.php' );

if ( count( $args ) == 0 || isset ( $options['help'] ) ) {
	print '
USAGE
 php video_thumb_insert.php stream_name interval [options]

EXAMPLE" we get a frame every 5 seconds from input file stream.mpeg: 
 video2image2mvwiki.php stream_name [options] 

OPTIONS:
	--interval 		 	@default 5 seconds
	--overwrite_image  	@default no overwrite; if set will  force image output 
	--use_file $file	//the full path to the file you want to use to generate thumbnails 

DURATION is scraped from ffmpeg

Notes:
  if possible you want to use the source footage rather than the ogg to generate the thumbnails (ie the mpeg2 or dv)
';
exit();

}

if(isset($args[0])){
	$stream_name = $args[0];
}else{
	die('no stream name provided'."\n");	
}
//default options:
$interval = 5;
$overwrite_image=false;

if(isset($options['interval'])){
	$interval = $options['$interval'];
}
if(isset($options['overwrite_image'])){
	$overwrite_image=true;
}
$workingdir = '/video/metavid/raw_mpeg2';
if(isset( $options['use_file'] )){
	$filename = $options['use_file'];
}else{
	$filename = $workingdir .'/'. $stream_name . '.mpeg';
} 
$duration = getDuration($filename);


//read the timestamp from the .srt
$srt_file = $workingdir . '/' . $stream_name . '.srt';
$srt_ary = file( $srt_file );
if($srt_ary === false)
	die(' could not find srt file: ' . $srt_file); 
			
//time stamp: 
$org_start_time = intval( trim( str_replace( 'starttime' , '', $srt_ary[2] )) );	 
	
class streamObject{	};	
$stream = new streamObject();
$stream->name = $stream_name;
$stream->date_start_time =	$org_start_time; 
$stream->sync_status 	= 	'in_sync';
$stream->duration		=	$duration;
	

$mvTitle = new MV_Title( 'Stream:' . $stream_name );
if ( !$mvTitle->doesStreamExist() ) {
	print $stream_name . " does not exist ... creating\n";
	// print 'do stream desc'."\n";		
		
	if(!isset($MVStreams))
		$MVStreams = array();
	
	// init the stream (legacy from old stream insert system)  
	$MVStreams[ $stream->name ] = new MV_Stream( $stream );		
	
	do_add_stream( $mvTitle, $stream );
}
$stream_id = $mvTitle->getStreamId();
print 'got stream id: '. $stream_id . "\n";

//check for & update stream files: 
do_stream_file_check( $stream );


$filedir = '/video/metavid/mvprime_stream_images/' . MV_StreamImage::getRelativeImagePath( $stream_id );
if(!is_dir($filedir)){
	shell_exec("mkdir {$filedir}");
	shell_exec("chmod -R 777 {$filedir}");
}
echo "working on: $filename \n";
$ocroutput = "";
//@@TODO we should do sequential output and parse the OCR file if it already exists. 

//make sure we can write to the ocr file: 
$ocrfileloc = "$workingdir/$stream_name.ocr";
$fh = @fopen($ocrfileloc, 'a') or die ("\nError: can't write to ocr file\n");
fclose($fh);
//gets duration from ffmpeg

$dbw = $dbr = wfGetDB( DB_MASTER );
for ( $i = 0; $i < $duration; $i += $interval ) {
  //only run the ffmpeg cmd if we have to: 
  if(!is_file("{$filedir}/{$i}.jpg") || $overwrite_image){
  	if( is_file("{$filedir}/{$i}.jpg") ){
  		print "overwriting image: {$i}.jpg\n";
  		shell_exec("rm {$filedir}/{$i}.jpg");
  	}
  	shell_exec( "ffmpeg -ss $i -i {$filename} -vcodec mjpeg -vframes 1 -an -f rawvideo -y {$filedir}/{$i}.jpg 2>&1" );
  }
  
  if(is_file("{$filedir}/{$i}.jpg")){
	//insert the image into the db:
  	$dbw->query( "INSERT INTO `mv_stream_images` (`stream_id`, `time`) VALUES ($stream_id, $i)" );
	
  	//get ocr:
  	shell_exec("convert {$filedir}/{$i}.jpg -crop 457x30+63+358  {$workingdir}/temp.{$stream_id}.ocr.tif && convert {$workingdir}/temp.{$stream_id}.ocr.tif -resize 300% -level 10%,1,20% -monochrome +compress {$workingdir}/temp.{$stream_id}.ocr.tif");
    shell_exec("tesseract {$workingdir}/temp.{$stream_id}.ocr.tif {$workingdir}/ocrtemp{$stream_id} nobatch lettersonly 2>&1");
    $ocr = shell_exec("tail {$workingdir}/ocrtemp{$stream_id}.txt") ." at " . seconds2npt($i) ." \n";
    echo 'got ocr:'.  $ocr;
    $ocroutput .= $ocr;	
    
  }else{
  	print "failed to create file: {$filedir}/{$i}.jpg \n";  
  }
}
//remove temporary files: 
shell_exec("rm {$workingdir}/ocrtemp{$i}.txt");
shell_exec("rm {$workingdir}/temp.{$stream_id}.ocr.tif");

$ocrfileloc = "$workingdir/$stream_name.ocr";
$fh = fopen($ocrfileloc, 'w') or die ("can't write ocr file");
fwrite($fh, $ocroutput);
fclose($fh);

function getDuration($filename)
{
    $string = shell_exec( "ffmpeg -i $filename 2>&1");
    $pattern = "/Duration: ([0-9])([0-9]):([0-9])([0-9]):([0-9])([0-9])/";
    preg_match($pattern, $string, $reg_array);
    $result = $reg_array[0];
    $hms = explode(" ", $result);
    $durationhms = $hms[1];
    echo "$filename duration is $durationhms \n";
    $durarray = explode(":", $durationhms);
    return ($durarray[0]* 3600) + ($durarray[1]* 60) + $durarray[2];
}

