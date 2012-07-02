<?php
require_once ( '../../../maintenance/commandLine.inc' );

// include util functions:
require_once( 'maintenance_util.inc.php' );

if ( count( $args ) == 0 || isset ( $options['help'] ) ) {
	print<<<EOT
One time fixes to wiki content

Usage php metavid2mvWiki.php [options] action
options:
	--dry 			// will just print out operations that it will run
	--offset [val]	//start on a given offset (in case things don't finish

actions: 
	revert_last_edits --num_edits [X] //reverts last X edits (do --dry first) 
	strip_speech_by  //strips extra speech by text
	update_stream_desc //updates stream desc
	update_archive_org_files [stream_name] //updates pointers to archive.org mp4 streaming
	update_flv_meta //generates meta data for all .flv files in /metavid/video_archive

EOT;
	exit ();
}
$mvDryRun = ( isset( $options['dry'] ) ) ? true:false;

switch ( $args[0] ) {
	case 'revert_last_edits': 
		if( !$options['num_edits'] )
			die('we need a number of edits to revert');
					
		do_revert_by_time( $args[1] );
	break;
	case 'strip_speech_by' :
		strip_speech_by();
	break;
	case 'update_stream_time_dur':
		update_stream_time_dur();
	break;
	case 'update_stream_desc':
		update_stream_desc();
	break;
	case 'update_flv_meta':
		update_flv_meta();
	break;
	case 'update_archive_org_files':
		$stream_name = (isset( $args[1] ))?$args[1]:''; 		
		run_archive_org_update( $stream_name );
	break;
}
function do_revert_by_time( $num ){
	global $mvDryRun;
	$dbr = wfGetDB( DB_READ );
	$dbw = wfGetDB( DB_WRITE );
	$sql = " SELECT *
FROM `recentchanges`
ORDER BY `recentchanges`.`rc_timestamp` DESC
LIMIT 0, {$num}";	
	
	$result = $dbr->query( $sql );	
	//get the first last 10 	
	while ( $rc_edit = $dbr->fetchObject( $result ) ) {			
		//if(!$mvDryRun)
		//get the -1 revision	
		if($rc_edit->rc_last_oldid != 0 ){
			$rev = Revision::newFromId( $rc_edit->rc_last_oldid );
			$rTitle = Title::makeTitle( $rc_edit->rc_namespace, $rc_edit->rc_title );
			//$rev = Revision::newFromTitle( $title, $rc_edit->rc_this_oldid );
			$old_text = $rev->getRawText();
			print "Revert one edit on: " . $rc_edit->rc_title . "\n";
			if(!$mvDryRun){
				do_update_wiki_page( $rTitle, $old_text, MV_NS_STREAM, $force = true );
			}		
		}
		//do_update_wiki_page( $streamTitle, $out, MV_NS_STREAM, $force = true );	
	}	
}
function run_archive_org_update($stream_name=''){
	//first get all the streams: 			
	include_once( 'metavid2mvWiki.inc.php' );
	$dbr = wfGetDB( DB_READ );
	$dbw = wfGetDB( DB_WRITE );
	if($stream_name!=''){
		$sql =  "SELECT * FROM `mv_streams` WHERE `name`='$stream_name' LIMIT 1";
	}else{
		$sql = "SELECT * FROM `mv_streams` LIMIT 0, 5000";
	}
	
	$result = $dbr->query( $sql );	
	while ( $stream = $dbr->fetchObject( $result ) ) {
		//get the wiki page:
		$streamTitle = Title::newFromText($stream->name, MV_NS_STREAM);
		$mArticle = new Article( $streamTitle ); 
		$mvTitle = new MV_Title($stream->name);	
		$stream->archive_org = true;
		$out = mv_semantic_stream_desc($mvTitle, $stream);	
				
		if(trim($out)!=''){
			//get all the existing cats:
			$wtext = $mArticle->getContent();
			preg_match_all('/Category\:([^\]]*)/',$wtext, $matches);
			if( isset($matches[1]) ){
				foreach($matches[1] as $category){
					$out.="\n[[Category:{$category}]]";
				}
			}
			//now that we keept categories force update the page:			
			do_update_wiki_page( $streamTitle, $out, MV_NS_STREAM, $force = true );			
		}
	}
}
function update_flv_meta(){
	$path = '/metavid/video_archive/';
	$flist =  scandir($path);
	require_once('../skins/mv_embed/flvServer/MvFlv.php');
	foreach($flist as $local_fl){			
		print "lf: is_file(" . $path . $local_fl . ")\n";		
		if( is_file($path.$local_fl) && substr($local_fl, -3)=='flv'){	
			//check for .meta
		
			if(!is_file($path . $local_fl .'.meta')){				
				echo "generating flv metadata for {$path}{$local_fl} \n";		
				$flv = new MyFLV();
				try {
					$flv->open( $path . $local_fl );
				} catch (Exception $e) {
					die("<pre>The following exception was detected while trying to open a FLV file:\n" . $e->getMessage() . "</pre>");
				}
				$flv->getMetaData();
				echo "done with .meta (" . filesize($path.$local_fl.META_DATA_EXT).") \n";
			}
		}
	}
}
function update_stream_desc(){
	/*==Official Record==
*[[GovTrack]] Congressional Record[http://www.govtrack.us/congress/recordindex.xpd?date=20080609&where=h]

*[[THOMAS]] Congressional Record [http://thomas.loc.gov/cgi-bin/query/B?r110:@FIELD(FLD003+h)+@FIELD(DDATE+20080609)]

*[[THOMAS]] Extension of Remarks [http://thomas.loc.gov/cgi-bin/query/B?r110:@FIELD(FLD003+h)+@FIELD(DDATE+20080609)]

==More Media Sources==
*[[CSPAN]]'s Congressional Chronicle [http://www.c-spanarchives.org/congress/?q=node/69850&date=2008-06-09&hors=h]
*[[Archive.org]] hosted original copy [http://www.archive.org/details/mv_house_proceeding_06-09-08_01]

===Full File Links===
*[[ao_file_MPEG2:=http://www.archive.org/download/mv_house_proceeding_06-09-08_01/house_proceeding_06-09-08_01.mpeg2|MPEG2]] (2.6 GB)
*[[ao_file_flash_flv:=http://www.archive.org/download/mv_house_proceeding_06-09-08_01/house_proceeding_06-09-08_01.flv|flash_flv]] 	 
	 */
	$dbr = wfGetDB( DB_SLAVE );
	//get all streams 
	$streams_res = $dbr->select('mv_streams','*');
	while($stream = $dbr->fetchObject( $streams_res )){
		//get stream text
		$streamTitle = Title::newFromText($stream->name, MV_NS_STREAM);
		$streamArticle = new Article($streamTitle);
		$cur_text = trim( $streamArticle->getContent() );
		$cur_text=preg_replace('/\*\[\[GovTrack\]\] Congressional Record\[([^\[]*)\]/',
						'*[$1 GovTrack Congressional Record]', $cur_text);
		
		$cur_text=preg_replace('/\*\[\[THOMAS\]\] Congressional Record \[([^\[]*)\]/',
						'*[$1 THOMAS Congressional Record]', $cur_text);
		
		$cur_text=preg_replace('/\*\[\[THOMAS\]\] Extension of Remarks \[([^\[]*)\]/', '*[$1 THOMAS Extension of Remarks]', $cur_text);
		
		$cur_text=preg_replace('/\*\[\[Archive.org\]\] hosted original copy \[([^\[]*)\]/','*[$1 Archive.org hosted original copy]', $cur_text);
		
		$cur_text=preg_replace('/\*\[\[CSPAN\]\]\'s Congressional Chronicle \[([^\[]*)\]/','*[$1 CSPAN Congressional Chronicle]', $cur_text);
		//do force update
		do_update_wiki_page( $streamTitle, $cur_text, MV_NS_STREAM, $force = true );
	}		
	//update links
}

/*function update_stream_time_dur(){
	$streams_res = $dbr->select('mv_streams','*');
	while($stream = $dbr->fetchObject( $streams_res )){
		//check if we have the duration in the file: 
		$stream_files_res =  $dbr->select('mv_stream_files','*',array('stream_id'=>$stream->id));		
		while($stream_file = $dbr->fetchObject( $streams_res )){
			if($stream_file->duration!=0){
				$dur = $stream_file->duration;
				break;
			}else{
				$file_loc = $stream_file->path;
			}
		}
		
	}
}*/
function strip_speech_by() {
	global $mvDryRun;
	$dbr = wfGetDB( DB_SLAVE );
	$streams_res = $dbr->select( 'mv_mvd_index', '*',
					$conds = array( 'mvd_type' => 'Anno_en' ),
					$fname = 'strip_speech_by',
					$options = array( 'LIMIT' => 10000 ) );
	$inx = 0;
	while ( $mvd_row = $dbr->fetchObject( $streams_res ) ) {
		$mvdTitle = Title::newFromText( $mvd_row->wiki_title, MV_NS_MVD );
		$mvdArticle = new Article( $mvdTitle );
		$cur_text = trim( $mvdArticle->getContent() );
		// print "old text: "
		$st = 'Speech By:';
		if ( substr( $cur_text, 0, strlen( $st ) ) == $st ) {
			print "$inx :up: " . $mvd_row->wiki_title . "\n";
			$new_text = trim( substr( $cur_text, strlen( $st ) ) );
			// print "new text: $new_text\n";
			if ( !$mvDryRun )
				do_update_wiki_page( $mvdTitle, $new_text, MV_NS_MVD, $force = true );
		}
		$inx++;
	}
}
