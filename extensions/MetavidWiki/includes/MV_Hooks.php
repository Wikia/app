<?php
/*
 * MV_Hooks.php Created on Apr 24, 2007
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 * 
 * 
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 
	/*
	*  This method will be called after an article is saved
	* to update the metavid data index
	*/
 	function mvSaveHook(&$article, &$user, &$text, &$summary, $minor, $watch, $sectionanchor, &$flags){
 		global $mvgIP;
 	
 		//confirm we are in the metavid data Namespace (where data indexes are updated)
 		if($article->mTitle->getNamespace()==MV_NS_MVD){ 				 				
 			MV_Index::update_index_page($article,$text);
 		} 		
 		return true; // always return true, in order not to stop MW's hook processing!		 			
 	}
 	/*
 	 * mvisValidMoveOperation
 	 */ 	
 	 function mvisValidMoveOperation( &$new_title){ 	 
 		$mvTitle = new MV_Title( $new_title->getDBkey() ); 		
 		if( $mvTitle->validRequestTitle() ){ 		
 			return true;
 		}else{
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
 	 function mvParserAfterTidy(&$parser, &$text) {
	    // find markers in $text
	    // replace markers with actual output
	    global $markerList;
	    for ($i=0;$i<count($markerList);$i++)
	      $text = preg_replace('/xx-marker'.$i.'-xx/',$markerList[$i],$text);
	    return true;
	}
	//load the sequence page 
	function mvSeqTag(&$input, &$argv, &$parser){
		global $wgTitle;	
		//print "cur title: " . $wgTitle->getDBkey() . ' ns: ' . $wgTitle->getNamespace();	
		//check namespace (seq only show up via <tag> when in mvSequence namespace
		if($wgTitle->getNamespace() == MV_NS_SEQUENCE ){	
			$marker = MV_SequencePage::doSeqReplace($input, $argv, $parser);
			return $marker;
		}
		return '';
	}
 	/*
 	 * This method will be called whenever an article is moved so that
 	 * updates the time stamps when an article is moved
 	 */
 	function mvMoveHook(&$old_title, &$new_title, &$user, $pageid, $redirid){
 		global $mvgIP;
 		//die;
 		//confirm we are in the mvd Namespace & update the wiki_title
 		if($old_title->getNamespace()==MV_NS_MVD){							 
 			MV_Index::update_index_title($old_title->getDBkey() , $new_title->getDBkey()); 			
 		}
		return true;// always return true, in order not to stop MW's hook processing!
 	} 	
 	/*
	*  This method will be called whenever an article is deleted so that
	*  the metavid index is updated accordingly 
	*/
	function mvDeleteHook(&$article, &$user, &$reason) {
		global $mvgIP;
		//print 'mvDeleteHook'."\n";
		//only need to update the mvd index when in the mvd namespace: 
		if($article->mTitle->getNamespace()==MV_NS_MVD){
			//remove article with that title: 
			MV_Index::remove_by_wiki_title($article->mTitle->getDBkey());
		}else if($article->mTitle->getNamespace()==MV_NS_STREAM){
			MV_Index::remove_by_stream_id($article->mvTitle->mvStream->getStreamId());
			$article->mvTitle->mvStream->deleteDB();		
		}
		return true; // always return true, in order not to stop MW's hook processing!
	}
	function mvCustomEditor(&$article, &$user){
		global $wgTitle, $wgRequest;
		switch($wgTitle->getNamespace()){
			case MV_NS_SEQUENCE:
				$MvInterface = new MV_MetavidInterface('edit_sequence', $article);
				$MvInterface->render_full();		
				return false;
			break;
			case MV_NS_STREAM:
				$editor = new MV_EditStreamPage($article);
				$editor->edit();
				return false;
			break;
			case MV_NS_MVD:
				$editor = new MV_EditDataPage( $article );
				$editor->edit();
				return false;
			break;
			default:
				// continue proccessing (use default editor)
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
	 * mvDoSpecialPage hanndles additional javascript for some special pages 	 
	 */
	 function mvDoSpecialPage($wgOut){
	 	global $wgTitle;	
	 	//if special semantic browse page (moved to all pages)  
 		//if($wgTitle->getNamespace()==NS_SPECIAL && $wgTitle->getText()=='Browse'){
 		//	mvfAddHTMLHeader('smw_ext');
 		//}
	 	return true;
	 }
 	/*
 	 * mvDoMvPage handles the article rewriting 
 	 * by processing the given title request/namespace
 	 */
 	function mvDoMvPage (&$title, &$article, $doOutput=true){
		global $wgOut;		
		if($title->getNamespace() == NS_CATEGORY){
			$article = new MV_CategoryPage($title);		
		} elseif ($title->getNamespace() == MV_NS_SEQUENCE){			
			$article = new MV_SequencePage($title);												
 		} elseif ($title->getNamespace() == MV_NS_STREAM){					
			mvDoMetavidStreamPage($title, $article);		
		} elseif ( $title->getNamespace() == MV_NS_MVD ) {								
 			$mvTitle = new MV_Title( $title->getDBkey() ); 		
			//check if mvd type exist 
			if( $mvTitle->validRequestTitle() ){							
				//this page can be edited seen the MVD page:				
				$article = new MV_DataPage($title, $mvTitle);	
				//$title = 'Stream: ' . $mvTitle['type_marker'] . $mvTitle['stream_name'];
				//$body = 'body content';
				//mvOutputSpecialPage($title,$body);
			}else{
				//@@TODO get type of error: & put this in the language file
				//$title = 'missing type, stream missing, or not valid time format';				
				if($doOutput)mvOutputSpecialPage(wfMsg('mvBadMVDtitle'), wfMsg('mvMVDFormat'));
				return false;
			}
		}
		return true;
	}
	function mvCatHook(&$catArticle){
		global $mvgIP;		
		$catArticle = new MV_CategoryPage($catArticle);
		return true;
	}
	function mvMissingStreamPage($missing_stream_name){
		$streamListTitle = Title::newFromText(wfMsg('mv_list_streams_page'), NS_SPECIAL);
		$streamAddTitle = Title::newFromText(wfMsg('mv_add_stream_page'), NS_SPECIAL);
		
		$html = wfMsg('mv_missing_stream_text',
			$missing_stream_name, 
			$streamListTitle->getFullURL(),
			$streamAddTitle->getFullURL() . '/'.$missing_stream_name
		);
		$title = wfMsg( 'mv_missing_stream' , $missing_stream_name);		
			
		mvOutputSpecialPage($title, $html );
	}
	/* ajax Entry points:
	 * as entered in global functions: $wgAjaxExportList[] 
	 * 
	 * @@todo we could probably do a cleaner abstraction for ajax calls
	*/	
	function mv_add_disp($baseTitle, $mvdType, $time_range){
		$MV_Overlay = new MV_Overlay();
		return $MV_Overlay->get_add_disp(strtolower($baseTitle), $mvdType, $time_range);
	}
	function mv_disp_mvd($titleKey, $mvd_id){		
		$MV_Overlay = new MV_Overlay();
		return $MV_Overlay->get_fd_mvd_request($titleKey, $mvd_id);
	}
	function mv_disp_remove_mvd($titleKey, $mvd_id){		
		$MV_Overlay = new MV_Overlay();
		return $MV_Overlay->get_disp_remove_mvd($titleKey, $mvd_id);
	}
	function mv_remove_mvd(){		
		$MV_Overlay = new MV_Overlay();
		return $MV_Overlay->do_remove_mvd($_REQUEST['title'], $_REQUEST['mvd_id']);
	}
	function mv_edit_disp($titleKey, $mvd_id){
		$MV_Overlay = new MV_Overlay();
		return $MV_Overlay->get_edit_disp($titleKey, $mvd_id);
	}
	function mv_auto_complete_person($val=null){		
		return MV_SpecialMediaSearch::auto_complete_person($val);
	}
	function mv_auto_complete_all($val=null){
		return MV_SpecialMediaSearch::auto_complete_all($val);
	}
	function mv_auto_complete_stream_name($val=null){	
		return 	MV_SequenceTools::auto_complete_stream_name($val);
	}	
	function mv_edit_sequence_submit(){		
		$MV_SequenceTools = new MV_SequenceTools();
		return $MV_SequenceTools->do_edit_submit();	
	}
	function mv_edit_submit(){
		global $wgOut;		
		if(!isset($_POST['title']) || !isset($_POST['mvd_id']))
			return 'error missing title or id';		
		$MV_Overlay = new MV_Overlay();	
		/*if($_POST['mvd_id']=='new'){
			return $MV_Overlay->do_add_mvd();			
		}*/
		if(!isset($_POST['do_adjust']))$_POST['do_adjust']=false;		
		if($_POST['do_adjust']=='true'){
			//first edit then move
			$outputMVD = $MV_Overlay->do_edit_submit($_POST['title'], $_POST['mvd_id']);
			//clear the wgOut var: 
			$wgOut->clearHTML();
			//do move and display output page 			
			return $MV_Overlay->do_adjust_submit($_POST['titleKey'], $_POST['mvd_id'], $_POST['newTitle'], $_POST['wgTitle'], $outputMVD);
		}else{
			return $MV_Overlay->do_edit_submit($_POST['title'], $_POST['mvd_id']);
		}
	}
	function mv_history_disp($titleKey, $mvd_id){
		global $wgOut;		
		$MV_Overlay = new MV_Overlay();
		return $MV_Overlay->get_history_disp($titleKey, $mvd_id);
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
	function mv_seqtool_disp($tool_id){		
		$MV_SequenceTools = new MV_SequenceTools();		
		return $MV_SequenceTools->get_tool_html($tool_id);
	}
	function mv_tool_disp($tool_id, $ns='', $title_str=''){
		$MV_Tools = new MV_Tools();			
		return $MV_Tools->get_tool_html($tool_id, $ns, $title_str);
	}
	function mv_expand_wt($mvd_id){		
		global $wgRequest;		
		$search_terms = explode('|',$wgRequest->getVal('st'));	
		$mvSearch = new MV_SpecialMediaSearch();		
		return $mvSearch->expand_wt($mvd_id, $search_terms);
	}
	function mv_date_obj(){
		//returns the date object for existing stream set
		//@@todo this is very cacheable since it only changes when a streams change date or a new stream is added. 
		return MV_SpecialMediaSearch::getJsonDateObj();	
	}
	function mv_frame_server($stream_name='',$req_time='', $req_size=''){
		global $wgRequest;
		$stream_id='';
		//try loading vals from $wgRequest if not set
		$stream_name=($stream_name=='')?$wgRequest->getVal('stream_name'):$stream_name;
		if($stream_name==null)$stream_id=$wgRequest->getVal('stream_id');
		$req_time=($req_time=='')?$wgRequest->getVal('t'):$req_time;
		$req_size=($req_size=='')?$wgRequest->getVal('size'):$req_size;
		$redirect_req=($wgRequest->getVal('redirect')=='true')?true:false;
		
		if($stream_id==''){
			$mvStream =  mvGetMVStream($stream_name);
			$stream_id=$mvStream->getStreamId();
		}else{
			$mvStream =  new MV_Stream(array('id'=>$stream_id));
		}
		
		if($mvStream->db_load_stream()){			
			global $mvServeImageRedirect, $mvExternalImages;
			if($mvServeImageRedirect || $redirect_req || $mvExternalImages){
				header("Location:" . MV_StreamImage::getStreamImageURL($stream_id, $req_time, $req_size, true));
			}else{								
				//serve up the image directly
				MV_StreamImage::getStreamImageRaw($stream_id, $req_time, $req_size, true);
			}
			exit();
		}else{
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
 
 
?>
