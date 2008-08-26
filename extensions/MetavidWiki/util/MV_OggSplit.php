<?php
/**
 * MV_OggSplit.php
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 *
 * a lightweight php ogg spliter 
 * 
 * (for best performance use a caching mechanism)
 **/
 //can be an entry point so don't check for MEDIAWIKI: 
 //(mod_redirects for serving ogg streams point here)
 
	//take in a media request (should be handled via mod_rewrite)
	//http://server/stream_name&t=[ntp start time]/[ntp end time]
	$time_start = microtime_float();
		
	//some predefined values matches oggz_auto.c: 	
	DEFINE('OGGZ_AUTO_MULT', 1000);
	
	//for now have it be hard coded: 
	$file = '/var/www/html/ogg_split_vid/senate_proceeding_04-11-07.ogg';
	//$f = fopen( $file, "rb" );
	//if( !$f ) die('can\t read file');
	$ogg_stream = new oggStream($file);
	$ogg_stream->close();
	echo "<br />RunTime: " .  round((microtime_float()- $time_start),5);
	die;
		
	//gets the time range
	$ogg_stream->get_range('0:00:0', '0:03:00');
	$ogg_stream->send_headers();
	$ogg_stream->send_stream();

		
	class oggStream{
		var $pages = array();
		function oggStream($file){
			$this->file_name = $file;
			$this->f =  fopen( $file, "rb" );
			if( !$this->f)die('can\t read file');
			//find the first page: 
			
			//load the stream with current info
			$this->get_stream_info();
		}		
		function get_stream_info(){
			//@@todo recognize multiple streams 
			
			//@@todo check cache (with name/file modification date)
			//( to pull meta data without reading the file)
			
			//get the stream size:
			$this->stream_size = filesize($this->file_name );
		
			
			//if not available in the cache compute: 
			fseek($this->f, 0); //make sure we are the start of the file:
			$header = fread( $this->f, 512 );
			$this->magic = substr($header, 0, 4);
			//stream serial number:
			$this->serial = substr($header, 14, 4);
			//number of segments in the page
			$this->segments = ord($header[26]);
			$this->packet_length = 0;
			for ($i = 0; $i < $this->segments; $i++) {
			  $this->packet_length += ord($header[27+$i]);
			}			
			$this->packet_magic = substr($header,27+$this->segments,8);
			if (0 == strncmp($this->packet_magic,"\x01vorbis",7)) {
			  $this->subtype = "audio/x-vorbis";
			} elseif (0 == strncmp($this->packet_magic,"\x80theora",7)) {
			  $this->subtype = "video/x-theora";
			} else {
			  $this->subtype = "unknown";
			}
			echo " type:<tt>".$this->subtype."</tt><br />";				
			if ($this->subtype == "audio/x-vorbis") {
				  $this->channels = ord($header[27+$this->segments+11]);
				  $this->rate = ord($header[27+$this->segments+15]);
				  $this->rate = ($this->rate << 8) | ord($header[27+$this->segments+14]);
			      $this->rate = ($this->rate << 8) | ord($header[27+$this->segments+13]);
			      $this->rate = ($this->rate << 8) | ord($header[27+$this->segments+12]);
				  echo " ".$this->channels." channel ".$this->rate."Hz";
			} elseif ($this->subtype == "video/x-theora") {	  
				  //The width of the frame in macro blocks.  16 bits.
				  $this->width = ord($header[27+$this->segments+14]);
				  $this->width = ($this->width << 8) | ord($header[27+$this->segments+15]);
			      $this->width = ($this->width << 8) | ord($header[27+$this->segments+16]);
			      //The height of the frame in macro blocks.  16 bits.
				  $this->height = ord($header[27+$this->segments+17]);
				  $this->height = ($this->height << 8) | ord($header[27+$this->segments+18]);
			      $this->height = ($this->height << 8) | ord($header[27+$this->segments+19]);
				  //The frame-rate numerator.  32 bits.
				  $this->fps_numerator = ord($header[27+$this->segments+22]);
				  $this->fps_numerator = ($this->fps_numerator << 8) | ord($header[27+$this->segments+23]);
				  $this->fps_numerator = ($this->fps_numerator << 8) | ord($header[27+$this->segments+24]);
				  $this->fps_numerator= ($this->fps_numerator << 8) | ord($header[27+$this->segments+25]);
				  //The frame-rate denominator.  32 bits.
				  $this->fps_denominator = ord($header[27+$this->segments+26]);
				  $this->fps_denominator = ($this->fps_denominator << 8) | ord($header[27+$this->segments+27]);
				  $this->fps_denominator = ($this->fps_denominator << 8) | ord($header[27+$this->segments+28]);
				  $this->fps_denominator = ($this->fps_denominator << 8) | ord($header[27+$this->segments+29]);
			       /* (not currently used) 
				  //the pixel aspect-ratio numerator.  24 bits
				  $parn = ord($header[27+$this->segments']+30]);
				  $parn = ($parn << 8) | ord($header[27+$this->segments+31]);
				  $parn = ($parn << 8) | ord($header[27+$this->segments+32]);
				  //The pixel aspect-ratio denominator.  24 bits
				  $pard = ord($header[27+$this->segments+33]);
				  $pard = ($pard << 8) | ord($header[27+$this->segments+34]);
				  $pard = ($pard << 8) | ord($header[27+$this->segments+35]);
				  //The color space.  8 bits.
				  $cs = ord($header[27+$this->segments+36]);
				  //The pixel format.  2 bits.(skipped)				 
				  //The nominal bitrate of the stream, in bits per second.  24 bits.
				  $nombr=ord($header[27+$this->segments+37]);
				  $nombr=($nombr << 8) | ord($header[27+$this->segments+38]);
				  $nombr=($nombr << 8) | ord($header[27+$this->segments+39]);
				  //The quality hint.  6 bits.</t>				  
				  $qual = ord($header[27+$this->segments+40]);
				  $qual = ($qual >> 2); //shave off the last two bits ?
				  */
				  /*
				   * The amount to shift the key frame number by in the granule position.  5 bits.</t>
				   *  (in oggz_auto.c) (we don't currently support theora < alpha3')				    
				   keyframe_granule_shift = (char) ((header[40] & 0x03) << 3);
				   keyframe_granule_shift |= (header[41] & 0xe0) >> 5;
				   */
				  $this->kfgshfit = ord( ($header[27+$this->segments+40] & 0x03)  << 3 );
				  $this->kfgshfit =  $this->kfgshfit | ord( ($header[27+$this->segments+41] & 0xe0)  >> 5);
				   
				  if ( $this->fps_numerator == 0 || $this->fps_denominator == 0) {
				  	$this->rate = "unknown";
				  } else {
				  	$this->rate = $this->fps_numerator/$this->fps_denominator;
				  }
				  echo " ".$this->width."x".$this->height . "<br />";
				  echo " ".$this->rate." fps <br />";
				  echo " serial: ".$this->serial. '<br />';
			}	
			echo " (".$this->stream_size." bytes)";
			//now get the stream length (for educated page location guessing)												
			print "stream length: " .$this->getStreamLength() . 's Or:' . seconds2ntp( floor($this->getStreamLength()) );					
		}		
		function getStreamLength(){
			if(!isset($this->stream_length)){
				//seek back the max page size (65,025 Bytes )
				fseek($this->f, -65025, SEEK_END);
				$end_bytes = fread($this->f, 65025);
				//find all potential pages: 
				$positions = findAllOccurences($end_bytes, "OggS");					
				//reverse sort (so we look from the last page back)
				$reverse_positions = array_reverse($positions);
				//set prev_offset to (last)
				$prev_offset = strlen($end_bytes);
				foreach($reverse_positions as $offset){
					$page_length = ($prev_offset - $offset);
					print "page is " . $offset . " for " . $page_length . ' bytes<br />';
					//@@todo store in $this->pages[] with byteoffset from base as key		
					$cur_page = new oggPage( substr($end_bytes, $offset, $page_length), 
												$this ) ;
					//confirms we are on the same logical stream:
				  	if ($cur_page->getSerial() == $this->serial) {
				  		$this->stream_length = $cur_page->getGranuleposAbsTime();
				  		// break out of the for loop
				  		//print "match $offset <br />";
				  		break;
				  	}
				  	$prev_offset = $offset;
				}		
			}
			return $this->stream_length;
		}
		
		function outputTimeRange(){
			//sends the raw ogg stream segment out to the browser
			
		}
		function close(){
			fclose($this->f);
		}
	} 

class oggPage{
	/* init an ogg page with its page bytes and a pointer to the parent stream */
	function oggPage($page_bytes, & $parent_stream){
		$this->page = $page_bytes;
		$this->parent_stream = $parent_stream;
		//@@todo validate the page		
	}
	/* get the page stream serial number */
	function getSerial(){
		if(!isset($this->serial)){
			$this->serial =  substr($this->page, 14, 4);
		}
		return $this->serial;
	}
	/* 
	 * get the Absolute Granule Position 
	 * (useful for vorbis audio tracks)
	 * In the case of video its a bit-divided framestamp so
	 *  use getGranuleposAbsTime to get the current frames time
	 * (in audio the sample number in video the frame number)
	 */
	function getGranulepos(){
		if(!isset($this->granulepos)){
			//fine for getting the audio sample:
			print 'building granulepos from: ' . substr($this->page, 6, 13) . "<br />"; 			
			$granulepos = ord($this->page[6]);
			print "adding: " . decbin((ord($this->page[6]))) . "<br />";
			
		    $granulepos = $granulepos | (ord($this->page[7]) << 8);
		    print "adding: " . decbin((ord($this->page[7]) << 8)) . "<br />";
		    
		    $granulepos = $granulepos | (ord($this->page[8]) << 16);
		    print "adding: " . decbin((ord($this->page[8]) << 16)) . "<br />";
		    
		    $granulepos = $granulepos | (ord($this->page[9]) << 24);
		    print "adding: " . decbin((ord($this->page[9]) << 24)) . "<br />";
		    
		    $granulepos = $granulepos | (ord($this->page[10]) << 32);
		    print "adding: " . decbin((ord($this->page[10]) << 32)) . "<br />";
		    
		    $granulepos = $granulepos | (ord($this->page[11]) << 40);
		    print "adding: " . decbin((ord($this->page[11]) << 40)) . "<br />";
		    
		    $granulepos = $granulepos | (ord($this->page[12]) << 48);
		    print "adding: " . decbin((ord($this->page[12]) << 48)) . "<br />";
		    
		    $granulepos = $granulepos | (ord($this->page[13]) << 56);
		    print "adding: " . decbin((ord($this->page[13]) << 56)) . "<br />";	    		    	    		  
		    
		    $this->granulepos =  $granulepos;		    		    
		}
		return $this->granulepos;
	}
	/* get nearest keyframe position */
	function getGranuleposKeyFrame(){
		
	}
	/*
	 * similar to auto_theora_metric in oggz_auto.c
	 */
	function getGranuleposAbsTime(){		
		if(!isset($this->granule_pos_abs_time)){
			//echo "div: ". $this->getGranulepos() . " / " . $this->parent_stream->rate . "<br />";
			//$this->time_in_stream = $this->getGranulepos()/$this->parent_stream->rate;
			print "gran full:" .$this->getGranulepos() . "<br />";	
			print "kfg shift:" . $this->parent_stream->kfgshfit . "<br />";
			//convert kfg shift to binnary mask
			
			$granulepos = $this->getGranulepos();
			
			//$bit_mask=0;			
			//for($i=0;$i< $this->parent_stream->kfgshfit;$i++){
			//	$bit_mask = $bit_mask | (1 << $i);
			//}			
			//print "bit mask: " .decbin($bit_mask) . " ". strlen(decbin($bit_mask)) . "<br />";
			
			//shift the $granulepos by kfgshfit			
			$iframe = $granulepos >>  ord($this->parent_stream->kfgshfit);
			print "iframe: " . $iframe . "<br />";			
			
			$pframe = $granulepos - ($iframe << $this->parent_stream->kfgshfit) ;			
			print "pframe: " . $pframe . "<br />";
			
			$granulepos = ($iframe + $pframe);
			print "granulespos: " . $granulepos . "<br />";
			
			$unit = ($granulepos * OGGZ_AUTO_MULT) / $this->parent_stream->rate;
			print "unit: " . $unit . "<br />";
			$this->granule_pos_abs_time = $unit;			
			/*
			$num_bytes = floor( $this->parent_stream->kfgshfit / 8 );
			$byte_part = $this->parent_stream->kfgshfit % 8;
			
			//get the first byte:	
			//$granulepos = ord($this->page[6]);
			//for($i=1; $i < $num_bytes; $i++ ){
		    //	$granulepos = $granulepos | (ord($this->page[6+$i]) << ($i*8) );
			//}
			//get the last piece
			
			$granulepos = ord($this->page[6]);
		    $granulepos = $granulepos | (ord($this->page[7]) << 8);
		    $granulepos = $granulepos | (ord($this->page[8]) << 16);
		    $granulepos = $granulepos | (ord($this->page[9]) << 24);
		    $granulepos = $granulepos | (ord($this->page[10]) << 32);
		    $granulepos = $granulepos | (ord($this->page[11]) << 40);
		    $granulepos = $granulepos | (ord($this->page[12]) << 48);
			 		    			
		    		    
		    echo "gran piece: " . $granulepos . "<br />";
		    echo "stream time: " . seconds2ntp($granulepos/1000) . "<br />";
		    */
			//echo " gran time: " .substr($this->getGranulepos(), 0, $this->parent_stream->kfgshfit/8 ). "<br />";
			//echo " time: " . seconds2ntp(substr($this->getGranulepos(), 0, $this->parent_stream->kfgshfit/8));
			 			
		}
		//return 0;
		return $this->granule_pos_abs_time;		
	}
	
}		
function findAllOccurences(& $haystack, $needle, $limit=0)
{
  $positions = array();
  $currentOffset = 0;
  $count=0;
  $offset=0;
  while(($pos = strpos($haystack, $needle, $offset)) && ($count < $limit || $limit == 0))
  {
    $positions[] = $pos;
    $offset = $pos + strlen($needle);
    $count++;
  }
  return $positions;
}
/*utility functions */

 function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

/*
 * takes seconds duration and return hh:mm:ss time
 */
function seconds2ntp($seconds){
	$dur = time_duration_2array($seconds);
	print_r($dur);
	//be sure to output leading zeros (for min,sec):  
	return sprintf("%d:%02d:%02d", $dur['hours'], $dur['minutes'], $dur['seconds']);
}
/*
 * converts seconds to time unit array
 */
function time_duration_2array ($seconds, $periods = null){        
	// Define time periods
	if (!is_array($periods)) {
		$periods = array (
			'years'     => 31556926,
			'months'    => 2629743,
			'weeks'     => 604800,
			'days'      => 86400,
			'hours'     => 3600,
			'minutes'   => 60,
			'seconds'   => 1
			);
	}

	// Loop
	$seconds = (float) $seconds;
	foreach ($periods as $period => $value) {
		$count = floor($seconds / $value);
		if ($count == 0) {
			//must include hours minutes and seconds even if they are 0
			if($period=='hours' || $period=='minutes' || $period=='seconds'){
				$values[$period] = 0;
			}
			continue;
		}
		$values[$period] = sprintf("%02d", $count);
		$seconds = $seconds % $value;
	}
	// Return
	if (empty($values)) {
		$values = null;
	}
	return $values;
}
 
?>
