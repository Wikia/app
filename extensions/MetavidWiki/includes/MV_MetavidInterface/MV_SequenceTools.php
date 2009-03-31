<?php
/*
 * MV_SequenceTools.php Created on Nov 2, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 */
  if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 // make sure the parent class mv_component is included

 class MV_SequenceTools extends MV_Component {
 	var $valid_tools=array(
 		'sequence_page',
 		'add_clips_manual',
 		'transition',
		'clipedit',
 		'cliplib',
 		'options' 		 		
 	);
 	function getHTML() {
 		global $wgOut;
 		// @@todo look at mv_interface context to get what to display in tool box:
 		$wgOut->addHTML( '<div style="overflow:auto;width:100%;height:90%" id="mv_seqtool_cont">' );
 		// add in the tool container div:
 		$wgOut->addHTML( '<div id="mvseq_sequence_page" class="mv_seq_tool">' );
 			$this->get_tool_html( 'sequence_page' );
 		$wgOut->addHTML( '</div>' );
		$wgOut->addHTML( '</div>' );
	}
	function get_tool_html( $tool_id,  $ns = '', $title_str = '' ) {
		global $wgOut, $wgUser;		
		//check if we are proccessing a set:
		$tool_set = explode('|', $tool_id); 
		if(count($tool_set)>1){
			$tool_values = array();
			foreach($tool_set as $tool_id){
				if( in_array($tool_id, $this->valid_tools )){
					$tool_values[$tool_id] = $this->get_tool_html($tool_id);
				}
			}
			return mvOutputJSON( $tool_values );
		}
		$wgOut->clearHTML();
		//else process a single tool: 
		switch( $tool_id ) {
			case 'sequence_page':
				global $mvgIP, $wgOut, $wgParser, $wgTitle;
				// put in header preview div: 
				$wgOut->addHTML( '<div id="mv_seq_edit_preview"></div>' );
									
				$article = & $this->mv_interface->article;
				$wgTitle = & $this->mv_interface->article->mTitle;
				$sk =& $wgUser->getSkin();
				
				// get the ajax edit		
				$editPageAjax = new MV_EditPageAjax( $article );
				$editPageAjax->mvd_id = 'seq';
				
				// fill wgOUt with edit form: 
				$editPageAjax->edit();
			break;
			case 'add_clips_manual':
				$this->add_clips_manual();
			break;				
			case 'clipedit':
				//the default clip view provides a "welcome / help  page"
				$wgOut->addHTML( wfMsg('mv_welcome_to_sequencer') );
			break;
			case 'cliplib':
				$this->add_embed_search();		
			break;
			case 'options':
				$this->add_editor_options();
			break;
			case 'transition':
				$this->add_transitions();
			break;
			default:				
				$wgOut->addHTML( wfMsg('mv_tool_missing',  htmlspecialchars ($tool_id) ) );
			break;
		}
		return $wgOut->getHTML();
	}	
	//handles copy / paste clip board data actions
	function do_clipboard( $action ){
		global $wgRequest, $wgUser;
		//validate the user-edit token (for both copy and paste)	
		$token = $wgRequest->getVal( 'clipboardEditToken');
					 
		//store the clipboard
		if( $action == 'copy' ){			
			return '1'; 	
		}
		//get the clipboard
		if( $action == 'paste'){
			return '';
		}						
		//error out: 
		return  php2jsObj( array( 	'status' => 'error',
									'error_txt' => wfMsg('mv_unknown_clipboard_action') 
								) 
						 );
	}
	function add_embed_search() {
		global $wgOut;
		// grab a de-encapsulated search with prefix		
		$wgOut->addHTML( '<h3>'. wfMsg('mv_resource_locator') . '</h3>' );
		//add the input form 
		/*$wgOut->addHTML( 			
			xml::input('mv_ams_search', 50,'', array( 'id' => 'mv_ams_search' , 'class' => 'searchField' )) . 
			xml::submitButton( wfMsg('mv_media_search'), array('id'=>'mv_ams_submit') ) .
			xml::element('div',array('id'=>'mv_ams_results'))
		);*/
	}
	function add_editor_options(){
		global $wgOut;
		$wgOut->addHTML( '<h3>' . wfMsg('mv_editor_options') . '</h3>'.
				wfMsg('mv_editor_mode') . '<br> ' .
				'<blockquote><input type="radio" value="simple_editor" name="opt_editor">' . 
						wfMsg('mv_simple_editor_desc') . ' </blockquote>' .
				'<blockquote><input type="radio" value="advanced_editor" name="opt_editor">' .
						wfMsg('mv_advanced_editor_desc') . ' </blockquote>'.
				wfMsg('mv_other_options') . '<br>' . 
				'<blockquote><input type="checkbox" value="contextmenu_opt" name="contextmenu_opt">' . 
						wfMsg('mv_contextmenu_opt') . ' </blockquote>'				
				 );				
	}
	function add_transitions(){
		global $wgOut;
		$wgOut->addHTML('<h3>'. wfMsg('mv_transitions') .'</h3>');				
	}
	function auto_complete_stream_name( $val ) {
		global $mvDefaultSearchVideoPlaybackRes;
		$dbr =& wfGetDB( DB_SLAVE );
		// check against stream name list: 
		$result = $dbr->select( 'mv_streams', array( 'name', 'duration' ),
			array( '`name` LIKE \'%' . mysql_escape_string( $val ) . '%\'' ),
			__METHOD__,
			array( 'LIMIT' => '5' ) );
		// print "ran: " . $dbr->lastQuery();
		if ( $dbr->numRows( $result ) == 0 )return '';
		// $out='<ul>'."\n";
		$out = '';
		while ( $row = $dbr->fetchObject( $result ) ) {
			// make sure the person page exists: 									
			$streamTitle =  new MV_Title( 'Stream:' . $row->name . '/0:00:00/0:00:30' );
			// print "stream name:" . $streamTitle->getStreamName();
			// @@TODO fix this up.. this is getting ugly new line in embed video for example breaks things	
			$out .=  $row->name . '|' . $streamTitle->getStreamNameText() .
				'|' . $streamTitle->getStreamImageURL( 'icon' ) .
				'|' . $row->duration .
				'|' . $streamTitle->getEmbedVideoHtml( array('id'=>'vid_seq', 
															 'size'=>$mvDefaultSearchVideoPlaybackRes)) . "\n";
		}
		// $out.='</ul>';
		// return people people in the Person Category
		return $out;
	}
	function add_clips_manual() {
		global $wgOut, $mvgIP, $mvDefaultSearchVideoPlaybackRes;
		$MV_Overlay = new MV_Overlay();
		// add preview clips space and manual add title
		list( $iw, $ih ) = 	explode( 'x', $mvDefaultSearchVideoPlaybackRes );
		$wgOut->addHTML( '<h3>' . wfMsg( 'mv_add_clip_by_name' ) . ':</h3>' .
			'<form id="mv_add_to_seq_form" action="">' .
			'<div id="mv_seq_manual_embed" style="display:none;position:relative;border:solid thin black;width:' . htmlspecialchars( $iw ) . 'px;height:' . htmlspecialchars( $ih ) . 'px;"> </div><br />' .
			wfMsg( 'mv_label_stream_name' ) . ': <input id="mv_add_stream_name" name="mv_add_stream_name" ' .
			' size="25" maxlength="65" ' .
			'value="">' );
		$wgOut->addHTML( '<div id="mv_add_stream_name_choices" class="autocomplete"></div>' );
		$wgOut->addHTML( '<br class="mv_css_form">' );
		// get adjustment disp: 
		$wgOut->addHTML( '<div id="mv_add_adj_cnt" style="display:none;">' .
			$MV_Overlay->get_adjust_disp( 'seq', 'seq' ) .
			'<input type="button" value="' . wfMsg( 'mv_seq_add_end' ) . '"  onClick="mv_add_to_seq();" >' .
			'<br class="mv_css_form">' .
		'</div></form>' );
	}
	function do_edit_submit() {
		global $mvgIP, $wgOut, $wgUser, $wgParser;
		$titleKey = $_POST['title'];
		// set up the title /article
		$title = Title::newFromText( $titleKey, MV_NS_SEQUENCE );
		$article = new MV_SequencePage( $title );
				
		// print "inline_seq:" .  $_POST['inline_seq'] . " wpbox: " . $_REQUEST['wpTextbox1'] . "\n";
		$editPageAjax = new MV_EditPageAjax( $article );
		$editPageAjax->mvd_id = 'seq';
		$textbox1 = '<' . SEQUENCE_TAG . '>' . $_POST['inline_seq'] . '</' . SEQUENCE_TAG . '>' . "\n" . $_REQUEST['wpTextbox1'];
		// if($wgTitle->exists()){
		// print "article existing content: " . $Article->getContent();
		// }

		if ( isset( $_POST['wpPreview'] ) ) {
			$sk =& $wgUser->getSkin();
			// $wgOut->addWikiText($_REQUEST['wpTextbox1']);
			// run via parser so we get categories:			
			$parserOptions = ParserOptions::newFromUser( $wgUser );
			$parserOptions->setEditSection( false );
			$parserOptions->setTidy( true );
			// just parse the non-seq portion: 
			$parserOutput = $wgParser->parse( $_REQUEST['wpTextbox1'] , $title, $parserOptions );
			$wgOut->addCategoryLinks( $parserOutput->getCategories() );
			$wgOut->addHTML( $parserOutput->mText );
			$wgOut->addHTML( $sk->getCategories() );
			// empty out the categories
			$wgOut->mCategoryLinks = array();
			// add horizontal rule:
			$wgOut->addHTML( '<hr></hr>' );
			// $wgOut->addWikiTextWithTitle( $curRevision->getText(), $wgTitle) ;
			return $wgOut->getHTML();
		}
		if ( $editPageAjax->edit( $textbox1 ) == false ) {
			return php2jsObj( array( 'status' => 'ok' ) );
		} else {
			// error: retrun error msg and form: 
			return $wgOut->getHTML();
		}
	}
 }
?>
