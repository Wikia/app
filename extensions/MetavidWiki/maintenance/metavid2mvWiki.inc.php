<?php
/**
 * metavid2mvWiki.inc.php Created on Jan 19, 2008
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 */

 /*
  * Templates:
  */
require_once ( '../../../maintenance/commandLine.inc' );
// $i=0;
function do_stream_attr_check( $old_stream ) {
	global $i;
	$mvStream = & mvGetMVStream( array (
		'name' => $old_stream->name
	) );
	// print "doding stream attr check: ";
	// print_r($old_stream);

	if ( $mvStream->date_start_time != $old_stream->adj_start_time ) {
		$mvStream->date_start_time = $old_stream->adj_start_time;
	}
	if ( $mvStream->duration != ( $old_stream->adj_end_time - $old_stream->adj_start_time ) ) {
		$mvStream->duration = ( $old_stream->adj_end_time - $old_stream->adj_start_time );
	}
	$mvStream->updateStreamDB();
	print "$old_stream->name update: duration:" . seconds2npt( $mvStream->duration ) . ' startDay:' . date( 'm-d-y', $mvStream->date_start_time ) . "\n";
	// if($i==3)die;
	// $i++;
}
function get_all_mv_streams(){
	$dbr = wfGetDB( DB_READ );
	$streams = array();
	$result = $dbr->select( 'mv_streams',
		'*',
		'',
		__METHOD__
	);
	if ( $dbr->numRows( $result ) == 0 )die("do_stream_file_check: no streams found");
	while ( $stream = $dbr->fetchObject( $result ) ) {
		$streams[$stream->id] = $stream;
	}
	return $streams;
}
function do_remove_orphaned_streams(){
	//get all stream ids present in mv_stream_files and mv_stream_images
	$dbr = wfGetDB( DB_READ );
	$orphaned_streams = array();
	$all_valid_streams = get_all_mv_streams();
	//could be done with a join ..oh well
	$result = $dbr->select( 'mv_stream_files',
		'stream_id',
		'',
		__METHOD__,
		array( 'GROUP BY' => 'stream_id')
	);
	while ( $stream = $dbr->fetchObject( $result ) ) {
		if(!isset($all_valid_streams[$stream->stream_id ])){
			$orphaned_streams[ $stream->stream_id ] = 1;
		}
	}
	$result = $dbr->select( 'mv_stream_images',
		'stream_id',
		'',
		__METHOD__,
		array( 'GROUP BY' => 'stream_id')
	);
	while ( $stream = $dbr->fetchObject( $result ) ) {
		if( !isset($all_valid_streams[ $stream->stream_id ] ) ){
			$orphaned_streams[ $stream->stream_id ] = 1;
		}
	}
	foreach($orphaned_streams as $stream_id => $na){
		$mvStream = new MV_Stream( array('id'=> $stream_id) );
		//double check stream does not exist:
		if( ! $mvStream->doesStreamExist() ){
			print "stream id: {$stream_id} does not exist in stream table (remove)\n";
			//remove files in the stream directory:
			$filedir = '/video/metavid/mvprime_stream_images/' .
							 MV_StreamImage::getRelativeImagePath( $stream_id );
			//print "dir is: $filedir \n";
			if( is_dir($filedir )){
				$cmd = 'rm -rf ' . $filedir;
				print "removing image run#: $cmd \n";
				shell_exec($cmd);
			}
			//print "removing DB entires for $stream_id\n";
			$mvStream->deleteDB();
		}
	}
	/*$streams = get_all_mv_streams();
	foreach( $streams as $stream){
		//check if stream page exists:
		$mvStreamTitle = Title::newFromText( $stream->name, MV_NS_STREAM );
		if( !$mvStreamTitle->exists() ){
			print "stream: {$stream->name} does not exist as a wiki page\n";
			//should remove here
			$mvStream = new MV_Stream( $stream );
		}
	}*/
}
function do_stream_date_check(){
	$streams = get_all_mv_streams();
	foreach ( $streams as $stream ) {
		preg_match("/([0-9]+-[0-9]+-[0-9]+)/", $stream->name, $matches);
		if( ! isset( $matches[1] ) ){
			print "no date found in {$stream->name}\n";
			continue;
		}
		$sdate = $force_update = false;
 		//check for srt file:
 		$srt_file = '/video/metavid/raw_mpeg2/' . $stream->name . '.srt';
 		if( is_file( $srt_file ) ){
 			$srt_ary = file( $srt_file );
 			$time = intval( trim( str_replace( 'starttime' , '', $srt_ary[2] )) );
 			//ignore bad .srt values (before 08
			if( intval( date('y', $time) > 8)) {
	 			if( $stream->date_start_time != $time){
	 				$sdate=$time;
	 				$force_update = true;
	 				print "force srt update:: ";
	 			}
	 		}
 		}
 		//no date from srt make starting at 9am
 		if( !$sdate ){
			$sd = explode('-',$matches[1]);
			$sdate = mktime( 9, 0, 0, $sd[0], $sd[1], intval('20'.$sd[2]) );
 		}
		if( date('d-y', $stream->date_start_time) != date('d-y',$sdate) || $force_update ) {
			//print "should update date: " . $stream->date_start_time . ' to '.  $sdate . ' for ' . $stream->name . "\n";
			$dbw = wfGetDB( DB_WRITE );
			$sql = "UPDATE `mv_streams` SET `date_start_time`= '$sdate' " .
					" WHERE `id`={$stream->id} LIMIT 1 ";
			$dbw->query($sql);
			print "$stream->name date updated\n";
		}else{
           	print "$stream->name date is ok\n";
		}
	}
}
function do_stream_file_check( $old_stream=false ) {
	global $mvgIP, $mvVideoArchivePaths;
	$stream_set = Array();
	if($old_stream==false){
		$stream_set = get_all_mv_streams();
	}else{
		$stream_set = Array( $old_stream );
	}
	foreach($stream_set as $stream){
		$mvStream = & mvGetMVStream( array (
			'name' => $stream->name,
			'duration' => $stream->duration
		) );
		$file_list = $mvStream->getFileList();
		//print 'f:do_stream_file_check:' . $stream->name . ' dur: ' . $mvStream->getDuration() . "\n";

		// @@todo have multiple file locations for same file?
		$set = array();
		foreach ( $mvVideoArchivePaths as $path ) {
			if ( url_exists( $path . $stream->name . '.ogg' ) ) {
				$set['mv_ogg_low_quality'] = $path . $stream->name . '.ogg';
				// force cap1 path @@todo remove!:
				// $set['mv_ogg_low_quality']='http://128.114.20.64/media/' . $stream->name . '.ogg';
			}
			if ( url_exists( $path . $stream->name . '.HQ.ogg' ) ) {
				$set['mv_ogg_high_quality'] = $path . $stream->name . '.HQ.ogg';
				// force cap1 path @@todo remove!:
				// $set['mv_ogg_high_quality']='http://128.114.20.64/media/' . $stream->name . '.HQ.ogg';
			}
			if ( url_exists( $path . $stream->name . '.flv' ) ) {
				$path = str_replace('/media/','', $path);
				$set['mv_flash_low_quality'] = $path . '/mvFlvServer.php/'. $stream->name . '.flv';
				// force cap1 path @@todo remove!:
				// $set['mv_ogg_high_quality']='http://128.114.20.64/media/' . $stream->name . '.HQ.ogg';
			}
		}

		//check archive.org paths:


		if ( count( $set ) == 0 ) {
			// no files present (remove stream)
			print 'no files present should remove: ' . $stream->name . "\n";
			continue;
		}
		$dbw = wfGetDB( DB_WRITE );
		$sql = "DELETE FROM `mv_stream_files` WHERE `stream_id`=" . $mvStream->id . " AND " .
				"(`file_desc_msg`='mv_ogg_high_quality' " .
				" OR `file_desc_msg`='mv_ogg_low_quality' " .
				" OR `file_desc_msg`='mv_flash_low_quality')";
		$dbw->query( $sql );
		// update files:
		if(!isset($set['mv_ogg_low_quality'])){
			print "Missing lowQ ogg for: "	.$stream->name ."\n";
		}
		if(!isset($set['mv_ogg_high_quality'])){
			print "Missing highQ ogg for: "	.$stream->name ."\n";
		}
		if(!isset($set['mv_flash_low_quality'])){
			print "Missing flash for: "	.$stream->name ."\n";
		}
		foreach ( $set as $qf => $path_url ) {
			do_insert_stream_file( $mvStream, $path_url, $qf );
		}
	}
}

function do_insert_stream_file( $mvStream, $path, $quality_msg ) {
	global $mvVideoArchivePaths;
	$dbw = wfGetDB( DB_WRITE );
	$dur = $mvStream->getDuration();
	// get file duration from nfo file :
	$dur = $mvStream->getDuration();
	if($dur == 0){
		$nfo_url = $path . '.nfo';
		if( url_exists($nfo_url) ){
			$nfo_txt = @file( $nfo_url );
			if ( $nfo_txt !== false ) {
				if ( isset( $nfo_txt[0] ) ) {
					list( $na, $len ) = explode( 'n:', $nfo_txt[0] );
					$len = trim( $len );
					// trim leading zero
					if ( $len[0] == '0' )$len = substr( $len, 1 );
					// trim sub frame times:
					if ( strpos( $len, '.' ) !== false ) {
						$len = substr( $len, 0, strpos( $len, '.' ) );
					}
					$dur = npt2seconds( $len );
				} else {
					echo "empty nfo file: $nfo_url \n";
					$dur = 0;
				}
			} else {
				echo "missing nfo file: $nfo_url \n";
				$dur = 0;
			}
		}
	}
	$sql = "INSERT INTO `mv_stream_files` (`stream_id`, `file_desc_msg`, `path`, `duration`)" .
		" VALUES ('{$mvStream->id}', '{$quality_msg}', '{$path}', {$dur} )";
	$dbw->query( $sql );
}
// @@todo convert to MV_EditStream
function do_add_stream( & $mvTitle, & $stream ) {
	$MV_SpecialAddStream = new MV_SpecialCRUDStream( 'add' );
	$MV_SpecialAddStream->stream_name = $mvTitle->getStreamName();
	$MV_SpecialAddStream->stream_type = 'metavid_file';
	$MV_SpecialAddStream->stream_desc = mv_semantic_stream_desc( $mvTitle, $stream );
	// add the stream:
	$MV_SpecialAddStream->add_stream();
}
function do_stream_insert( $mode, $stream_name = '' ) {
	global $mvgIP, $MVStreams, $options, $args, $wgDBname;
	$dbr = wfGetDB( DB_SLAVE );
	if ( $mode == 'all' ) {
		$sql = "SELECT * FROM `metavid`.`streams` WHERE `sync_status`='in_sync'";
	} elseif ( $mode == 'files' ) {
		$sql = "SELECT * FROM `metavid`.`streams` WHERE `trascoded` != 'none'";
	} elseif ( $mode == 'all_in_wiki' ) {
		$sql = "SELECT `metavid`.`streams`.* FROM `$wgDBname`.`mv_streams` LEFT JOIN `metavid`.`streams` ON (`$wgDBname`.`mv_streams`.`name` = `metavid`.`streams`.`name`) ";
	} elseif ( $mode == 'all_sync_past_date' ) {
		print "doing all after: " . $args[$options['date']] . "\n";
		list( $month, $day, $year ) = explode( '/', $args[$options['date']] );
		$date_time = mktime( 0, 0, 0, $month, $day, $year );
		$sql = "SELECT * FROM `metavid`.`streams` WHERE `sync_status`= 'in_sync' AND `adj_start_time` > $date_time";
	} else {
		$sql = "SELECT * FROM `metavid`.`streams` WHERE `name` LIKE '{$stream_name}'";
	}
	$res = $dbr->query( $sql );
	if ( $dbr->numRows( $res ) == 0 )
		die( 'could not find stream: ' . $stream_name . "\n" );
	// load all stream names:
	while ( $row = $dbr->fetchObject( $res ) ) {
		$streams[] = $row;
	}
	print "working on " . count( $streams ) . ' streams' . "\n";
	foreach ( $streams as $stream ) {
		print "on stream $stream->name \n";
		$force = ( isset( $options['force'] ) ) ? true:false;
		// init the stream
		$MVStreams[$stream->name] = new MV_Stream( $stream );
		// check if the stream has already been added to the wiki (if not add it)
		$mvTitle = new MV_Title( 'Stream:' . $stream->name );
		if ( !$mvTitle->doesStreamExist() ) {
			// print 'do stream desc'."\n";
			do_add_stream( $mvTitle, $stream );
			echo "stream " . $mvTitle->getStreamName() . " added \n";
		} else {
				do_update_wiki_page( $stream->name, mv_semantic_stream_desc( $mvTitle, $stream ), MV_NS_STREAM, $force );
			// $updated = ' updated' echo "stream " . $mvTitle->getStreamName() . " already present $updated\n";
		}
		if ( $mode != 'all_in_wiki' ) {
			// add duration and start_time attr
			do_stream_attr_check( $stream );
		}
		// do insert/copy all media images
		if ( !isset( $options['skipimage'] ) ) {
			do_process_images( $stream, $force );
			print "done with images\n";
		}
		if ( !isset( $options['skipfiles'] ) ) {
			// check for files (make sure they match with metavid db values
			do_stream_file_check( $stream );
		}
		if ( !isset( $options['skiptext'] ) ) {
			// process all stream text:
			do_process_text( $stream, $force );
		}
		if ( !isset( $options['skipSpeechMeta'] ) ) {
			// do annoative track for continus speches
			do_annotate_speeches( $stream, $force );
		}
	}
}
function do_annotate_speeches( $stream, $force ) {
	print "do annotations for $stream->name \n";
	$dbr = wfGetDB( DB_SLAVE );
	if ( $force ) {
		global $botUserName;
		// get wiki stream id:
		$wikiStream = new MV_Stream( array( 'name' => $stream->name ) );
		// first remove all bot edited pages:
		$mvd_rows =& MV_Index::getMVDInRange( $wikiStream->getStreamId(), null, null, 'Anno_en' );
		foreach ( $mvd_rows as $row ) {
			$title = Title::newFromText( $row->wiki_title, MV_NS_MVD );
			$current = Revision::newFromTitle( $title );
			if ( $current->getUserText() == $botUserName ) {
				$article = new Article( $title );
				$article->doDelete( 'mvbot removal' );
				print "removed $row->wiki_title \n";
			} else {
				print "skiped $roe->wiki_title (last edit by: " . $current->getUserText() . ")\n";
			}
		}
	}
	// get all mvd's
	$mvStream = MV_Stream::newStreamByName( $stream->name );
	if ( $mvStream->doesStreamExist() ) {
		$dbr = wfGetDB( DB_SLAVE );
		// get all pages in range (up 10k)
		$mvd_rows =& MV_Index::getMVDInRange( $mvStream->getStreamId(), null, null, 'Ht_en', false, 'Spoken_By', array('LIMIT'=>10000) );
		if ( count( $mvd_rows ) != 0 ) {
			print "looking at ". count( $mvd_rows ). " text rows\n";
			$prev_person = '';
			$prev_st = $prev_et = 0;
			foreach($mvd_rows as $mvd){
				//print "On: ".$mvd->Spoken_By."\n";
				if ( $mvd->Spoken_By ) {
					if ( $prev_person == '' ) {
						$prev_person = $mvd->Spoken_By; // init case:
						$prev_st = $mvd->start_time;
						$prev_et = $mvd->end_time;
					} else {
						if ( $prev_person == $mvd->Spoken_By ) {
							// continue
							// print "acumulating for $mvd->Spoken_by \n";
							$prev_et = $mvd->end_time;
						} else {
							// diffrent person: if more than 1 min long
							if ( $prev_et - $prev_st > 60 ) {
								$doSpeechUpdate = true;
								print "insert annotation $prev_person: " . seconds2npt( $prev_st ) . " to " . seconds2npt( $prev_et ) . " \n";
								// check for existing speech by in range if so skip (add subtract 1 to start/end (to not get matches that land on edges) (up to 10,000 meta per stream)
								$mvd_anno_rows = MV_Index::getMVDInRange( $mvStream->getStreamId(), $prev_st + 1, $prev_et - 1, 'Anno_en', false, 'Speech_by' );
								foreach($mvd_anno_rows as  $row) {
									if ( $row->Speech_by ) {
										print ".. range already has: $row->Speech_by skip\n";
										$doSpeechUpdate = false;
										break;
									}
								}
								if ( $doSpeechUpdate ) {
									$page_txt = '[[Speech by:=' . str_replace( '_', ' ', $prev_person ) . ']]';
									$annoTitle = Title::makeTitle( MV_NS_MVD, 'Anno_en:' . $mvStream->getStreamName() . '/' . seconds2npt( $prev_st ) . '/' . seconds2npt( $prev_et ) );
									do_update_wiki_page( $annoTitle, $page_txt );
								}
							}
							$prev_person = $mvd->Spoken_By; // init case:
							$prev_st = $mvd->start_time;
						}
					}
				}
			}
			print "\n\ndone with annotation inserts got to " . seconds2npt( $prev_et ) . ' of ' . seconds2npt( $mvStream->getDuration() ) . "\n";
		}else{
			print "no annotations added 0 mvd transcript pages found\n";
		}
	}
}
function do_process_text( $stream, $force ) {
		$dbr = wfGetDB( DB_SLAVE );
		if ( $force ) {
			global $botUserName;
			// get wiki stream id:
			$wikiStream = new MV_Stream( array( 'name' => $stream->name ) );
			// first remove all bot edited pages:
			$mvd_res = MV_Index::getMVDInRange( $wikiStream->getStreamId(), null, null, 'Ht_en' );
			while ( $row = $dbr->fetchObject( $mvd_res ) ) {
				$title = Title::newFromText( $row->wiki_title, MV_NS_MVD );
				$current = Revision::newFromTitle( $title );
				if ( $current->getUserText() == $botUserName ) {
					$article = new Article( $title );
					$article->doDelete( 'mvbot removal' );
					print "removed $row->wiki_title \n";
				} else {
					print "skiped $roe->wiki_title (last edit by: " . $current->getUserText() . ")\n";
				}
			}
		}
		/* for now use the stream search table (in the future should put in our orphaned person data)
		 * should be able to do quick checks against the index. */
		$sql = "SELECT (`time`+" . CC_OFFSET . ") as time, `value` " .
				"FROM `metavid`.`stream_attr_time_text`
						WHERE `stream_fk`=" . $stream->id . "
						AND `time` >= " . $stream->adj_start_time . "
						AND `time` <= " . $stream->adj_end_time . "
				ORDER BY `time` ASC ";

		// $sql = "SELECT * FROM `metavid`.`stream_search` WHERE `stream_fk`={$stream->id}";
		$page_res = $dbr->query( $sql );
		if ( $dbr->numRows( $page_res ) == 0 )
			echo 'No pages for stream' . $stream->name . "\n";
		$pages = array ();
		while ( $page = $dbr->fetchObject( $page_res ) ) {
			$pages[] = $page;
		}
		print "Checking " . count( $pages ) . " text pages\n";
		$i = $j = 0;
		foreach ( $pages as $inx => $page ) {
			// status updates:
			if ( $i == 50 ) {
				print "on $j of " . count( $pages ) . "\n";
				$i = 0;
			}
			$i++;
			$j++;
			$start_time = $page->time - $stream->adj_start_time;
			if ( seconds2npt( $start_time ) < 0 )
				$start_time = '0:00:00';
			if ( ( $inx + 1 ) == count( $pages ) ) {
				$end_time = $stream->adj_end_time - $stream->adj_start_time;
			} else {
				$end_time = $pages[$inx + 1]->time - $stream->adj_start_time;
			}
			if ( ( $end_time - $start_time ) > 40 )
				$end_time = $start_time + 40;
			// skip if end_time <1
			if ( $end_time < 0 )
				continue;
			// now pull up the person for the given stream time:`metavid`.`people`.`name_clean`
			$sql = "SELECT * , abs( `metavid`.`people_attr_stream_time`.`time` -{$page->time} ) AS `distance` " .
			"FROM `metavid`.`people_attr_stream_time` " .
			"LEFT JOIN `metavid`.`people` ON `metavid`.`people_attr_stream_time`.`people_fk` = `metavid`.`people`.`id` " .
			"WHERE `metavid`.`people_attr_stream_time`.`stream_fk` ={$stream->id} " .
				// have a negative threshold of 4 seconds
			"AND  (`metavid`.`people_attr_stream_time`.`time`-{$page->time})>-4 " .
				// have a total distance threshold of 30 seconds
			"AND abs( `metavid`.`people_attr_stream_time`.`time` -{$page->time} )< 90 " .
			"ORDER BY `distance` ASC " .
			"LIMIT 1 ";
			$person_res = $dbr->query( $sql );

			$page_title = $stream->name . '/' . seconds2npt( $start_time ) . '/' . seconds2npt( $end_time );
			// print $page_title . "\n";
			$page_body = '';
			if ( $dbr->numRows( $person_res ) != 0 ) {
				$person = $dbr->fetchObject( $person_res );
				$person_name = utf8_encode( $person->name_clean );
				$page_body .= "\n[[Spoken By::{$person_name}]] ";
			}
			$page_body .= trim( str_replace( "\n", ' ', strtolower( $page->value ) ) );

			// print $page_title . "\n";
			// die;
			// print $page_body . "\n\n";
			do_update_wiki_page( 'Ht_en:' . $page_title, $page_body, MV_NS_MVD );
		}
}
/**
 * for each image add it to the image directory
 */
function do_process_images( $stream, $force = false ) {
	global $mvLocalImgLoc, $MVStreams, $wgDBname;
	$dbr = wfGetDB( DB_SLAVE );
	$dbw = wfGetDB( DB_MASTER );

	// get all images for the current stream:
	$sql = "SELECT * FROM `metavid`.`image_archive`
				WHERE `stream_fk`= {$stream->id}";
	$image_res = $dbr->query( $sql );
	$img_count = $dbr->numRows( $image_res );
	print "Found " . $img_count . " images for stream " . $stream->name . "\n";
	// grab from metavid and copy to local directory structure:
	$i = $j = 0;
	$mv_stream_id = $MVStreams[$stream->name]->getStreamId();
	// if force we can clear out existing images:
	if ( $force ) {
		print "force update flag (remove all existing images)\n";
		$local_img_dir = MV_StreamImage::getLocalImageDir( $mv_stream_id );
		$res = $dbr->query( "SELECT * FROM `$wgDBname`.`mv_stream_images` WHERE  `stream_id`={$mv_stream_id}" );
		while ( $row = $dbr->fetchObject( $res ) ) {
			$local_img_file = $local_img_dir . '/' . $row->time . '*.jpg';
			shell_exec( 'rm -f ' . $local_img_file );
		}
		// remove db entries:
		$dbw->query( "DELETE FROM `$wgDBname`.`mv_stream_images` WHERE  `stream_id`={$mv_stream_id}" );
	}
	while ( $row = $dbr->fetchObject( $image_res ) ) {
		// if(isset($row->
		$relative_time = $row->time - $stream->adj_start_time;
		// status updates:
		if ( $i == 10 ) {
			print "On image $j of $img_count time: " . seconds2npt( $relative_time ) . " $metavid_img_url\n";
			$i = 0;
		}
		$j++;
		$i++;
		// get streamImage obj:

		$local_img_dir = MV_StreamImage::getLocalImageDir( $mv_stream_id );
		$metavid_img_url = 'http://metavid.org/image_media/' . $row->id . '.jpg';

		$local_img_file = $local_img_dir . '/' . $relative_time . '.jpg';
		// check if the image already exist in the new table
		$sql = "SELECT * FROM `$wgDBname`.`mv_stream_images` " .
				"WHERE `stream_id`={$mv_stream_id} " .
				"AND `time`=$relative_time";
		$img_check = $dbr->query( $sql );
		$doInsert = true;
		if ( $dbr->numRows( $img_check ) != 0 ) {
			// make sure its there and matches what it should be:
			if ( is_file( $local_img_file ) ) {
				$row = $dbr->fetchObject( $img_check );
				// print "file $local_img_file skiped, stream_id:" . $mv_stream_id . " time: " . seconds2npt($relative_time) . "\n";
				continue;
			} else {
				// grab but don't insert:
				$doInsert = false;
			}
		}
		if ( $doInsert ) {
			// insert:
			$dbw->insert( 'mv_stream_images', array (
				'stream_id' => $MVStreams[$stream->name]->getStreamId(), 'time' => $relative_time ) );
			$img_id = $dbw->insertId();
			// $grab = exec('cd ' . $img_path . '; wget ' . $im_url);
		}

		if ( is_file( $local_img_file ) ) {
			echo "skipped $local_img_file \n";
			continue;
		}
		// print "run copy: $metavid_img_url, $local_img_file \n";
		if ( !copy( $metavid_img_url, $local_img_file ) ) {
			echo "failed to copy $metavid_img_url to $local_img_file...\n";
		} else {
			// all good don't report anything'
			// print "all good\n";
		}
	}
}


// given a stream name it pulls all metavid stream data and builds semantic wiki page
function mv_semantic_stream_desc( & $mvTitle, & $stream ) {
	/*$sql = "SELECT * FROM `metavid`.`streams` WHERE `name` LIKE '" . $mvTitle->getStreamName() . "'";
	$dbr = wfGetDB(DB_SLAVE);
	$res = $dbr->query($sql);
	//echo "\n" . $sql . "\n";
	$stream = $dbr->fetchObject($res);*/
	//$stream_id = $stream->id;
	$out = '';
	//(if we have old version of stream copy over is properties)
	if( isset( $stream->org_start_time ) )
		$stream->date_start_time = $stream->org_start_time;


	$start_time = $stream->date_start_time;



	// add links/generic text at the start
	$date = date( 'Ymd', $start_time );
	$cspan_date = date( 'Y-m-d', $start_time );
	$ch_type = '';
	if ( strpos( $mvTitle->getStreamName(), 'house' ) !== false )
		$ch_type = 'h';
	if ( strpos( $mvTitle->getStreamName(), 'senate' ) !== false )
		$ch_type = 's';
	if ( $ch_type != '' ) {
		$out .= '==Official Record==' . "\n";
		$out .= '*[http://www.govtrack.us/congress/recordindex.xpd?date=' . $date .
		'&where=' . $ch_type .
		' GovTrack Congressional Record]' . "\n\n";
		$out .= '*[http://thomas.loc.gov/cgi-bin/query/B?r110:@FIELD(FLD003+' . $ch_type . ')+@FIELD(DDATE+' . $date . ')' .
		' THOMAS Congressional Record]' . "\n\n";
		$out .= '*[http://thomas.loc.gov/cgi-bin/query/B?r110:@FIELD(FLD003+' . $ch_type . ')+@FIELD(DDATE+' . $date . ')' .
		' THOMAS Extension of Remarks]' . "\n\n";
	}
	$dbw = wfGetDB( DB_WRITE );

	//clear out existing archive.org files for the current stream
	//$sql = "DELETE FROM  `mv_stream_files` WHERE `stream_id`='{$stream->id}' AND `file_desc_msg` LIKE 'ao_file_%' LIMIT 10";
	//$dbw->query( $sql );
	//print "removed existing archive.org files for $stream->name \n";

	//just do a forced link to the archive.org details page
	//if ( $stream->archive_org != '' ) {
	// grab file list from archive.org:
	//require_once( 'scrape_and_insert.inc.php' );
	//$aos = new MV_ArchiveOrgScrape();

	//$file_list = $aos->getFileList( $stream->name );
	//if($file_list===false || count($file_list)==0) {
	//	print 'no files on archive.org for'. $stream->name ."\n\n";
	//	return '';
	//}
	$out .= '==More Media Sources==' . "\n";
	// all streams have congretional cronical:
	$out .= '*[http://www.c-spanarchives.org/congress/?q=node/69850&date=' . $cspan_date . '&hors=' . $ch_type .
	' CSPAN\'s Congressional Chronicle]' . "\n";

	//if ( $file_list ) {
		$out .= '*[http://www.archive.org/details/mv_' . $stream->name .
		' Archive.org hosted version]' . "\n";
		// also output 'direct' semantic links to alternate file qualities:
		/*$out .= "\n===Full File Links===\n";
		$found_ogg=false;
		foreach ( $file_list as $file ) {
			$name = str_replace( ' ', '_', $file[2] );
			$url = 'http://archive.org'.$file[1];
			$size = $file[3];

			// add these files into the mv_files table:
			// @@todo in the future we should tie the mv_files table to the semantic properties.
			// check if already present:

			$quality_msg = 'ao_file_' . $name;

			if($name=='Ogg_Video'){
				$found_ogg=true;
			}
			$path_type = 'url_file';
			if($found_ogg && $name=='512Kb_MPEG4'){
				$quality_msg = 'mv_archive_org_mp4';
				$path_type = 'mp4_stream';
			}
			//print "found ogg $found_ogg name: $name  qm:$quality_msg\n";

			//output stream to wiki text:
			$out .= "*[{$url} $name] {$size}\n";

			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->query( "SELECT * FROM `mv_stream_files`
					WHERE `stream_id`={$mvTitle->getStreamId()}
					AND `file_desc_msg`='{$quality_msg}'" );
			if ( $dbr->numRows( $res ) == 0 ) {
				$sql = "INSERT INTO `mv_stream_files` (`stream_id`,`duration`, `file_desc_msg`, `path_type`, `path`)" .
				" VALUES ('{$mvTitle->getStreamId()}','{$mvTitle->getDuration()}', '{$quality_msg}', '{$path_type}','{$url}' )";
			} else {
				$row = $dbr->fetchObject( $res );
				// update that msg key *just in case*
				$sql = "UPDATE  `mv_stream_files` SET `path_type`='{$path_type}', `path`='$url' WHERE `id`={$row->id}";
			}
			$dbw->query( $sql );
		}
		$dbw->commit();
		*/
		// more semantic properties
		$out .= "\n\n";
		$out .= '[[stream_duration::' . ( $mvTitle->getDuration() ) . '| ]]' . "\n";
		if ( $stream->date_start_time ) {
			$out .= '[[original_date::' . $stream->date_start_time . '| ]]';
		}
		//}
	//}
	// add stream category (based on sync status)
	//(only add if the wiki page does not exist)
	$wStreamTitle = Title::newFromText($stream->name, MV_NS_STREAM);
	if( !$wStreamTitle->exists() ) {
		switch( $stream->sync_status ) {
			case 'not_checked':
				$out .= "\n\n" . '[[Category:Stream Unchecked]]';
			break;
			case 'impossible':
				$out .= "\n\n" . '[[Category:Stream Out of Sync]]';
			break;
			case 'in_sync':
				$out .= "\n\n" . '[[Category:Stream Basic Sync]]';
				// other options [stream high quality sync ];
			break;
		}
	}
	return $out;
}
function mvd_consistancy_check(){
	//get all 2009 streams:
	$dbr = wfGetDB( DB_READ );
	$streams = array();
	$result = $dbr->select( 'mv_streams',
		'*',
		'date_start_time >= '.  mktime(0, 0, 0, 1, 1, 2009),
		__METHOD__
	);
	if ( $dbr->numRows( $result ) == 0 )die("no streams found"."\n". $dbr->lastQuery() ."\n");
	while ( $stream = $dbr->fetchObject( $result ) ) {
		//get all the mvds for this stream
		$mvd_res = $dbr->select( 'mv_mvd_index', '*', array('stream_id'=>$stream->id));
		while ( $mvd = $dbr->fetchObject( $mvd_res ) ) {
			//make sure the article exists:
			$mvdTitle = Title::newFromText($mvd->wiki_title, MV_NS_MVD);
			if($mvdTitle->exists()){
				//update the text:
				$mvdArticle = new Article ($mvdTitle);
				$text = $mvdArticle->getRawText();
				//find the spoken by or speech by text:
				$sb_pat =  '/\[\[Spoken By(\:.)([^\]]*)]]/i';
				preg_match($sb_pat, $text, $matches );
				if(isset($matches[2])){
					$replacement = ($matches[2] == 'Unknown')?'':
								'[[Spoken By::'. str_replace('_', ' ', $matches[2]).']]';
					$text = preg_replace($sb_pat, $replacement, $text);
				}
				//do the same for speech by
				$sb_pat =  '/\[\[Speech by(\:.)([^\]]*)]]/i';
				preg_match($sb_pat, $text, $matches );
				if(isset($matches[2])){
					$replacement = ($matches[2] == 'Unknown')?'':
								'[[Speech by::'. str_replace('_', ' ', $matches[2]).']]';
					$text = preg_replace($sb_pat, $replacement, $text);
				}
				//trim all double spaces
				$text = preg_replace('/[\s]+/', ' ', $text);
				//uc upper words:
				//$text = preg_replace("/[^A-Z]\.(\s)(\\w)/e", '".$1".strtoupper("$2")', $text);
				do_update_wiki_page( $mvdTitle, trim($text),'',true);
			}else{
				print "orphaned mvd: {$mvd->wiki_title} (should remove) \n";
			}
		}
		//die('only update one stream at a time');
	}
}
function do_bill_insert( $bill_key ) {
	include_once( 'scrape_and_insert.inc.php' );
	$mvScrape = new MV_BaseScraper();
	$myBillScraper = new MV_BillScraper();

	$congressNum = 111;
	print "do_bill_insert:: $bill_key downloading fresh bills.index.xml....\n ";
	//grab bill list with categories from govtrack
	$raw_govtrack_bill_data = $mvScrape->doRequest('http://www.govtrack.us/data/us/'.$congressNum.'/bills.index.xml', array(), true);
	//turn bill data into an array:
	preg_match_all("/<bill\s([^>]*)\>/U",$raw_govtrack_bill_data,$nodes);
	print "found " . count($nodes[1]) . " bills \n";
	$types = array('type', 'number', 'title', 'official-title', 'status', 'last-action');

	$billAry = array();
	foreach($nodes[1] as $bill_str){
		$bObj = array();
		preg_match_all('/([^=]*)="([^"]*)"/', $bill_str, $matches);
		foreach($matches[1] as $inx => $tkey){
			if(in_array(trim($tkey), $types)){
				$bObj[ trim($tkey) ] = $matches[2][$inx];
			}
		}
		//setup some keys:
		$bObj['GovTrackID'] = $bObj['type'] . $congressNum . '-' . $bObj['number'];
		$bObj['ThomasID']	= 'd'.$congressNum.':'.$bObj['type'].$bObj['number'].':';
		$bObj['OpenCongressBillID']	=$congressNum.'-'.$bObj['type'].$bObj['number'];
		$bObj['CongressSession'] = $congressNum;
		$tp = explode(':',	$bObj['title']);
		$bObj['Bill Key'] = $tp[0];

		$maplightBillId = get_map_light_bill_id( $bObj );
		if($maplightBillId===false){
			print "Could not find maplight id for bill: " . $bObj['type'] . '+' . $bObj['number'] . "\n";
			$bObj['MapLightBillID'] = false;
		}else{
			$bObj['MapLightBillID'] = $maplightBillId;
			//now that we do have a maplight key get the interest info:
			$bObj['interests'] = $myBillScraper->proccMapLightBillIntrests($maplightBillId);
		}
		$billAry[] = $bObj;
		//do proccess the bill (insert into the wiki)
		print "ProccessBill::";
		$myBillScraper->processBill($bObj['GovTrackID'], $bObj['Bill Key'],$bObj['OpenCongressBillID'], $bObj['MapLightBillID'], false, false);
	}

}
function get_map_light_bill_id($bObj){
	include_once( 'scrape_and_insert.inc.php' );
	$mvScrape = new MV_BaseScraper();
	$rawBillPage = $mvScrape->doRequest('http://maplight.org/map/us/bill/search/' . $bObj['type'] . '+' . $bObj['number'] ) ;
	//get the basic zone:
	$sb = strpos($rawBillPage, '<h3>Bills numbered');
	if($sb===false){
	  return false;
	}

	$se = strpos($rawBillPage, '<h3>Bills matching', $sb);
	if($se === false){
		return false;
	}

	$target_search_area = substr($rawBillPage, $sb, $se-$sb );
	//get the matchign area
	preg_match_all('/href=\"([^"]*)"[^(]*\(([^t]*)/', $target_search_area, $matches);
	foreach($matches[2] as $inx => $val){
		if($val == $bObj['CongressSession'] ){
			//remove the unused parts of the url
			return str_replace('/map/us/bill/', '', $matches[1][$inx]);
		}
	}
	return false;
}
function do_people_insert( $doInterestLookup = false, $forcePerson = '', $force = false ) {
	global $valid_attributes, $states_ary;

	$dbr = wfGetDB( DB_SLAVE );

	include_once( 'scrape_and_insert.inc.php' );
	$mvScrape = new MV_BaseScraper();

	//get all people from govtrack db ( should not have to do this all the time)
	$govtrackDB = array();
	//avoid duplicating the $govtrackDB array:
	getGovTrackPeopleDB( $govtrackDB );

	//get all people from the congress people category
	$result = $dbr->select( 'categorylinks', 'cl_sortkey', array (
		'cl_to' => 'Congress_Person'
		)
	);
	if ( $dbr->numRows( $result ) == 0 )
		die( 'could not find people: ' . "\n" );
	$out = '';
	$person_ary = array();
	while ( $person = $dbr->fetchObject( $result ) ) {
		$person_ary[] = $person;
	}
	foreach ( $person_ary as $person) {
		$person_name = $person->cl_sortkey;
		//get person data from  wiki:
		$person_title = Title::newFromText( $person_name );

		$smwStore =& smwfGetStore();

		//check for govtrack key in page
		$propTitle = Title::newFromText('GovTrack Person ID', SMW_NS_PROPERTY );
		$smwProps = $smwStore->getPropertyValues( $person_title, $propTitle );
		if ( count( $smwProps ) != 0 ) {
			$v = current( $smwProps );
			$person->gov_track_id = $v->getXSDValue();
		}else{
			print "person: $person_name has no GovTrack Person ID make sure to include this on their page\n";
		}
		if( isset($person->gov_track_id) ){
			setGovTrackSpecifcAttr($person, $govtrackDB[ $person->gov_track_id ]);
		}else{
			//check for govtrack key in $govtrackDB:
			foreach( $govtrackDB as $gov_track_person){
				if( isset($gov_track_person['metavidid']) && $gov_track_person['metavidid'] == str_replace(' ', '_',$person_name) ){
					setGovTrackSpecifcAttr($person, $gov_track_person);
				}
			}
			reset($govtrackDB);
			//did not find metavid id try name test:
			if( !isset($person->govtrack_id )){
				foreach( $govtrackDB as $gov_track_person){
					if(isset($gov_track_person['middlename'])){
						$gov_name = $gov_track_person['firstname'] .' '.
										substr($gov_track_person['middlename'],0,1) . '. ' .
										$gov_track_person['lastname'];
						//first check for exact match:
						if( strtolower($gov_name) == strtolower($person_name) ){
							setGovTrackSpecifcAttr($person, $gov_track_person);
							break;
						}
					}
					//else first last check:
					$nparts = split(' ', $person_name);
					if( strtolower( $gov_track_person['firstname']) == strtolower($nparts[0]) &&
						strtolower( $gov_track_person['lastname']) == strtolower( $nparts[count($nparts)-1] ) ){
						setGovTrackSpecifcAttr($person, $gov_track_person);
						break;
					}
				}
			}
			if(!isset($person->gov_track_id)){
				die("\n could not find gov track id for $person_name please add manually or remove from Congress_Person category\n ");
			}
		}
		//set the maplight key (not in sunlight api)
		$propTitle = Title::newFromText( 'MAPLight Person ID', SMW_NS_PROPERTY );
		$smwProps = $smwStore->getPropertyValues( $person_title, $propTitle );
		if ( count( $smwProps ) != 0 ) {
			$v = current( $smwProps );
			$mapk = $v->getXSDValue();
			$person->maplight_id = $v->getXSDValue();
		}else{
			print "person: $person_name has no MAPLight Person ID could not lookup with sunlight api?\n";
		}

		//set $person->name_ocr
		$propTitle = Title::newFromText( 'Name OCR', SMW_NS_PROPERTY );
		$smwProps = $smwStore->getPropertyValues( $person_title, $propTitle );
		if ( count( $smwProps ) != 0 ) {
			$v = current( $smwProps );
			$person->name_ocr = $v->getXSDValue();
		}

		$page_body = '{{Congress Person|' . "\n";
		foreach ( $valid_attributes as $dbKey => $attr ) {
			list ( $name, $desc ) = $attr;
			if( $dbKey == 'gov_track_id'){
				//we key all to govtrack id make sure its there:
				$page_body.="GovTrack Person ID=".$person->gov_track_id . "|\n";
			}elseif ( $dbKey == 'total_received' ) {
				if ( !$mapk ) {
					print 'no mapkey for total_received' . "\n";
				} else {
					$raw_results = $mvScrape->doRequest( 'http://www.maplight.org/map/us/legislator/' . $mapk );
					preg_match( '/Contributions\sReceived\:\s\$([^<]*)/', $raw_results, $matches );
					if ( isset( $matches[1] ) ) {
						$page_body .= "{$name}=\$" . $matches[1] . "|\n";
					}
				}
			} elseif($dbKey == 'roles'){
				if ( $person->$dbKey ) {
					$i=1;
					foreach($person->$dbKey as $role){
						$page_body.="Role $i Type=" . ucfirst($role['type'])."|\n";
						$page_body.="Role $i Party=" .  $role['party']. "|\n";
						$page_body.="Role $i State=" .  $role['state']. "|\n";
						$page_body.="Role $i Start Date=" . $role['startdate']."|\n";
						$page_body.="Role $i End Date=" . $role['enddate'] . "|\n";
						$i++;
					}
				}
			} elseif($dbKey == 'committee'){
				if ( isset($person->$dbKey) ) {
					$i = 1;
					foreach($person->$dbKey as $committee){
						if(isset($committee ['committee']))
							$page_body.="Committee $i= ".$committee ['committee'] ."|\n";
						if(isset($committee['subcommittee']))
							$page_body.="Subcommittee $i= ".$committee ['subcommittee'] ."|\n";
						if(isset($committee['role']))
							$page_body.="Committee Role $i= ".$committee ['role'] ."|\n";
						$i++;
					}
				}
			} elseif ( $dbKey == 'contribution_date_range' ) {
				if ( !$mapk ) {
					print 'out of order attr process missing mapk' . "\n";
				} else {
					$raw_results = $mvScrape->doRequest( 'http://www.maplight.org/map/us/legislator/' . $mapk );
					preg_match( '/Showing\scontributions<\/dt><dd>([^<]*)</', $raw_results, $matches );
					if ( isset( $matches[1] ) ) {
						$page_body .= "{$name}=" . $matches[1] . "|\n";
					}
				}
			} elseif ( $dbKey == 'maplight_id' ) {
				if ( !$person->$dbKey ) {
					// print 'do_maplight_id'."\n";
					// try to grab the maplight id
					$person_lookup = $govtrackDB[ $person->gov_track_id ];
					$raw_results = $mvScrape->doRequest( 'http://maplight.org/map/us/legislator/search/' . $person_lookup->lastname . '+' . $person->firstname );
					preg_match_all( '/map\/us\/legislator\/([^"]*)">(.*)<\/a>.*<td>([^<]*)<.*<td>([^<]*)<.*<td>([^<]*)<.*<td>([^<]*)</U', $raw_results, $matches );

					// do point system for match
					$point = array();
					$title_lookup = array( 'Rep.' => 'House', 'Sen.' => 'Senate' );
					if ( isset( $matches['2'][0] ) ) {
						foreach ( $matches['2'] as $k => $name_html ) {
							if ( !isset( $point[$k] ) )$point[$k] = 0;
							list( $lname, $fname ) = explode( ',', trim( strip_tags( $name_html ) ) );
							if ( strtolower( $person->first ) == strtolower( $fname ) )$point[$k] += 2;
							if ( strtolower( $person->last ) == strtolower( $lname ) )$point[$k] += 2;
							if ( $person_lookup['state'] == $matches['3'][$k] )$point[$k]++;
							if ( $person_lookup['district'] == $matches['4'][$k] )$point[$k]++;
							if ( $person_lookup['party'] == $matches['5'][$k] )$point[$k]++;
							if(isset($person_lookup['title'])){
								if ( isset( $title_lookup[ $person['title'] ]) ) {
									if ( $title_lookup[ $person['title'] ] == $matches['6'] )$point[$k]++;
								}
							}
						}
						$max = 0;
						$mapk = null;
						//print_r($matches);
						//die;
						foreach ( $point as $k => $v ) {
							if ( $v > $max ) {
								$mapk = $matches[1][$k];
								$max = $v;
							}
						}
					}
				} else {
					$mapk = $person->$dbKey;
				}
				$page_body .= "{$name}=" . $mapk . "|\n";
			} else {
				//try the $sulightData array
				if(isset($sulightData[ $dbKey ])){
					$page_body.= $name . '=' . $sulightData[ $dbKey ]."| \n";
				}else{
					if( isset($person->$dbKey) ){
						if ( trim( $person->$dbKey ) != '' ) {
							if ( $dbKey == 'state' )	$person->state = $states_ary[$person->state];
							$page_body .= "{$name}={$person->$dbKey}|  \n";
						}
					}
				}
			}
		}
		// if we have the maplight key add in all contributions and process contributers
		if ( !$mapk ) {
			print 'missing mapkey' . "\n";
		} else {
			$raw_results = $mvScrape->doRequest( 'http://www.maplight.org/map/us/legislator/' . $mapk );
			preg_match_all( '/\/map\/us\/interest\/([^"]*)">([^<]*)<.*\$([^\<]*)</U', $raw_results, $matches );
			if ( isset( $matches[1] ) ) {
				foreach ( $matches[1] as $k => $val ) {
					$hr_inx = $k + 1;
					$page_body .= "Funding Interest $hr_inx=" . html_entity_decode( $matches[2][$k] ) . "|\n";
					$page_body .= "Funding Amount $hr_inx=\$" . $matches[3][$k] . "|\n";
					if ( $doInterestLookup ) {
						// make sure the intrest has been processed:
						do_proc_interest( $matches[1][$k], html_entity_decode( $matches[2][$k] ) );
					}
					// do_proc_interest('G1100','Chambers of commerce');
				}
			}
		}
		// add in the full name attribute:
		/*$page_body .= "Full Name=" . $person->title . ' ' . $person->first .
			' ' . $person->middle . ' ' . $person->last . "|  \n";*/

		//close:
		$page_body .= '}}';
		// add in basic info to be overwitten by transclude (from
		/*$full_name = $person->title . ' ' . $person->first .
		' ' . $person->middle . ' ' . $person->last;
		if ( trim( $full_name ) == '' )
			$full_name = $person->name_clean;

		$page_body .= "\n" . 'Person page For <b>' . $full_name . "</b><br />\n";*/
			//	 			"Text Spoken By [[Special:MediaSearch/person/{$person->name_clean}|$full_name]] ";

		do_update_wiki_page( $person_title, $page_body, '', $force );
		//die('only run on first person'."\n");
	}

	foreach ( $person_ary as $person ) {
		$person_lookup = $govtrackDB[ $person->gov_track_id ];
		// download/upload all the photos:
		$imgTitle = Title :: makeTitle( NS_IMAGE, $person->cl_sortkey . '.jpg' );
		// if(!$imgTitle->exists()){
		global $wgTmpDirectory;
		$url = 'http://www.govtrack.us/data/photos/' . $person->gov_track_id . '-100px.jpeg';
		//check if url exists:
		if( !url_exists($url)){
			print " no image found for: {$person->cl_sortkey}\n";
			continue;
		}

		// print $wgTmpDirectory . "\n";
		$local_file = tempnam( $wgTmpDirectory, 'WEBUPLOAD' );
		// copy file:

		# Check if already there existence
		$image = wfLocalFile( $imgTitle );
		if ( $image->exists() ) {
			echo ( $imgTitle->getDBkey() . " already in the wiki\n" );
			continue;
		}

		for ( $ct = 0; $ct < 10; $ct++ ) {
			if ( !@ copy( $url, $local_file ) ) {
				print ( "failed to copy $url to local_file (tring again) \n" );
			} else {
				print "copy success\n";
				$ct = 10;
			}
			if ( $ct == 9 )
				print 'complete failure' . "\n";
		}

		# Stash the file
		echo ( "Saving " . $imgTitle->getDBkey() . "..." );
		$image = wfLocalFile( $imgTitle );

		$archive = $image->publish( $local_file );
		if ( !$archive->isGood() ) {
			echo ( "failed.\n" );
			continue;
		}
		echo ( "importing..." );
		$comment = 'Image file for [[' . $person->name_clean . ']]';
		$license = '';

		if ( $image->recordUpload( $archive, $comment, $license ) ) {
			# We're done!
			echo ( "done.\n" );
		} else {
			echo ( "failed.\n" );
		}
	}
}
function setGovTrackSpecifcAttr(&$person, &$gov_track_person){
	$person->gov_track_id = $gov_track_person['id'];

	//also set govtrack only properties:
	if(isset($gov_track_person['birthday']))
		$person->birthday = $gov_track_person['birthday'];

	if(isset($gov_track_person['religion']))
		$person->religion = $gov_track_person['religion'];

	if(isset($gov_track_person['youtubeid']))
		$person->youtubeid = $gov_track_person['youtubeid'];

	if(isset($gov_track_person['roles']))
		$person->roles = $gov_track_person['roles'];

	if(isset($gov_track_person['committee']))
		$person->committee = $gov_track_person['committee'];
}
//loads a big xml file
function getGovTrackPeopleDB( &$govTrackDb){
	include_once( 'scrape_and_insert.inc.php' );
	$mvScrape = new MV_BaseScraper();
	//get the last few people.xml databases (starting with most recent)
	$raw_govtrack_data = $mvScrape->doRequest('http://www.govtrack.us/data/us/111/repstats/people.xml');

	govtrackXMLtoARRAY($govTrackDb, $raw_govtrack_data);
	$oneElevenCount  = count($govTrackDb);
	print "govTrackDb: populated " . count($govTrackDb) . " from govTrack people.xml \n";
	//should have a well populated $govTrackDb
}
function govtrackXMLtoARRAY(&$govTrackDb, & $xmlstring) {
   //normal XML parsing is too slow: use preg match:
	preg_match_all("/<person([^>]*)>(.*)<\/person>/sU",$xmlstring,$nodes);
	print "found " . count($nodes[1]) . " person nodes \n";
	$poKeys = array();
	foreach($nodes[1] as $pokey => $persons_attr){
   		preg_match_all("/([a-z]*)=\'([^\']*)\'/",$persons_attr, $attr);
		$cur_person = array();
		foreach($attr[1] as $key=>$key_name){
	   		$cur_person[$key_name] = $attr[2][$key];
		}
		if(!isset( $govTrackDb[ $cur_person['id'] ])){
			$govTrackDb[ $cur_person['id'] ] =$cur_person;
		}
		//committee and roles:
		if(isset($nodes[2][$pokey])){
			$persons_child_xml = $nodes[2][$pokey];
			preg_match_all("/<role([^>]*)>/", $persons_child_xml, $roles);
			if( count($roles[1] != 0)){
				$govTrackDb[ $cur_person['id'] ]['roles']=array();
				foreach($roles[1] as $role_attr){
					preg_match_all("/([a-z]*)=\'([^\']*)\'/",$role_attr, $rattr);
					$cur_role = array();
				   	foreach($rattr[1] as $key=>$key_name){
						$cur_role[$key_name] = $rattr[2][$key];
				   	}
					$govTrackDb[ $cur_person['id'] ]['roles'][]=$cur_role;
			   	}
			}
			preg_match_all("/<current-committee-assignment([^>]*)>/",  $persons_child_xml, $committee);
			if(count($committee[1])!=0){
				$govTrackDb[ $cur_person['id'] ]['committee']=array();
				foreach($committee[1] as $cur_committee){
					preg_match_all("/([a-z]*)=\'([^\']*)\'/", $cur_committee, $cattr);
					$cur_com=array();
					foreach($cattr[1] as $key=>$key_name){
						$cur_com[ $key_name ] = $cattr[2][$key];
					}
					$govTrackDb[  $cur_person['id'] ]['committee'][] = $cur_com;
				}
			}
		}
   }
}

function do_proc_interest( $intrestKey, $intrestName ) {
	global $mvMaxContribPerInterest, $mvMaxForAgainstBills;
	include_once( 'scrape_and_insert.inc.php' );
	$mvScrape = new MV_BillScraper();


	$raw_results = $mvScrape->doRequest( 'http://www.maplight.org/map/us/interest/' . $intrestKey . '/view/all' );
	$page_body = '{{Interest Group|' . "\n";
	$page_body .= 'MAPLight Interest ID=' . $intrestKey . "|\n";
	// get all people contributions:
	preg_match_all( '/\/map\/us\/legislator\/([^"]*)">.*\$([^<]*)</U', $raw_results, $matches );
	if ( isset( $matches[2] ) ) {
		$i = 0;
		foreach ( $matches[1] as $i => $person_id ) {
			$hr_inx = $i + 1;
			// we have to lookup the name:
			$personName = $mvScrape->get_wiki_name_from_maplightid( $person_id );
			if ( $personName ) {
				$page_body .= "Funded Name $hr_inx=" . $personName . "|\n";
				$page_body .= "Funded Amount $hr_inx=" . str_replace( ',', '', $matches[2][$i] ) . "|\n";
			}
			if ( $hr_inx == $mvMaxContribPerInterest )break;
			$i++;
		}
	}
	$intrest_bills_url =  'http://maplight.org/map/us/interest/' . $intrestKey . '/bills';
	$raw_results =  $mvScrape->doRequest( $intrest_bills_url );
	// get all bills supported or opposed
	preg_match_all( '/\/map\/us\/bill\/([^"]*)".*\/map\/us\/legislator.*<td>([^<]*)</U', $raw_results, $matches );
	print 'bill:'.$intrest_bills_url . "\n";
	//die;
	$sinx = $oinx = 1;
	if ( isset( $matches[1][0] ) ) {
		$support_count = $oppse_count = 0;
		foreach ( $matches[1] as $i => $bill_id ) {
			// skip if we are maxed out
			if ( $support_count == $mvMaxForAgainstBills )continue;
			if ( $oppse_count == $mvMaxForAgainstBills )continue;
			$hr_inx = $i + 1;
			$bill_name = $mvScrape->get_bill_name_from_mapLight_id( $bill_id );
			if ( $matches[2][$i] == 'Support' ) {
				$page_body .= "Supported Bill $sinx=" . str_replace( '_', ' ', $bill_name ) . "|\n";
				$sinx++;
			} elseif ( $matches[2][$i] == 'Oppose' ) {
				$page_body .= "Opposed Bill $oinx=" . str_replace( '_', ' ', $bill_name ) . "|\n";
				$oinx++;
			}
		}
	}
	$page_body .= '}}';
	$wTitle = Title::makeTitle( NS_MAIN, $intrestName );
	print "Interest: ";
	do_update_wiki_page( $wTitle, $page_body );
	print "\n";
}
function do_rm_congress_persons() {
	$dbr = wfGetDB( DB_SLAVE );
	$result = $dbr->query( " SELECT *
	FROM `categorylinks`
	WHERE `cl_to` LIKE 'Congress_Person' " );
	while ( $row = $dbr->fetchObject( $result ) ) {
		$pTitle = Title::makeTitle( NS_MAIN, $row->cl_sortkey );
		$pArticle = new Article( $pTitle );
		$pArticle->doDeleteArticle( 'removed reason' );
		print "removed title: " . $pTitle->getText() . "\n";
	}
}
function mv_process_attr( $table, $stream_id ) {
	global $start_time, $end_time;
	$dbr = wfGetDB( DB_SLAVE );
	$sql = "SELECT * FROM `metavid`.`$table` WHERE `stream_fk`=$stream_id";
	$res = $dbr->query( $sql );
	$out = '';
	while ( $var = $dbr->fetchObject( $res ) ) {
		$type_title = getTypeTitle( $var->type );
		if ( $var->type == 'adj_start_time' )
			$start_time = $var->value;
		if ( $var->type == 'adj_end_time' )
			$end_time = $var->value;
		if ( $type_title != '' ) {
			$reltype = ( $type_title[0] == 'rel' ) ? '::' : ':=';
			$out .= '[[' . $var->type . ':=' . $var->value . '| ]]' . "\n";
		}
	}
	return $out;
}

function getTypeTitle( $type ) {
	switch ( $type ) {
		case 'cspan_type' :
			return array (
				'rel',
				'Government Event'
			);
			break;
		case 'cspan_title' :
			return array (
				'atr',
				'C-SPAN Title'
			);
			break;
		case 'cspan_desc' :
			return array (
				'atr',
				'C-SPAN Description'
			);
			break;
		case 'adj_start_time' :
			return array (
				'atr',
				'Unix Start Time'
			);
			break;
		case 'adj_end_time' :
			return array (
				'atr',
				'Unix End Time'
			);
			break;
		default :
			return '';
			break;
	}
}
// valid attributes dbkey=>semantic name
$valid_attributes = array (
	'name_ocr' => array (
		'Name OCR',
		'The Name as it appears in on screen video text',
		'string'
	),
	'maplight_id' => array(
		'MAPLight Person ID',
		'MAPLight person id for linking into maplight data',
		'string'
	),
	'osid' => array (
		'CRP ID',
		'Congress Person\'s <a href="http://www.opensecrets.org/">Open Secrets</a> Id',
		'string'
	),
	'gov_track_id' => array (
		'GovTrack Person ID',
		'Congress Person\' <a href="www.govtrack.us">govtrack.us</a> person ID',
		'string'
	),
	'birthday'=>array(
		'Birthday',
		'Birthday',
		'date'
	),
	'religion'=>array(
		'Religion',
		'Religion',
		'page'
	),
	'roles'=>array(
		'Roles',
		'Roles date ranges of congress activity',
		'string'
	),
	'committee'=>array(
		'Committee',
		'committees and sub commities with roles',
		'string'
	),
	'youtubeid'=>array(
		'YouTube ID',
		'YouTube ID',
		'string'
	),
	'bioguide' => array (
		'Bioguide ID',
		'Congressional Biographical Directory id',
		'string'
	),
	'title' => array (
		'Title',
		'Title (Sen. or Rep.)',
		'string'
	),
	'state' => array (
		'State',
		'State',
		'page'
	), // do look up
	'party' => array (
		'Party',
		'The Cogress Persons Political party',
		'page'
	),
	'first' => array(
		'First Name',
		'(first name)',
		'string'
	),
	'middle' => array(
		'Middle Name',
		'(middle name)',
		'string'
	),
	'last'	=> array(
		'Last Name',
		'(last name)',
		'string'
	),
	'name_suffix'=>array(
		'Name Suffix',
		'Legislator\'s suffix (Jr., III, etc.) ',
		'string'
	),
	'district' => array(
		'District',
		'The district # page ie: 3rd District',
		'page'
	),
	'url' => array(
		'Home Page',
		'The representatives home page',
		'URL'
	),
	'total_received' => array(
		'Total Received',
		'The Total Contributions Received',
		'number'
	),
	'contribution_date_range' => array(
		'Contributions Date Range',
		'The date range of contributions',
		'string'
	),
	'nickname'=> array(
		'Nickname',
		'Preferred nickname of legislator (if any)',
		'string'
	),
	'in_office'=>array(
		'In Office',
		'1 if legislator is currently serving, 0 if legislator is no longer in office due to defeat/resignation/death/etc.',
		'number'
	),
	'gender'=>array(
		'Gender',
		'M or F',
		'string'
	),
	'phone'=>array(
		'Phone',
		'Congressional office phone number',
		'string'
	),
	'fax'=>array(
		'Fax',
		'Congressional office fax number',
		'string'
	),
	'congress_office'=>array(
		'Congress Office',
		'Legislator\'s Washington DC Office Address',
		'string'
	),
	'votesmart_id'=>array(
		'Votesmart ID',
		'Legislator ID assigned by Project Vote Smart',
		'string'
	),
	'fec_id'=>array(
		'FEC ID',
		'Federal Election Commission ID',
		'string'
	),
	'congresspedia_url'=>array(
		'Congresspedia URL',
		'URL of Legislator\'s entry on Congresspedia',
		'URL'
	),
	'webform'=>array(
		'Webform',
		'URL of web contact form',
		'URL'
	),
	'eventful_id'=>array(
		'Eventful ID',
		'Eventfull id',
		'string'
	),
	'twitter_id'=>array(
		'Twitter ID',
		'Congressperson\'s official Twitter account',
		'string'
	)
);
// state look up:
$states_ary = array (
	'AL' => 'Alabama',
	'AK' => 'Alaska',
	'AS' => 'American Samoa',
	'AZ' => 'Arizona',
	'AR' => 'Arkansas',
	'AE' => 'Armed Forces - Europe',
	'AP' => 'Armed Forces - Pacific',
	'AA' => 'Armed Forces - USA/Canada',
	'CA' => 'California',
	'CO' => 'Colorado',
	'CT' => 'Connecticut',
	'DE' => 'Delaware',
	'DC' => 'District of Columbia',
	'FM' => 'Federated States of Micronesia',
	'FL' => 'Florida',
	'GA' => 'Georgia',
	'GU' => 'Guam',
	'HI' => 'Hawaii',
	'ID' => 'Idaho',
	'IL' => 'Illinois',
	'IN' => 'Indiana',
	'IA' => 'Iowa',
	'KS' => 'Kansas',
	'KY' => 'Kentucky',
	'LA' => 'Louisiana',
	'ME' => 'Maine',
	'MH' => 'Marshall Islands',
	'MD' => 'Maryland',
	'MA' => 'Massachusetts',
	'MI' => 'Michigan',
	'MN' => 'Minnesota',
	'MS' => 'Mississippi',
	'MO' => 'Missouri',
	'MT' => 'Montana',
	'NE' => 'Nebraska',
	'NV' => 'Nevada',
	'NH' => 'New Hampshire',
	'NJ' => 'New Jersey',
	'NM' => 'New Mexico',
	'NY' => 'New York',
	'NC' => 'North Carolina',
	'ND' => 'North Dakota',
	'OH' => 'Ohio',
	'OK' => 'Oklahoma',
	'OR' => 'Oregon',
	'PA' => 'Pennsylvania',
	'PR' => 'Puerto Rico',
	'RI' => 'Rhode Island',
	'SC' => 'South Carolina',
	'SD' => 'South Dakota',
	'TN' => 'Tennessee',
	'TX' => 'Texas',
	'UT' => 'Utah',
	'VT' => 'Vermont',
	'VI' => 'Virgin Islands',
	'VA' => 'Virginia',
	'WA' => 'Washington',
	'WV' => 'West Virginia',
	'WI' => 'Wisconsin',
	'WY' => 'Wyoming',
	'AB' => 'Alberta',
	'BC' => 'British Columbia',
	'MB' => 'Manitoba',
	'NB' => 'New Brunswick',
	'NF' => 'Newfoundland',
	'MP' => 'Northern Mariana Island ',
	'NT' => 'Northwest Territories',
	'NS' => 'Nova Scotia',
	'ON' => 'Ontario',
	'PW' => 'Palau Island',
	'PE' => 'Prince Edward Island',
	'QC' => 'Quebec',
	'SK' => 'Saskatchewan',
	'YT' => 'Yukon Territory'
);
