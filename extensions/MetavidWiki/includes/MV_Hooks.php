<?php
/*
 * MV_Hooks.php Created on Apr 24, 2007
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 *
 *
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );

/*
*  This method will be called after an article is saved
* to update the metavid data index
*/
 function mvSaveHook( &$article, &$user, &$text, &$summary, $minor, $watch, $sectionanchor, &$flags ) {
 	global $mvgIP;

 	// confirm we are in the metavid data Namespace (where data indexes are updated)
 	if ( $article->mTitle->getNamespace() == MV_NS_MVD ) {
 		MV_Index::update_index_page( $article, $text );
 	}
 	return true; // always return true, in order not to stop MW's hook processing!
 }
 /*
  * mvisValidMoveOperation
  */
function mvisValidMoveOperation( &$new_title ) {
 	$mvTitle = new MV_Title( $new_title->getDBkey() );
 	if ( $mvTitle->validRequestTitle() ) {
 		return true;
 	} else {
 		return 'mvMVDFormat';
 	}
}
  /*
   * handles general parse and replace functions for sequences and internal embedding setup
   *
   * in sequence pages: replace <playlist> with sequence formatted <playlist>
   * all pages: replace [[Sequence:SeqName]] with embed formatted playlist from that seq page
   * replace [[MvStream:StreamName/ss:ss:ss/ee:ee:ee]] with clip segment
   */
function mvParserAfterTidy( &$parser, &$text ) {
    // find markers in $text
    // replace markers with actual output
    global $markerList;
    for ( $i = 0; $i < count( $markerList ); $i++ )
      $text = preg_replace( '/xx-marker' . $i . '-xx/', $markerList[$i], $text );
    return true;
}

function mvLinkBegin($skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret){
	//if a stream title and the base stream exists give a valid link
 	if( $target->getNamespace() == MV_NS_STREAM ){
 		$mvTitle = new MV_Title($target);
 		if( $mvTitle->doesStreamExist() ){
 			if( in_array( 'broken', $options ) ){
		 		foreach($options as $k=>$v){
		 			if($v=='broken')
		 				$options[$k]='known';
		 		}
 			}else if( !in_array( 'known', $options ) ){
 				$options[]='known';
 			}
 		}
 	}
 	return true;
}
/*
 * enables the rewriting of links to the Stream and Sequence namespace to support inline embeding.
 * see page: sample in-wiki-embed syntax
 * @@todo should probably be integrated to respective Stream and Sequence class.
 * and maybe integrated with File / image handle
*/
 function mvLinkEnd($skin, $title, $options, &$text, &$attribs, &$ret){
 	global $mvDefaultAspectRatio, $mvDefaultVideoPlaybackRes, $mvEmbedKey;
 	//only do link rewrites for $mvEmbedKey
 	if( substr( $title->getText(), 0, strlen( $mvEmbedKey ) ) != $mvEmbedKey ){
 		return true;
 	}
 	//parse text for extra parameters
 	//@@todo integrate with image params / maybe file handle )
 	$params = explode('|', $text);
 	//setup defaults:
 	$size = $mvDefaultVideoPlaybackRes;
 	$start_ntp=$end_ntp=null;
 	foreach($params as $param){
 		if(substr( $param, -2) == 'px'){ //size param
 			if( strpos($param, 'x') === false ){
 				$k = intval( str_replace($param, 'px', '' ));
 				//@@todo should use the actual clips aspect ratio
 				$size = intval( $v ) . 'x' . (int) ( $mvDefaultAspectRatio *  $v );
 			}else{
 				list($width, $height) = explode('x', str_replace('px', '', $param ) );
 				$size =  intval( $width ) . 'x' . intval( $height );
 			}
 		}else{
 			//only applicable to Stream:
 			if( $title->getNamespace() == MV_NS_STREAM ){
		 		if( substr( $param, 0, 6 ) == 'start='){
		 			$start_str =  substr( $param, 6 );
		 			$timeSec = npt2seconds($start_str);
		 			if( (int) $timeSec > 0 )
		 				$start_ntp = seconds2npt($timeSec);
		 		}else if(substr( $param, 0, 4 ) == 'end='){
		 			$end_str =  substr( $param, 6 );
		 			$timeSec = npt2seconds($start_str);
		 			if( (int) $timeSec > 0 )
		 				$end_ntp = seconds2npt($timeSec);
		 		}else{
		 			//caption text / desc
		 		}
 			}
 		}
 	}

 	if( substr( $title->getText(), 0, strlen($mvEmbedKey) ) == $mvEmbedKey){
 		$resourceTitle = Title::newFromText( substr( $title->getText(), strlen($mvEmbedKey)+1) );
 		if( $resourceTitle->getNamespace() == MV_NS_STREAM){
 			$mvTitle =  new MV_Title( $resourceTitle );
 			$ret = $mvTitle->getEmbedVideoHtml( array( 'size'=>$size, 'showmeta'=>true ) );
 		}
 		if( $resourceTitle->getNamespace() == MV_NS_SEQUENCE){
 			$seqPlayer = new MV_SequencePlayer($resourceTitle);
 			$ret = $seqPlayer->getEmbedSeqHtml( array( 'size'=>$size ) );
 		}
 		return false;
 	}
 	return true;
 }
function mvAddToolBoxLinks(){
	global $wgTitle,$wgUser,$wgArticle;
	if( $wgTitle->getNamespace() == MV_NS_STREAM){
		//make sure the Messages are loaded
		//add export cmml link:
		$sTitle = Title::makeTitle( NS_SPECIAL, 'MvExportStream' );
		$sk = $wgUser->getSkin();
		$link = $sk->makeKnownLinkObj( $sTitle,wfMsg('mv_stream_resource_export'),
				'feed_format=roe&stream_name=' . htmlspecialchars( $wgArticle->mvTitle->getStreamName() ) . '&t=' . htmlspecialchars($wgArticle->mvTitle->getTimeRequest() ),
				'', '', 'title="' . htmlspecialchars( wfMsg( 'mv_export_cmml' ) ) . '"' );
		echo "<li>" . $link . "</li>";
	}
	return true;
}
// load the sequence page
function mvSeqTag( &$input, &$argv, &$parser ) {
	global $wgTitle;
	// print "cur title: " . $wgTitle->getDBkey() . ' ns: ' . $wgTitle->getNamespace();
	// check namespace (seq only show up via <tag> when in mvSequence namespace
	if ( !$wgTitle instanceof Title ) {
		wfDebugLog( 'mvSeqTag', "wgTitle not instance of Title`" );
		return true;
	}
	if ( $wgTitle->getNamespace() == MV_NS_SEQUENCE ) {
		$marker = MV_SequencePage::doSeqReplace( $input, $argv, $parser );
		return $marker;
	}
	return true;
}
 /*
  * This method will be called whenever an article is moved so that
  * updates the time stamps when an article is moved
  */
 function mvMoveHook( &$old_title, &$new_title, &$user, $pageid, $redirid ) {
 	global $mvgIP,$wgOut;

 	// die;
 	// confirm we are in the mvd Namespace & update the wiki_title
 	if ( $old_title->getNamespace() == MV_NS_MVD ) {
 		MV_Index::update_index_title( $old_title->getDBkey() , $new_title->getDBkey() );
 		//remove the old MVD having lots of redirects around is not fun
 		$oldArticle = new Article($old_title);
 		$oldArticle->doDelete( wfMsg('mv_move_delete_msg', $new_title->getText() ), false );
 		//clear output  @@todo (should really check for errors and integrate info into move)
 		$wgOut->clearHTML();
 	}else{
		 //make sure we call smwfMoveHook after and only if we don't delete
	 	if(function_exists('smwfMoveHook')){
	 		smwfMoveHook( $old_title, $new_title, $user, $pageid, $redirid );
	 	}
 	}

	return true;// always return true, in order not to stop MW's hook processing!
 }
 /*
*  This method will be called whenever an article is deleted so that
*  the metavid index is updated accordingly
*/
function mvDeleteHook( &$article, &$user, &$reason ) {
	global $mvgIP;
	// print 'mvDeleteHook'."\n";
	// only need to update the mvd index when in the mvd namespace:
	if ( $article->mTitle->getNamespace() == MV_NS_MVD ) {
		// remove article with that title:
		MV_Index::remove_by_wiki_title( $article->mTitle->getDBkey() );
	} else if ( $article->mTitle->getNamespace() == MV_NS_STREAM ) {
		$article->mvTitle->mvStream->deleteDB();
	}
	return true; // always return true, in order not to stop MW's hook processing!
}
function mvCustomEditor( &$article, &$user ) {
	global $wgTitle, $wgRequest;
	switch( $wgTitle->getNamespace() ) {
		case MV_NS_SEQUENCE:
			$editor = new MV_EditSequencePage( $article );
			$editor->edit();
			return false;
		break;
		case MV_NS_STREAM:
			$editor = new MV_EditStreamPage( $article );
			$editor->edit();
			return false;
		break;
		case MV_NS_MVD:
			$editor = new MV_EditDataPage( $article );
			$editor->edit();
			return false;
		break;
		default:
			// continue processing (use default editor)
			return true;
		break;
	}
	/*
	//@@todo how will 'external' editors work?
	if( !$wgRequest->getVal( 'UseExternalEditor' ) || $action=='submit' || $internal ||
	   $section || $oldid || ( !$user->getOption( 'externaleditor' ) && !$external ) ) {
		$editor = new MvEditSequence( $article );
		$editor->submit();
	} elseif( $wgRequest->getVal( 'UseExternalEditor' ) && ( $external || $user->getOption( 'externaleditor' ) ) ) {
		$mode = $wgRequest->getVal( 'mode' );
		$extedit = new ExternalEdit( $article, $mode );
		$extedit->edit();
	}*/

}
 /*
  * mvDoMvPage handles the article rewriting
  * by processing the given title request/namespace
  */
function mvDoMvPage ( &$title, &$article, $doOutput = true ) {
	global $wgOut, $wgTitle, $wgArticle;

	//add js
	mvAddPerNamespaceJS( $title );

	//do page replace:
	if ( $title->getNamespace() == NS_CATEGORY ) {
		$article = new MV_CategoryPage( $title );
	} elseif ( $title->getNamespace() == MV_NS_SEQUENCE ) {
		$article = new MV_SequencePage( $title );
 	} elseif ( $title->getNamespace() == MV_NS_STREAM ) {
		mvDoMetavidStreamPage( $title, $article );
	} elseif ( $title->getNamespace() == MV_NS_MVD ) {
 		$mvTitle = new MV_Title( $title->getDBkey() );
		// check if mvd type exist
		if ( $mvTitle->validRequestTitle() ) {
			if( $title->exists() ){
				// this page can be edited seen the MVD page:
				$article = new MV_DataPage( $title, $mvTitle );
			}
			// $title = 'Stream: ' . $mvTitle['type_marker'] . $mvTitle['stream_name'];
			// $body = 'body content';
			// mvOutputSpecialPage($title,$body);
		} else {
			// @@TODO get type of error: & put this in the language file
			// $title = 'missing type, stream missing, or not valid time format';
			if ( $doOutput )mvOutputSpecialPage( wfMsg( 'mvBadMVDtitle' ), wfMsg( 'mvMVDFormat' ) );
			return false;
		}
	}
	$wgArticle = $article;
	return true;
}
function mvCatHook( &$catArticle ) {
	global $mvgIP;
	$catArticle = new MV_CategoryPage( $catArticle );
	return true;
}
function mvMissingStreamPage( $missing_stream_name ) {
	$streamListTitle = Title::newFromText( 'Mv_List_Streams', NS_SPECIAL );
	$streamAddTitle = Title::newFromText( 'Mv_Add_Stream', NS_SPECIAL );

	$html = wfMsg( 'mv_missing_stream_text',
		$missing_stream_name,
		$streamListTitle->getFullURL(),
		$streamAddTitle->getFullURL() . '/' . $missing_stream_name
	);
	$title = wfMsg( 'mv_missing_stream' , $missing_stream_name );

	mvOutputSpecialPage( $title, $html );
}
/* ajax Entry points:
 * as entered in global functions: $wgAjaxExportList[]
 *
 * @@todo we could probably do a cleaner abstraction for ajax calls
*/
function mv_add_disp( $baseTitle, $mvdType, $time_range ) {
	$MV_Overlay = new MV_Overlay();
	return $MV_Overlay->get_add_disp( strtolower( $baseTitle ), $mvdType, $time_range );
}
function mv_disp_mvd( $titleKey, $mvd_id ) {
	$MV_Overlay = new MV_Overlay();
	return $MV_Overlay->get_fd_mvd_request( $titleKey, $mvd_id );
}
function mv_disp_remove_mvd( $titleKey, $mvd_id ) {
	$MV_Overlay = new MV_Overlay();
	return $MV_Overlay->get_disp_remove_mvd( $titleKey, $mvd_id );
}
function mv_remove_mvd() {
	$MV_Overlay = new MV_Overlay();
	return $MV_Overlay->do_remove_mvd( $_REQUEST['title'], $_REQUEST['mvd_id'] );
}
function mv_edit_disp( $titleKey, $mvd_id ) {
	$MV_Overlay = new MV_Overlay();
	return $MV_Overlay->get_edit_disp( $titleKey, $mvd_id );
}
/* general autocomplete */
function mv_helpers_auto_complete( $val = null ) {
	global $mvMetaDataHelpers, $wgRequest;
	$property = $wgRequest->getVal( 'prop_name' );
	switch( $property ) {
		case 'smw_speech_by':
			return MV_SpecialMediaSearch::auto_complete_person( $val );
		break;
		case 'smw_bill':
			return MV_SpecialMediaSearch::auto_complete_category( 'Bill', $val );
		break;
		case 'category':
			return MV_SpecialMediaSearch::auto_complete_search_categories( $val );
		break;
	}
}
function mv_auto_complete_person( $val = null ) {
	return MV_SpecialMediaSearch::auto_complete_person( $val );
}
function mv_auto_complete_all( $val = null ) {
	return MV_SpecialMediaSearch::auto_complete_all( $val );
}
function mv_auto_complete_stream_name( $val = null ) {
	return 	MV_SequenceTools::auto_complete_stream_name( $val );
}
function mv_edit_sequence_submit() {
	$MV_SequenceTools = new MV_SequenceTools();
	return $MV_SequenceTools->do_edit_submit();
}
/*
 * mv_edit_submit
 * @@todo this could be cleaned up by using the api .. lots of weridness otherwise
 */
function mv_edit_submit() {
	global $wgOut, $wgRequest;
	// @@todo more input scrubbing value checks
	$title_str = $wgRequest->getVal( 'title' );
	$mvd_id = $wgRequest->getVal( 'mvd_id' );
	if ( $title_str == '' || $mvd_id == '' )
		return 'error missing title or id';

	$MV_Overlay = new MV_Overlay();
	$do_adjust = $wgRequest->getVal( 'do_adjust' );
	if ( $do_adjust == 'true' ) {
		//first move then edit
		$adjust_ary = $MV_Overlay->do_adjust_submit( $wgRequest->getVal( 'titleKey' ),
					$mvd_id,
					$wgRequest->getVal( 'newTitle' ),
					$wgRequest->getVal( 'wgTitle' )		);

		//do edit:
		$outputMVD = $MV_Overlay->do_edit_submit( $wgRequest->getVal( 'newTitle' ), $mvd_id, false );
		$wgOut->clearHTML();
		$adjust_ary['fd_mvd']= $MV_Overlay->get_fd_mvd_request( $title_str, $mvd_id, 'enclosed', $outputMVD );

		return php2jsObj($adjust_ary);
	} else {
		return $MV_Overlay->do_edit_submit( $title_str, $mvd_id);
	}
}
function mv_history_disp( $titleKey, $mvd_id ) {
	global $wgOut;
	$MV_Overlay = new MV_Overlay();
	return $MV_Overlay->get_history_disp( $titleKey, $mvd_id );
}
/*function mv_adjust_disp($titleKey, $mvd_id){
	global $mvgIP;
	include_once($mvgIP . '/includes/MV_MetavidInterface/MV_Overlay.php');
	$MV_Overlay = new MV_Overlay();
	return $MV_Overlay->get_adjust_disp($titleKey, $mvd_id);
}*/
/*function mv_adjust_submit(){
	$MV_Overlay = new MV_Overlay();
	if(!isset($_POST['titleKey']) || !isset($_POST['newTitle']))
		return 'error: missing titleKey or newTitle';
	return $MV_Overlay->do_adjust_submit($_POST['titleKey'], $_POST['newTitle']);
}*/
function mv_seqtool_disp( $tool_id ) {
	$MV_SequenceTools = new MV_SequenceTools();
	return $MV_SequenceTools->get_tool_html( $tool_id );
}
function mv_seqtool_clipboard( $clipboard_action ){
	$MV_SequenceTools = new MV_SequenceTools();
	return $MV_SequenceTools->do_clipboard( $action );
}

function mv_tool_disp( $tool_id, $ns = '', $title_str = '' ) {
	$MV_Tools = new MV_Tools();
	return $MV_Tools->get_tool_html( $tool_id, $ns, $title_str );
}
function mv_expand_wt( $mvd_id ) {
	global $wgRequest;
	$search_terms = explode( '|', $wgRequest->getVal( 'st' ) );
	$mvSearch = new MV_SpecialMediaSearch();
	return $mvSearch->expand_wt( $mvd_id, $search_terms );
}
function mv_pl_wt( $mvd_id ) {
	global $wgRequest;
	$mvd = MV_Index::getMVDbyId( $mvd_id );
	$mvTitle = new MV_Title( $mvd->wiki_title );
	return $mvTitle->getEmbedVideoHtml( array('id'=>'vid_' . $mvd_id, 'size'=>$wgRequest->getVal( 'size' ), 'autoplay'=>true ) );
}
function mv_date_obj() {
	// returns the date object for existing stream set
	// @@todo this is very cacheable since it only changes when a streams change date or a new stream is added.
	return MV_SpecialMediaSearch::getJsonDateObj();
}
function mv_frame_server( $stream_name = '', $req_time = '', $req_size = '' ) {
	global $wgRequest;
	$stream_id = '';
	// try loading vals from $wgRequest if not set
	$stream_name = ( $stream_name == '' ) ? $wgRequest->getVal( 'stream_name' ):$stream_name;
	if ( $stream_name == null )$stream_id = $wgRequest->getVal( 'stream_id' );
	$req_time = ( $req_time == '' ) ? $wgRequest->getVal( 't' ):$req_time;
	$req_size = ( $req_size == '' ) ? $wgRequest->getVal( 'size' ):$req_size;
	$redirect_req = ( $wgRequest->getVal( 'redirect' ) == 'true' ) ? true:false;

	if ( $stream_id == '' ) {
		$mvStream =  mvGetMVStream( $stream_name );
		$stream_id = $mvStream->getStreamId();
	} else {
		$mvStream =  new MV_Stream( array( 'id' => $stream_id ) );
	}

	if ( $mvStream->db_load_stream() ) {
		global $mvServeImageRedirect, $mvExternalImages;
		if ( $mvServeImageRedirect || $redirect_req || $mvExternalImages ) {
			header( "Location:" . MV_StreamImage::getStreamImageURL( $stream_id, $req_time, $req_size, true ) );
		} else {
			// serve up the image directly
			MV_StreamImage::getStreamImageRaw( $stream_id, $req_time, $req_size, true );
		}
		exit();
	} else {
		return 'error: invalid stream name';
	}
}
/*function mv_edit_preview(){
	global $mvgIP;
	include_once($mvgIP . '/includes/MV_MetavidInterface/MV_Overlay.php');
	if(!isset($_POST['title']) || !isset($_POST['mvd_id']))
		return 'error missing title or id';
	$MV_Overlay = new MV_Overlay();
	return $MV_Overlay->edit_preview_form_html($_POST['title'], $_POST['mvd_id']);
}*/

