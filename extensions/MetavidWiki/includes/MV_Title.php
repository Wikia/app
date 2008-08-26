<?php
/*
 * MV_Title.php Created on May 3, 2007
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 * 
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 
 /*@@TODO document 
  * @@todo title implementation is a bit messy ..
  * MV_Title should really just extend title and be passed around as a title
  *  instead of having two objects (Title and MV_title)
  */
 class MV_Title extends Title{
 	var $stream_name=null;
 	var $type_marker=null;
 	var $start_time=null;
 	var $end_time=null;
 	var $id = null;

 	
 	var $hasMVDType = false;
 	var $dispVideoPlayerTime=false;
 	//a pointer to the mvStream 
 	var $mvStream = null;
 	var $wiki_title='';
 	//default namespace for mvTitle MV_NS_MVD
 	function __construct($title, $ns=MV_NS_MVD){ 	 		
 		//handle title object	
 		if(is_string($title)){ 			 			 			
 			$title = parent::makeTitle($ns, $title);
 		}  		 		
 		$this->inheritTitle( $title) ;
 		 		 	
 		//its just a plain string generate the parse info
 		$this->wiki_title = $title->getDBKey();
 		$this->parseTitle($title->getDBKey());
 		//print "mv_title stream name: " . $this->stream_name. "\n";
 	}
 	function inheritTitle($tilte){
 		foreach($tilte as $k=>$v){
 			$this->$k= $v;
 		}
 	}
 	function hasMVDType(){ return $this->hasMVDType;}
 	/* 
 	 * checks if the given request is valid:
 	 * valid request include:
 	 * type:existing_stream/##:##:##(/##:##:##)?
 	 */
 	function validRequestTitle(){
 		//@@todo should throw use exceptions
 		//first check if stream exists
 		if(!$this->doesStreamExist()) {
 			//print "stream does not exist"; 
 			return false;
 		}
 		if(!$this->hasMVDType()){
 			//print "stream does not have type";
 			return false;
 		}
 		if($this->start_time==null){
 			//print "stream time missing or invalid";
 			return false;
 		} 		
 		return true;
 	}
 	/*
	 * Check the db for the given stream name 
	 */
	function doesStreamExist(){	
		//print "looking for: ". 	$this->stream_name;
		$this->mvStream = & mvGetMVStream($this->stream_name);
		$this->mvStream->setMvTitle($this);
		//load the current stream return its success or failure
		return $this->mvStream->db_load_stream(); 
	}
	function getStreamName(){ return $this->stream_name;}
	/*
	 * Returns the stream name with uppercase first word
	 *  and spaces for underscores 
	 */
	function getStreamNameText($sn=''){
		if($sn=='')$sn =  $this->stream_name;
		return ucfirst(str_replace('_', ' ',$sn)); 
	}
	/*
	 * makes title like db key:
	 */
	function normalizeTitle($title){
		return ucfirst(str_replace(' ', '_', strtolower($title)));
	}
	function getMvdTypeKey(){ return $this->type_marker;}
	function getStreamId(){				
		if($this->mvStream){
			return $this->mvStream->getStreamId();
		}else{
			if($this->doesStreamExist()){				
				return $this->mvStream->getStreamId();
			}
		}
		return false;
	}
	function getTypeMarker() {return $this->type_marker;}
	function getWikiTitle(){ return $this->wiki_title;}
	function getStartTime(){ return $this->start_time;}
	function getTimeRequest(){ return $this->start_time.'/'.$this->end_time;}
	function getEndTime(){ return $this->end_time;}
	function getMwTitle(){return Title::MakeTitle(MV_NS_MVD, $this->wiki_title);}
	
	
	function setStartEndIfEmpty(){		
		global $mvDefaultStreamViewLength;
		if($this->start_time==null){
			$this->start_time_sec=0;
 			$this->start_time =seconds2ntp($this->start_time_sec);
 		}else{
 			$this->start_time_sec = ntp2seconds($this->start_time);
		}
 		if($this->end_time==null|| ntp2seconds($this->end_time)< $this->start_time_sec){ 			
 			if($this->start_time_sec==0){
 				$this->end_time= seconds2ntp($mvDefaultStreamViewLength);
 				$this->end_time_sec = $mvDefaultStreamViewLength;
 			}else{
 				$this->end_time_sec = ($this->start_time_sec+$mvDefaultStreamViewLength);
 				$this->end_time = seconds2ntp($this->end_time_sec);
 			} 			
 			if($this->getDuration()!=0){
	 			if($this->end_time_sec > $this->getDuration()){
	 				$this->end_time_sec=$this->getDuration();
	 				$this->end_time = seconds2ntp($this->end_time_sec);
	 			}
 			}
 		}
	}
	/* 
	 * returns start time in seconds
	 */
	function getStartTimeSeconds(){
		if(isset($this->start_time_sec))return $this->start_time_sec;
		$this->start_time_sec = ntp2seconds($this->start_time);
		return $this->start_time_sec;
	}
	/* 
	 * returns end time in seconds
	 */
	function getEndTimeSeconds(){
		if(isset($this->end_time)){		
			if(isset($this->end_time_sec))return $this->end_time_sec;
			$this->end_time_sec = ntp2seconds($this->end_time);
			return $this->end_time_sec;
		}
		return null;
	}
	/*
	 * legacy/convenience function (should probably just update all getDuration calls 
	 * to call global MVstream directly
	 */
	function getDuration(){	
		$stream = & mvGetMVStream($this->stream_name);
		return $stream->getDuration();
	}
	/*
	 * returns a near by stream range:
	 */
	function getNearStreamName($range='', $length=''){
		global $mvDefaultClipLength, $mvDefaultClipRange;
		
		$stream = & mvGetMVStream($this->stream_name);
				
		if($range=='')$range = $mvDefaultClipRange;
		if($length=='')$length=$mvDefaultClipLength;
		//subtract $range seconds from the start time:
		$start_t = $this->getStartTimeSeconds()  - $range;
		if($start_t<0)$start_t=0;
		
		$start_ntp = seconds2ntp( $start_t ) ;
		//add $range seconds to the end time:
		if(isset($this->end_time)){
			$end_t = $this->getEndTimeSeconds()  + $range;
			if($end_t > $stream->getDuration()){
				$end_t = $stream->getDuration();
			}
			$end_ntp = '/' . seconds2ntp( $this->getEndTimeSeconds()  + $range);
		}else{
			//make the end time the default Clip length
			$end_ntp='/'. seconds2ntp($this->getStartTimeSeconds() +$length+$range);	
		}
		return $this->stream_name . '/'.$start_ntp . $end_ntp;
	}
	function getTimeDesc(){	
		if($this->getStartTime() && $this->getEndTime()){
			return wfMsg('mv_time_separator', $this->getStartTime(), $this->getEndTime());
		}else{
			return '';
		}
	}
	function getFullStreamImageURL($size=null, $req_time=null, $foce_server=''){
		global $wgServer,$mvExternalImages;
		//if using external images already: 
		if($mvExternalImages){
			return $this->getStreamImageURL($size, $req_time, $foce_server);
		}else{
			global $wgServer;
			return $wgServer.$this->getStreamImageURL($size, $req_time, $foce_server);
		}			
	}
	//@@todo force_server is a weird hack ... @@todo remove and update other code locations 
	function getStreamImageURL($size=null, $req_time=null, $foce_server=''){		
		global $mvDefaultVideoPlaybackRes;
		if($size==null){
			$size = $mvDefaultVideoPlaybackRes;
		}
		if($req_time==null){
			$req_time = $this->getStartTime();
			if(!$req_time)$req_time='0:00:00';
		}
		if($foce_server==''){
			//get the image path: (and generate the image if necessary)				
			return MV_StreamImage::getStreamImageURL($this->getStreamId(), $req_time, $size);
		}else{
			return $foce_server . $this->getStreamName() . '?t='.$req_time;
		}
	}
	/*
	 * function: getWebStreamURL
	 * 
	 * returns full web accessible path to stream
	 * (by default this is the web streameable version of the file)
	 * web stream is file_desc_msg as: mv_ogg_low_quality
	 * $mvDefaultVideoQualityKey in MV_Settings.php
	 * 
	 * @@todo point to MV_OggSplit (for segmenting the ogg stream)
	 * (for now using anx)
	 */	 
	function getWebStreamURL($quality=null){
		global $mvStreamFilesTable, $mvVideoArchivePaths, $mvDefaultVideoQualityKey;
		//@@todo mediawiki path for media (insted of hard link to $mvVideoArchive)
		//@@todo make sure file exisits
		if(!$quality)$quality=$mvDefaultVideoQualityKey;
		$anx_req='';
		if( $this->getStartTime()!='' && $this->getEndTime()!=''){
			$anx_req  ='.anx?t='. $this->getStartTime() . '/' . $this->getEndTime();
		}
		if( $this->doesStreamExist() ){			
			//@@todo cache this / have a more organized store for StreamFiles in streamTitle
			$dbr = & wfGetDB(DB_READ);
			$result = $dbr->select($dbr->tableName($mvStreamFilesTable), array('path'), array (			
				'stream_id' => $this->mvStream->id,
				'file_desc_msg'=>$quality
			));
			$streamFile  =$dbr->fetchObject($result);					
			//make sure we have streamFiles (used to generate the link)				
			$mvStreamFile = new MV_StreamFile($this->mvStream);
			//if link empty return false:			
			if($mvStreamFile->getFullURL()=='')return false;			
			return $mvStreamFile->getFullURL() . $anx_req;
		}else{
			//@@todo throw ERROR
			return false;
		}
	}	
	function getROEURL(){		
		$roeTitle = Title::newFromText('MvExportStream', NS_SPECIAL);
		//add the query: 
		$query = 'feed_format=roe&stream_name='.$this->getStreamName().'&t='.$this->getTimeRequest();
		return $roeTitle->getFullURL($query) ;
	}
	function getEmbedVideoHtml($vid_id='', $size='', $force_server='', $autoplay=false){
		$tag='video';
		if($size==''){
			global $mvDefaultVideoPlaybackRes;
			$size=$mvDefaultVideoPlaybackRes;
		}
		$vid_id=($vid_id=='')?'':'id="'.$vid_id.'"';
		list($vWidth, $vHeight) = explode('x', $size);		
		$stream_web_url = $this->getWebStreamURL();
		$roe_url = 	$this->getROEURL();	
		if($stream_web_url){
			$o='';		
			if($this->dispVideoPlayerTime){				
				$o.='<span id="mv_videoPlayerTime">'.$this->getStartTime().' to '.
					$this->getEndTime() . 
					'</span>';
			}				
			$auto_play_attr=($autoplay)?' autoplay="true" ':'';
			$o.='<'.$tag.' '.$vid_id.' thumbnail="'.$this->getStreamImageURL($size, null, $force_server).'" '.
				'src="'.$stream_web_url .'" ' .				
				'roe="'.$roe_url.'" '.
				'show_meta_link="false" ' . $auto_play_attr . 
				'style="width:'.$vWidth.'px;height:'.$vHeight.'px" '.
				'controls="true" embed_link="true" />';				
			return $o;	
		}else{
			return wfMsg('mv_error_stream_missing');
		}						
	}
	function getTitleDesc(){	
		if($this->type_marker){
			$title_str = wfMsg('mv_data_page_title',  
				wfMsg($this->type_marker),
				$this->getStreamNameText(),
				$this->getTimeDesc() );
		}else{
			$title_str = $this->getStreamNameText() .' '. $this->getTimeDesc();
		}	
		return $title_str;
	}
	 /*
	 * returns a parsed title/request 
	 */
	function parseTitle($title){ 
		global $mvDefaultClipLength;
 		//the metavid namespace:
 		//stream:stream_name ||
 		//mvd:type:stream_name_date/start_time/end_time	 		
 		
 		$parts= split('/',$title);
		if(!isset($parts[1]))$parts[1]='';
 		//check for type:
 		$sub_parts = split(':',$parts[0]); 
		
 		if(count($sub_parts)==2){
 			if($sub_parts[0]=='' && $sub_parts[1]==''){
 				$this->stream_name = null;
 				$this->type_marker = null;
 				$this->hasMVDType=false;
 			}else{
 				$this->stream_name = $sub_parts[1];
 				$this->type_marker = $sub_parts[0];
 				$this->hasMVDType=true;
 			}
 		}else{
 			if($parts[0]==''){
 				$this->stream_name = null;
 			}else{
 				//print_r($sub_parts);
 				//@@todo do look up of single part request 
 				$this->stream_name = $sub_parts[0];
 				//$this->stream_name = null;
 			} 			
 			$this->hasMVDType=false;
 		}
 		//check if the type isTime or "type"
 		if(isset($parts[1])) { 			
 			if(mvIsNtpTime($parts[1])){
 					$this->start_time =$parts[1];
 					if(isset($parts[2])){
		 				if(mvIsNtpTime($parts[2])){
		 					$this->end_time =$parts[2];
		 				}
 					}
 			}
 		}
 		//(support null endtimes)
 		//if the endtime is unset set it to the default length after the start time: 
 		//if(!isset($end_time)){
 			//$this->end_time = seconds2ntp(ntp2seconds($this->start_time) + $mvDefaultClipLength) ;
 		//}
 		
 		//@@todo make sure start time is not negative & end time is not > duration 
 		 		
 		//validate the start time: 
 		if(mvIsNtpTime($this->start_time)==false)$this->start_time=null;
 		
 		//validate the end time: 
 		if($this->end_time!=null){
 			if(mvIsNtpTime($this->end_time)==false)$this->end_time=null;
 			
 			//make sure the end time is > than the start time: 		
 			if(ntp2seconds($this->start_time) > ntp2seconds($this->end_time)){ 			
 				//@@TODO better error handling 
 				$this->start_time=null;
 				$this->end_time=null;
 			}
 		} 		 		
 	}
 	
}
?>
