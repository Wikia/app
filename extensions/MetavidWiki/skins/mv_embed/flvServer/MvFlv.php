<?php

include_once 'FLV/FLV.php';

define( 'MAX_FLV_TS', 16777.216 );// it appears tag times restart after 16777.216 seconds;
define( 'KEY_FRAME_DISTANCE', 2 ); // max keyframe distance

// define('META_KFDATA_EXT', '.KfMeta'); //file extension for cached keframe metadata
define( 'META_DATA_EXT', '.meta' ); 	  // basic cached meta

class MyFLV extends FLV {

	/**
	 * On audio-only files the frame index will use this as minimum gap
	 */
	private $audioFrameGap = 3;

	private $origMetaOfs = 0;
	private $origMetaSize = 0;
	private $origMetaData;
	private $compMetaData;

	// added segment vars:
	private $fullMeta = null;
	private $mDuration = null;
	private $wrapTimeCount = 0;

	function getByteTimeReq( $start_time_sec, $end_time_sec = null ) {
		// print "play 	$start_time_sec to $end_time_sec";
		// @@todo cache byte offsets in memcache if avaliable
		if ( $end_time_sec )
			$this->mDuration = $end_time_sec - $start_time_sec;
		// print "SET metaDuration to:  " . $this->metaDuration . "\n";
		// print_r($fullMeta);
		$meta =& $this->getKeyFrameMetaData();
		// die;
		$start_byte = $end_byte = null;
		if ( $start_time_sec == 0 && $end_time_sec == null )$this->play();
		$start_time_ms = $start_time_sec * 1000;
		$end_time_ms = ( $end_time_sec == null ) ? null:$end_time_sec * 1000;

		for ( $i = 0; $i < count( $meta['times'] ); $i++ ) {
			// set to the keyframe right before a keyframe of the requested start time
			if ( $meta['times'][$i] >= $start_time_ms && $start_byte == null ) {
				$start_byte = ( isset( $meta['times'][$i - 1] ) ) ? $meta['filepositions'][$i - 1]:$meta['filepositions'][$i];
				if ( $end_time_ms == null )break;
			}
			// set to the keyframe right after the keyframe of the end time:
			if ( $end_time_ms != null ) {
				if ( $meta['times'][$i] >= $end_time_ms ) {
					$end_byte = $meta['filepositions'][$i];
					break;
				}
			}
		}
		return array( $start_byte, $end_byte );
	}
	function computeMetaData()
	{
		ini_set( "max_execution_time", "0" );// computeMetaData can take some time
		$this->compMetaData = array();
		$this->compMetaData['metadatacreator'] = 'FLV Tools';
		$this->compMetaData['metadatadate'] = gmdate( 'Y-m-d\TH:i:s' ) . '.000Z';
		$this->compMetaData['keyframes'] = array();
		$this->compMetaData['keyframes']['filepositions'] = array();
		$this->compMetaData['keyframes']['times'] = array();

		$this->origMetaOfs = 0;
		$this->origMetaSize = 0;
		$this->origMetaData = null;
		$oldTs = 0;
		$this->compMetaData['lasttimestamp'] = 0;

		$skipTagTypes = array();
		while ( $tag = $this->getTag( $skipTagTypes ) )
		{
			// pre-calculate the timestamp as seconds
    		$ts = $tag->timestamp / 1000;
	    	if ( $tag->timestamp > 0 && $tag->type == FLV_Tag::TYPE_VIDEO ) {
	    		$ts = ( MAX_FLV_TS * $this->wrapTimeCount ) + $ts;
	    		if ( $ts < $this->compMetaData['lasttimestamp'] ) {
	    			$this->wrapTimeCount++;
	    			$ts = MAX_FLV_TS + $ts;
	    		}
	    		// print "set end time to $ts \n";
		    	$this->compMetaData['lasttimestamp'] = $ts;
	    	}
	    	switch ( $tag->type )
	    	{
	        	case FLV_Tag::TYPE_VIDEO :
	           		// Optimization, extract the frametype without analyzing the tag body
	           		if ( ( ord( $tag->body[0] ) >> 4 ) == FLV_Tag_Video::FRAME_KEYFRAME )
	           		{
						$this->compMetaData['keyframes']['filepositions'][] = $this->getTagOffset();
						$this->compMetaData['keyframes']['times'][] = $ts;
	           		}

	            	if ( !in_array( FLV_TAG::TYPE_VIDEO, $skipTagTypes ) )
	            	{
	                	$this->compMetaData['width'] = $tag->width;
	                	$this->compMetaData['height'] = $tag->height;
	                	$this->compMetaData['videocodecid'] = $tag->codec;
						// Processing one video tag is enough
	            		array_push( $skipTagTypes, FLV_Tag::TYPE_VIDEO );
	            	}
	        		break;
	        	case FLV_Tag::TYPE_AUDIO :
					// Save audio frame positions when there is no video
	        		if ( $ts - $oldTs > $this->audioFrameGap )
	        		{
		        		$this->compMetaData['keyframes']['filepositions'][] = $this->getTagOffset();
		        		$this->compMetaData['keyframes']['times'][] = $ts;
		        		$oldTs = $ts;
	        		}
	            	if ( !in_array( FLV_Tag::TYPE_AUDIO, $skipTagTypes ) )
	            	{
		            	$this->compMetaData['audiocodecid'] = $tag->codec;
		            	$this->compMetaData['audiofreqid'] = $tag->frequency;
		            	$this->compMetaData['audiodepthid'] = $tag->depth;
		            	$this->compMetaData['audiomodeid'] = $tag->mode;

						// Processing one audio tag is enough
	            		array_push( $skipTagTypes, FLV_Tag::TYPE_AUDIO );
	            	}
	        	break;
	        	case FLV_Tag::TYPE_DATA :
	            	if ( $tag->name == 'onMetaData' )
	            	{
	            		$this->origMetaOfs = $this->getTagOffset();
	            		$this->origMetaSize = $tag->size + self::TAG_HEADER_SIZE;
	            		$this->origMetaData = $tag->value;
	            	}
	        	break;
	    	}

	    	// Does this actually help with memory allocation?
	    	unset( $tag );
		}

		if ( ! empty( $this->compMetaData['keyframes']['times'] ) )
			$this->compMetaData['lastkeyframetimestamp'] = $this->compMetaData['keyframes']['times'][ count( $this->compMetaData['keyframes']['times'] ) - 1 ];

		$this->compMetaData['duration'] = $this->compMetaData['lasttimestamp'];

		return $this->compMetaData;
	}

	function setMetaData( $metadata, $origMetaOfs = 0, $origMetaSize = 0 )
	{
		$this->compMetaData = $metadata;
		$this->origMetaOfs = $origMetaOfs;
		$this->origMetaSize = $origMetaSize;
	}
	/* returns merged metadata*/
	function getMetaData()
	{
		if ( $this->fullMeta )return $this->fullMeta;
		if ( is_file( $this->fname . META_DATA_EXT ) ) {
			$this->fullMeta = unserialize( file_get_contents ( $this->fname . META_DATA_EXT ) );
		} else {
			$this->computeMetaData();
			if ( ! is_array( $this->origMetaData ) ) {
				$this->fullMeta = $this->compMetaData;
			} else {
				$this->fullMeta = array_merge( $this->origMetaData, $this->compMetaData );
			}
			// free non-merged arrays:
			unset( $this->origMetaData );
			unset( $this->compMetaData );
			// convert floats to int
			foreach ( $this->fullMeta['keyframes']['times'] as $inx => & $ts ) {
				$ts = (int)( $ts * 1000 );
			}
			if ( !file_put_contents( $this->fname . META_DATA_EXT, serialize( $this->fullMeta ) ) ) {
				 throw( new FLV_FileException( 'Unable to write out cached keyframe output' ) );
			}
		}
		return $this->fullMeta;
	}
	function getKeyFrameMetaData() {
		$meta = & $this->getMetaData();
		return $meta['keyframes'];
	}
	function getSegmentMetaData() {
		// pull base cached metadata
		// update duration & return new array
		$meta = & $this->getMetaData();
		$meta['keyframes'] = array();
		// @@todo update all the other metadata to match segment outupt
		return $meta;
	}
	function play( $from = 0, $play_to = null )
	{
		fseek( $this->fp, 0 );

		// get original file header just in case it has any special flag
		echo fread( $this->fp, $this->bodyOfs + 4 );

		// output the metadata if available
		$meta = $this->getSegmentMetaData();
		// $meta = $this->getMetaData();

		if ( ! empty( $meta ) )
		{
			// serialize the metadata as an AMF stream
			include_once 'FLV/Util/AMFSerialize.php';
			$amf = new FLV_Util_AMFSerialize();

			$serMeta = $amf->serialize( 'onMetaData' );
			$serMeta .= $amf->serialize( $meta );

			// Data tag mark
			$out = pack( 'C', FLV_Tag::TYPE_DATA );
			// Size of the data tag (BUG: limited to 64Kb)
			$out .= pack( 'Cn', 0, strlen( $serMeta ) );
			// Timestamp
			$out .= pack( 'N', 0 );
			// StreamID
			$out .= pack( 'Cn', 0, 0 );

			echo $out;
			echo $serMeta;

			// PrevTagSize for the metadata
			echo pack( 'N', strlen( $serMeta ) + strlen( $out ) );
		}

		$chunkSize = 4096;
		$skippedOrigMeta = empty( $this->origMetaSize );
		// seek to offset point:
		fseek( $this->fp, $from );
		while ( ! feof( $this->fp ) )
		{
			// if the original metadata is pressent and not yet skipped...
			if ( ! $skippedOrigMeta )
			{
				$pos = ftell( $this->fp );

				// check if we are going to output it in this loop step
				if ( $pos <= $this->origMetaOfs &&
					 $pos + $chunkSize > $this->origMetaOfs )
				{
					// output the bytes just before the original metadata tag
					if ( $this->origMetaOfs - $pos > 0 )
						echo fread( $this->fp, $this->origMetaOfs - $pos );

					// position the file pointer just after the metadata tag
					fseek( $this->fp, $this->origMetaOfs + $this->origMetaSize );

					$skippedOrigMeta = true;
					continue;
				}
			}
			if ( $play_to != null ) {
				if ( ftell( $this->fp ) + $chunkSize > $play_to ) {
					$read_amount = ( ftell( $this->fp ) + $chunkSize ) - $play_to;
					echo fread( $this->fp, $read_amount );
					break;
				}
			}
			echo fread( $this->fp, $chunkSize );
		}
	}
}
