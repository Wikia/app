<?php
/*
 * ogg_thum_insert.php Created on Mar 13, 2008
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
 
 $cur_path = $IP = dirname(__FILE__);
//include commandLine.inc from the mediaWiki maintance dir: 
require_once ('../../../maintenance/commandLine.inc');
require_once ('metavid2mvWiki.inc.php');

//include util functions: 
require_once('maintenance_util.inc.php');

if (count($args) == 0 || isset ($options['help'])) { 
	print'
USAGE
 php ogg_thumb_insert.php stream_name filename interval duration

EXAMPLE
 ogg_thumb_insert.php stream_name /var/www/localhost/htdocs/media/stream.ogg 20
 
Notes:
  if possible you want to use the source footage rather than the ogg to generate the thumbnails (ie the mpeg2 or dv)
  
';
exit();
}
$stream_name=$args[0];
$filename=$args[1];
$interval=$args[2];
$duration=$args[3];

$MV_Stream = MV_Stream::newStreamByName($stream_name);
$stream_id =$MV_Stream->getStreamId();

$filedir='../stream_images/'.substr($stream_id, -1).'/'.$stream_id;
$dbw =$dbr = wfGetDB(DB_MASTER); 
for($i=0;$i<$duration;$i+=$interval){
  $dbw->query("INSERT INTO `mv_stream_images` (`stream_id`, `time`) VALUES ($stream_id, $i)");
  shell_exec("ffmpeg -ss $i -i {$filename} -vcodec mjpeg -vframes 1 -an -f rawvideo -y {$filedir}/{$i}.jpg");
}

?>
