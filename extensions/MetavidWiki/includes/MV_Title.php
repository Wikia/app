<?php
/*
 * MV_Title.php Created on May 3, 2007
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 *
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );

 /*@@TODO document
  * @@todo title implementation is a bit messy ..
  * MV_Title should really just extend title and be passed around as a title
  *  instead of having two objects (Title and MV_title)
  */
 class MV_Title extends Title {
 	var $stream_name = null;
 	var $type_marker = null;
 	var $start_time = null;
 	var $end_time = null;
 	var $id = null;
	var $view_count = null;

 	var $hasMVDType = false;
 	var $dispVideoPlayerTime = false;
 	// a pointer to the mvStream
 	var $mvStream = null;
 	var $wiki_title = '';
 	// default namespace for mvTitle MV_NS_MVD
 	function __construct( $title, $ns = MV_NS_MVD ) {
 		// handle title object
 		if ( is_string( $title ) ) {
 			$title = parent::makeTitle( $ns, $title );
 		}
 		//print "RAN TITLE: ". $title->getDBkey();
 		$this->inheritTitle( $title ) ;
 		// its just a plain string generate the parse info
 		$this->wiki_title = $title->getDBkey();
 		$this->parseTitle( $title->getDBkey() );
 		// print "mv_title stream name: " . $this->stream_name. "\n";
 	}
 	function inheritTitle( & $title ) {
 		if( !is_object($title)){
 			//print_r( debug_backtrace() );
 			return false;
 		}
 		foreach ( $title as $k => $v ) {
 			$this->$k = $v;
 		}
 	}
 	function hasMVDType() { return $this->hasMVDType; }
 	/*
 	 * checks if the given request is valid:
 	 * valid request include:
 	 * type:existing_stream/##:##:##(/##:##:##)?
 	 */
 	function validRequestTitle() {
 		// @@todo should throw use exceptions
 		// first check if stream exists
 		if ( !$this->doesStreamExist() ) {
 			// print "stream does not exist";
 			return false;
 		}
 		if ( !$this->hasMVDType() ) {
 			// print "stream does not have type";
 			return false;
 		}
 		if ( $this->start_time == null ) {
 			// print "stream time missing or invalid";
 			return false;
 		}
 		return true;
 	}
 	/*
	 * Check the db for the given stream name
	 */
	function doesStreamExist() {
		// print "looking for: ". 	$this->stream_name;
		$this->mvStream = & mvGetMVStream( $this->stream_name );
		$this->mvStream->setMvTitle( $this );
		// load the current stream return its success or failure
		return $this->mvStream->db_load_stream();
	}
	function getStreamName() { return $this->stream_name; }
	/*
	 * Returns the stream name with uppercase first word
	 *  and spaces for underscores
	 */
	function getStreamNameText( $sn = '' ) {
		if ( $sn == '' )$sn =  $this->stream_name;
		return ucfirst( str_replace( '_', ' ', $sn ) );
	}
	function getStreamNameDate(){
		$d = $this->mvStream->getStreamStartDate();
		if(!isset($d) || $d==0)
			return $this->getStreamNameText();
		$sn_parts = split('_',$this->stream_name);
		//remove the date part of the array:
		array_pop( $sn_parts);
		foreach($sn_parts as & $sp)
			$sp = ucfirst($sp);
		$sn = (count($sn_parts)>1)? implode(' ', $sn_parts): $sp[0];
		return $sn .' on '. date('M jS, Y',$d);
	}
	/*
	 * makes title like db key:
	 */
	function normalizeTitle( $title ) {
		return ucfirst( str_replace( ' ', '_', strtolower( $title ) ) );
	}
	function getMvdTypeKey() { return $this->type_marker; }
	function getStreamId() {
		if ( $this->mvStream ) {
			return $this->mvStream->getStreamId();
		} else {
			if ( $this->doesStreamExist() ) {
				return $this->mvStream->getStreamId();
			}
		}
		return false;
	}
	function getWikiTitle() { return $this->wiki_title; }
	function getStartTime() { return $this->start_time; }
	function setStartTimeNtp($start_time){
		$this->start_time = $start_time;
	}
	function getEndTime() { return $this->end_time; }
	function setEndTimeNtp($end_time){
		$this->end_time = $end_time;
	}
 	function getTimeRequest() { return $this->start_time . '/' . $this->end_time; }
	function getMwTitle() { return Title::MakeTitle( MV_NS_MVD, $this->wiki_title ); }

	function setStartEndIfEmpty() {
		global $mvDefaultStreamViewLength, $wgRequest;
		//if overview mode override the time settings:
		if( $wgRequest->getVal('view') == 'overview' ){
			$this->start_time_sec = 0;
			$this->start_time = seconds2npt( $this->start_time_sec );
			$this->end_time_sec = $this->getDuration();
			$this->end_time = seconds2npt( $this->end_time_sec );
		}

		if ( $this->start_time == null ) {
			$this->start_time_sec = 0;
 			$this->start_time = seconds2npt( $this->start_time_sec );
 		} else {
 			$this->start_time_sec = npt2seconds( $this->start_time );
		}
 		if ( $this->end_time == null || npt2seconds( $this->end_time ) < $this->start_time_sec ) {
 			if ( $this->start_time_sec == 0 ) {
 				$this->end_time = seconds2npt( $mvDefaultStreamViewLength );
 				$this->end_time_sec = $mvDefaultStreamViewLength;
 			} else {
 				$this->end_time_sec = ( $this->start_time_sec + $mvDefaultStreamViewLength );
 				$this->end_time = seconds2npt( $this->end_time_sec );
 			}
 			if ( $this->getDuration() != 0 ) {
	 			if ( $this->end_time_sec > $this->getDuration() ) {
	 				$this->end_time_sec = $this->getDuration();
	 				$this->end_time = seconds2npt( $this->end_time_sec );
	 			}
 			}
 		}
	}
	/*
	 * returns start time in seconds
	 */
	function getStartTimeSeconds() {
		if ( isset( $this->start_time_sec ) )return $this->start_time_sec;
		$this->start_time_sec = npt2seconds( $this->start_time );
		return $this->start_time_sec;
	}
	/*
	 * returns end time in seconds
	 */
	function getEndTimeSeconds() {
		if ( isset( $this->end_time ) ) {
			if ( isset( $this->end_time_sec ) )return $this->end_time_sec;
			$this->end_time_sec = npt2seconds( $this->end_time );
			return $this->end_time_sec;
		}
		return null;
	}
	/*
	 * legacy/convenience function (should probably just update all getDuration calls
	 * to call global MVstream directly
	 */
	function getDuration() {
		$stream = & mvGetMVStream( $this->stream_name );
		return $stream->getDuration();
	}
	function getSegmentDuration(){
		return $this->getEndTimeSeconds() - $this->getStartTimeSeconds();
	}
	function getSegmentDurationNTP( $short_time = false ) {
		return seconds2npt( $this->getSegmentDuration(), $short_time );
	}
	/*
	 * returns a near by stream range:
	 */
	function getNearStreamName( $range = null, $length = null ) {
		global $mvDefaultClipLength, $mvDefaultClipRange;

		$stream = & mvGetMVStream( $this->stream_name );

		if ( $range === null )$range = $mvDefaultClipRange;
		if ( $length === null )$length = $mvDefaultClipLength;

		// subtract $range seconds from the start time:
		$start_t = $this->getStartTimeSeconds()  - $range;
		if ( $start_t < 0 )$start_t = 0;

		$start_ntp = seconds2npt( $start_t ) ;
		// add $range seconds to the end time:
		if ( isset( $this->end_time ) ) {
			$end_t = $this->getEndTimeSeconds()  + $range;
			if ( $end_t > $stream->getDuration() ) {
				$end_t = $stream->getDuration();
			}
			$end_ntp = '/' . seconds2npt( $this->getEndTimeSeconds()  + $range );
		} else {
			// make the end time the default Clip length
			$end_ntp = '/' . seconds2npt( $this->getStartTimeSeconds() + $length + $range );
		}
		return $this->stream_name . '/' . $start_ntp . $end_ntp;
	}

	function getTimeDesc( $span_separated = false ) {
		if ( $this->getStartTime() && $this->getEndTime() ) {
			if ( $span_separated ) {
				return wfMsg( 'mv_time_separator',
					'<span class="mv_start_time">' . htmlspecialchars( $this->getStartTime() ) . '</span>',
					'<span class="mv_end_time">' . htmlspecialchars( $this->getEndTime() ) ) . '</span>';
			} else {
				return wfMsg( 'mv_time_separator', $this->getStartTime(), $this->getEndTime() );
			}
		} else {
			return '';
		}
	}
	function getFullStreamImageURL( $size = null, $req_time = null, $foce_server = '' ) {
		global $wgServer, $mvExternalImages;
		// if using external images already:
		if ( $mvExternalImages ) {
			return $this->getStreamImageURL( $size, $req_time, $foce_server );
		} else {
			global $wgServer;
			return $wgServer . $this->getStreamImageURL( $size, $req_time, $foce_server );
		}
	}
	// @@todo force_server is a weird hack ... @@todo remove and update other code locations
	function getStreamImageURL( $size = null, $req_time = null, $foce_server = '', $direct_link=false ) {
		global $mvDefaultVideoPlaybackRes;
		if ( $size == null ) {
			$size = $mvDefaultVideoPlaybackRes;
		}
		if ( $req_time == null ) {
			$req_time = $this->getStartTime();
			if ( !$req_time )$req_time = '0:00:00';
		}
		if ( $foce_server == '' ) {
			// get the image path: (and generate the image if necessary)
			return MV_StreamImage::getStreamImageURL( $this->getStreamId(), $req_time, $size, $direct_link );
		} else {
			return $foce_server . $this->getStreamName() . '?t=' . $req_time;
		}
	}
	/* gets all ~direct~ metadata for the current MV_Title
	 * (does not grab overlapping metadata)
	 * (semantic properties and categories)
	 * */
	function getMetaData( $normalized_prop_name = true ) {
		global $wgUser, $wgParser;
		$article = new Article( $this );
		$retAry = array();
		$text = $article->getContent();
		// @@todo should use semanticMediaWiki api here
		$tmpProp = MV_Overlay::get_and_strip_semantic_tags( $text );
		// strip categories
		$retAry['striped_text'] = preg_replace( '/\[\[[^:]+:[^\]]+\]\]/', '', $text );
		if ( $normalized_prop_name ) {
			foreach ( $tmpProp as $pkey => $pval ) {
				$retAry['prop'][str_replace( ' ', '_', $pkey )] = $pval;
			}
		} else {
			$retAry['prop'] = $tmpProp;
		}

  		$sk =& $wgUser->getSkin();
		// run via parser to add in Category info:
		$parserOptions = ParserOptions::newFromUser( $wgUser );
		$parserOutput = $wgParser->parse( $text , $this, $parserOptions );
		$retAry['categories'] = $parserOutput->getCategories();
		return $retAry;
	}
	/*
	 * function: getWebStreamURL
	 *
	 * returns full web accessible path to stream
	 * (by default this is the web streameable version of the file)
	 * web stream is file_desc_msg as: mv_ogg_low_quality
	 * $mvDefaultVideoQualityKey in MV_Settings.php
	 *
	 */
	function getWebStreamURL( $quality = null ) {
		global $mvVideoArchivePaths, $mvDefaultVideoQualityKey;
		// @@todo mediawiki path for media (instead of hard link to $mvVideoArchive)
		// @@todo make sure file exists
		if ( !$quality )$quality = $mvDefaultVideoQualityKey;
		if ( $this->doesStreamExist() ) {
			// @@todo cache this / have a more organized store for StreamFiles in streamTitle
			$dbr = & wfGetDB( DB_READ );
			$result = $dbr->select( 'mv_stream_files', '*', array (
				'stream_id' => $this->mvStream->id,
				'file_desc_msg' => $quality
			) );
			if ( $dbr->numRows( $result ) == 0 )return false;
			$streamFile  = $dbr->fetchObject( $result );

			// print_r($streamFile);
			// make sure we have streamFiles (used to generate the link)
			$mvStreamFile = new MV_StreamFile( $this->mvStream, $streamFile );
			// if link empty return false:
			if ( $mvStreamFile->getFullURL() == '' )return false;
					$time_req = '';
			if ( $this->getStartTime() != '' && $this->getEndTime() != '' ) {
				if ( $mvStreamFile->supportsURLTimeEncoding() ) {
					if( $mvStreamFile->path_type=='url_anx' )
						$time_req  = '?t=' . $this->getStartTime() . '/' . $this->getEndTime();

					if( $mvStreamFile->path_type=='mp4_stream' )
						$time_req  = '?start=' . $this->getStartTimeSeconds() . '&end=' . $this->getEndTimeSeconds();
				}
			}
			return $mvStreamFile->getFullURL() . $time_req;
		} else {
			// @@todo throw ERROR
			return false;
		}
	}
	function getROEURL() {
		$roeTitle = Title::newFromText( 'MvExportStream', NS_SPECIAL );
		// add the query:
		$query = 'stream_name=' . htmlspecialchars( $this->getStreamName() ) .
					'&t=' . htmlspecialchars( $this->getTimeRequest() .
					'&feed_format=roe' );
		return $roeTitle->getFullURL( $query ) ;
	}
	function getEmbedVideoHtml( $options=array() ) {
		global $mvDefaultFlashQualityKey, $mvDefaultVideoQualityKey, $mvDefaultMP4QualityKey;
		//init options if unset:
		$vid_id=(isset($options['id']))?$options['id']:'';
		$size  = (isset($options['size']))?$options['size']:'';
		$force_server = (isset($options['force_server']))?$options['force_server']:'';
		$autoplay = (isset($options['autoplay']))?$options['autoplay']:false;
		$showmeta =  (isset($options['showmeta']))?$options['showmeta']:false;

		$tag = 'video';
		if ( $size == '' ) {
			global $mvDefaultVideoPlaybackRes;
			$size = $mvDefaultVideoPlaybackRes;
			list( $vWidth, $vHeight ) = explode( 'x', $size );
		} else {
			list( $vWidth, $vHeight, $na ) = MV_StreamImage::getSizeType( $size );
		}


		$stream_web_url = $this->getWebStreamURL( $mvDefaultVideoQualityKey );
		$flash_stream_url = $this->getWebStreamURL( $mvDefaultFlashQualityKey );
		$mp4_stream_url = 	$this->getWebStreamURL( $mvDefaultMP4QualityKey );
		// print "looking for q: $mvDefaultFlashQualityKey ";

		// print "FOUND: $flash_stream_url";
		$roe_url = 	$this->getROEURL();
		//if no urls available return missing:
		if ( !$stream_web_url &&  !$flash_stream_url && !$mp4_stream_url ) {
			return wfMsgWikiHtml( 'mv_error_stream_missing' );
		}

		if ( $stream_web_url || $flash_stream_url || $mp4_stream_url) {
			$o = '';
			/*if($this->dispVideoPlayerTime){
				$o.='<span id="mv_videoPlayerTime">'.$this->getStartTime().' to '.
						htmlspecialchars( $this->getEndTime() ) .
					'</span>';
			}*/
			$o .= '<' . htmlspecialchars( $tag ) . ' ';
			$o .= ( $vid_id == '' ) ? '':' id="' . htmlspecialchars( $vid_id ) . '" ';
			$o .= 'poster="' . $this->getStreamImageURL( $size, null, $force_server ) . '" ' .
				'roe="' . $roe_url . '" ';
			$o .= ($showmeta)?'show_meta_link="true" ':'show_meta_link="false" ' ;

			$o .= ( $autoplay ) ? ' autoplay="true" ':'';

			$o .= 'style="width:' . htmlspecialchars( $vWidth ) . 'px;height:' . htmlspecialchars( $vHeight ) . 'px" ' .
				'controls="true" embed_link="true" >';

			if ( $stream_web_url )
				$o .= '<source timeFormat="anx" type="' .
					htmlspecialchars( MV_StreamFile::getTypeForQK( $mvDefaultVideoQualityKey ) ) .
					'" src="' . $stream_web_url . '"></source>';

			if ( $flash_stream_url )
				$o .= '<source timeFormat="anx" type="' .
					htmlspecialchars( MV_StreamFile::getTypeForQK( $mvDefaultFlashQualityKey ) ) .
					'" src="' . $flash_stream_url . '"></source>';

			if ( $mp4_stream_url )
				$o.='<source timeFormat="mp4" type="' .
					htmlspecialchars( MV_StreamFile::getTypeForQK( $mvDefaultMP4QualityKey ) ) .
					'" src="' . $mp4_stream_url . '"></source>';

			$o .= '</' . htmlspecialchars( $tag ) . '>';
			return $o;
		}
	}
	function getViewCount() {
		if ( $this->view_count == null ) {
			$dbr = & wfGetDB( DB_READ );
			$vars = array( 'COUNT(1) as hit_count' );
			$conds = array( 'stream_id =' . $dbr->addQuotes( $this->getStreamId() ),
							'start_time >= ' . $this->getStartTimeSeconds(),
							'end_time <= ' . $this->getEndTimeSeconds() );
			$this->view_count = $dbr->selectField( 'mv_clipview_digest',
						$vars,
						$conds,
						__METHOD__
					);
		}
		return $this->view_count;
	}
	function getTitleDesc() {
		if ( $this->type_marker ) {
			$title_str = wfMsg( 'mv_data_page_title',
				wfMsg( $this->type_marker ),
				$this->getStreamNameText(),
				$this->getTimeDesc() );
		} else {
			$title_str = $this->getStreamNameText() . ' ' . $this->getTimeDesc();
		}
		return $title_str;
	}
	 /*
	 * returns a parsed title/request
	 */
	function parseTitle( $title ) {
		global $mvDefaultClipLength;
 		// the metavid namespace:
 		// stream:stream_name ||
 		// mvd:type:stream_name_date/start_time/end_time

 		$parts = split( '/', $title );
		if ( !isset( $parts[1] ) )$parts[1] = '';
 		// check for type:
 		$sub_parts = split( ':', $parts[0] );

 		if ( count( $sub_parts ) == 2 ) {
 			if ( $sub_parts[0] == '' && $sub_parts[1] == '' ) {
 				$this->stream_name = null;
 				$this->type_marker = null;
 				$this->hasMVDType = false;
 			} else {
 				$this->stream_name = $sub_parts[1];
 				$this->type_marker = $sub_parts[0];
 				$this->hasMVDType = true;
 			}
 		} else {
 			if ( $parts[0] == '' ) {
 				$this->stream_name = null;
 			} else {
 				// print_r($sub_parts);
 				// @@todo do look up of single part request
 				$this->stream_name = $sub_parts[0];
 				// $this->stream_name = null;
 			}
 			$this->hasMVDType = false;
 		}
 		// check if the type isTime or "type"
 		if ( isset( $parts[1] ) ) {
 			if ( mvIsNtpTime( $parts[1] ) ) {
 					$this->start_time = $parts[1];
 					if ( isset( $parts[2] ) ) {
		 				if ( mvIsNtpTime( $parts[2] ) ) {
		 					$this->end_time = $parts[2];
		 				}
 					}
 			}
 		}
 		// (support null endtimes)
 		// if the endtime is unset set it to the default length after the start time:
 		// if(!isset($end_time)){
 			// $this->end_time = seconds2npt(npt2seconds($this->start_time) + $mvDefaultClipLength) ;
 		// }

 		// @@todo make sure start time is not negative & end time is not > duration

 		// validate the start time:
 		if ( mvIsNtpTime( $this->start_time ) == false )$this->start_time = null;

 		// validate the end time:
 		if ( $this->end_time != null ) {
 			if ( mvIsNtpTime( $this->end_time ) == false )$this->end_time = null;

 			// make sure the end time is > than the start time:
 			if ( npt2seconds( $this->start_time ) > npt2seconds( $this->end_time ) ) {
 				// @@TODO better error handling
 				$this->start_time = null;
 				$this->end_time = null;
 			}
 		}
 	}

}
