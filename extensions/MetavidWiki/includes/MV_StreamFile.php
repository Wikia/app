<?php
/*
 * MV_StreamFiles.php Created on Sep 25, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 /*
  * MvStreamFile handles the mapping of path types to urls & 
  * active record style management of the mv_stream_files table
  */
 class MV_StreamFile {
 	var $stream_id = '';
 	var $base_offset = '';// base offset from the stream  date_start_time
 	var $duration = '';	// duration of clip.
 	var $file_desc_msg = '';
 	var $path_type = '';
 	var $id = '';
 	var $path = '';
 	var $_parent_stream = null;
 	
 	// @@todo this should not be hard coded... read the header of the file? or extend path_type 
 	function getTypeForQK( $key ) {
 		global 	$mvMsgContentTypeLookup;
 		if ( isset( $mvMsgContentTypeLookup[$key] ) )
 		 	return $mvMsgContentTypeLookup[$key];
 	}
 	function __construct( &$parent_stream, $initRow = '' ) {
 		$this->_parent_stream =& $parent_stream;
 		// no init val.. populate from db 		 	
 		if ( $this->_parent_stream && $initRow == '' ) {
 			$this->getStreamFileDB();
 		} else {
 			// populate from the initRow obj
			if ( is_object( $initRow ) )
				$initRow = get_object_vars( $initRow );
			if ( is_array( $initRow ) ) {
				$this->updateValues( $initRow );
			}
 		}
 	}
 	function getNameKey() {
 		return $this->file_desc_msg;
 	}
 	function getContentType() {
 		global $mvMsgContentTypeLookup;
 		if ( isset( $mvMsgContentTypeLookup[$this->file_desc_msg] ) ) {
 			return $mvMsgContentTypeLookup[$this->file_desc_msg];
 		}
 		// default content type? 
 		return 'application/octet-stream';
 	}
 	function updateValues( $initRow ) {
		foreach ( $initRow as $key => $val ) {
			// make sure the key exist and is not private
			if ( isset ( $this-> $key ) && $key[0] != '_' ) {
				$this->$key = $val;
			}
		}
 	}
 	function deleteStreamFileDB() {
 		$dbw = & wfGetDB( DB_WRITE );
 		$dbw->delete( 'mv_stream_files', array( 'id' => $this->id ) );
 	}
 	function writeStreamFileDB() {
 		$dbw = & wfGetDB( DB_WRITE );
 		if ( $this->id == '' ) {
			$dbw->insert( 'mv_stream_files', array(
				'stream_id' => $this->stream_id,
				'base_offset' => $this->base_offset,
				'duration' => $this->duration,
				'file_desc_msg' => $this->file_desc_msg,
				'path_type' => $this->path_type,
				'path' => $this->path
			), __METHOD__ );
 		} else {
 			// update: 
 			$dbw->update( 'mv_stream_files', array(
				'base_offset' => $this->base_offset,
				'duration' => $this->duration,
				'file_desc_msg' => $this->file_desc_msg,
				'path_type' => $this->path_type,
				'path' => $this->path
			), array( 'id' => $this->id ), __METHOD__ );
 		}
 	}
 	function getStreamFileDB( $quality = null ) {
		global $mvDefaultVideoQualityKey;
		if ( $quality == null )$quality = $mvDefaultVideoQualityKey;
		$dbr = & wfGetDB( DB_READ );
		$result = $dbr->select( 'mv_stream_files', array( 'path' ), array (
			'stream_id' => $this->_parent_stream->getStreamId(),
			'file_desc_msg' => $quality
		) );
		$row  = $dbr->fetchObject( $result );
		if ( $row ) {
			$ary = get_object_vars( $row );
			foreach ( $ary as $k => $v ) {
				$this->$k = $v;
			}
		}
	}
	// @@todo as mentioned before we should better integrate with medaiWikis commons file system
	// returns the local path (if the video file is local) if not return null 
	function getLocalPath( $quality = null ) {
		global $mvLocalVideoLoc, $mvDefaultVideoQualityKey;
		if ( $quality == null )$quality = $mvDefaultVideoQualityKey;
		
		if ( !is_dir( $mvLocalVideoLoc ) )return null;
		if ( !is_file( $mvLocalVideoLoc . $this->_parent_stream->getStreamName() ) )return null;
		// all looks good return: 		
		return $mvLocalVideoLoc . $this->_parent_stream->getStreamName();
	}
	function getDuration(){
		return $this->duration;
	}
 	/*
 	 * returns the path with {sn} replaced with stream name if present
 	 */
 	function getPath() {
 		return $this->path;
 		// return str_replace('{sn}',$this->_parent_stream->name, $this->path);
 	}
 	function getPathType() {
 		return $this->path_type;
 	}
	function supportsURLTimeEncoding() {
		return ( $this->path_type == 'url_anx' || $this->path_type=='mp4_stream' );
	}
 	function getFullURL() {
 		// @@todo check on path if local 
 		return $this->getPath();
 	}
 	function get_desc() {
 		return wfMsg( $this->file_desc_msg );
 	}
 }
