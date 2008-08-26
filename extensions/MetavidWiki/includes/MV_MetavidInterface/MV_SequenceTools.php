<?php
/*
 * MV_SequenceTools.php Created on Nov 2, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
  if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 //make sure the parent class mv_component is included
 
 class MV_SequenceTools extends MV_Component{
 	function getHTML(){
 		global $wgOut;
 		//@@todo look at mv_interface context to get what to display in tool box:
 		$wgOut->addHTML('<div style="overflow:auto;width:100%;height:90%" id="mv_seqtool_cont">');
 		//add in the tool container div:
 		$wgOut->addHTML('<div id="mvseq_sequence_page" class="mv_seq_tool">'); 
 			$this->get_tool_html('sequence_page');
 		$wgOut->addHTML('</div>');
		$wgOut->addHTML('</div>');
	}
	function get_tool_html($tool_id,  $ns='', $title_str=''){
		global $wgOut, $wgUser;	
		switch($tool_id){
			case 'sequence_page':
				global $mvgIP, $wgOut, $wgParser,$wgTitle;
				//put in header preview div: 
				$wgOut->addHTML('<div id="mv_seq_edit_preview"></div>');
									
				$article = & $this->mv_interface->article;
				$wgTitle = & $this->mv_interface->article->mTitle;
				$sk =& $wgUser->getSkin();						
				
				//get the ajax edit		
				$editPageAjax = new MV_EditPageAjax( $article);				
				$editPageAjax->mvd_id = 'seq';		
				
				//fill wgOUt with edit form: 
				$editPageAjax->edit();				
			break;
			case 'add_clips_manual':					
				$this->add_clips_manual();	 						
			break;
			case 'add_clips_search':
				$this->add_embed_search();
			break;
		}
		return $wgOut->getHTML();
	}
	function add_embed_search(){
		global $wgOut;
		//grab a de-encapsulated search
		$mvSearch = new MV_SpecialMediaSearch();		
		$mvSearch->setUpFilters();
		//do the search
		$mvSearch->doSearch();
		$wgOut->addHTML($mvSearch->dynamicSearchControl());		
		$wgOut->addHTML($mvSearch->getResultsHTML());
	}
	function auto_complete_stream_name($val){
		global $mvStreamTable, $mvDefaultSearchVideoPlaybackRes;
		$dbr =& wfGetDB(DB_SLAVE);		
		//check against stream name list: 
		$result = $dbr->select( $mvStreamTable, array('name','duration'), 
			array('`name` LIKE \'%'.mysql_escape_string($val).'%\''),
			__METHOD__,
			array('LIMIT'=>'5'));
		//print "ran: " . $dbr->lastQuery();
		if($dbr->numRows($result) == 0)return '';
		//$out='<ul>'."\n";
		$out='';
		while($row = $dbr->fetchObject($result)){			
			//make sure the person page exists: 									
			$streamTitle =  new MV_Title('Stream:'.$row->name.'/0:00:00/0:00:30');
			//print "stream name:" . $streamTitle->getStreamName();
			//@@TODO fix this up.. this is getting ugly new line in embed video for example breaks things	
			$out.=  $row->name.'|'.$streamTitle->getStreamNameText().				
				'|'.$streamTitle->getStreamImageURL('icon') .
				'|'.$row->duration . 
				'|'.$streamTitle->getEmbedVideoHtml('vid_seq', $mvDefaultSearchVideoPlaybackRes, 'http://metavid.ucsc.edu/image_media/'). "\n";								
		}
		//$out.='</ul>';
		//return people people in the Person Category
		return $out;
	}
	function add_clips_manual(){	
		global $wgOut, $mvgIP, $mvDefaultSearchVideoPlaybackRes;
		$MV_Overlay = new MV_Overlay();
		//add preview clips space and manual add title
		list($iw, $ih) = 	explode('x',$mvDefaultSearchVideoPlaybackRes);	
		$wgOut->addHTML('<h3>'.wfMsg('mv_add_clip_by_name').':</h3>' .			
			'<form id="mv_add_to_seq_form" action="">' .
			'<div id="mv_seq_manual_embed" style="display:none;position:relative;border:solid thin black;width:'.$iw.'px;height:'.$ih.'px;"> </div><br />'.			 
			wfMsg('mv_label_stream_name') . ': <input id="mv_add_stream_name" name="mv_add_stream_name" ' .
			' size="25" maxlength="65" ' .
			'value="">');
		$wgOut->addHTML('<div id="mv_add_stream_name_choices" class="autocomplete"></div>');			
		$wgOut->addHTML('<br class="mv_css_form">');
		//get adjustment disp: 
		$wgOut->addHTML( '<div id="mv_add_adj_cnt" style="display:none;">' . 
			$MV_Overlay->get_adjust_disp('seq', 'seq') .
			'<input type="button" value="'.wfMsg('mv_seq_add_end').'"  onClick="mv_add_to_seq();" >'.
			'<br class="mv_css_form">' .
		'</div></form>' );
	}
	function do_edit_submit(){
		global $mvgIP, $wgOut,$wgUser,$wgParser;		
		$titleKey = $_POST['title'];
		//set up the title /article
		$title = Title::newFromText($titleKey, MV_NS_SEQUENCE);
		$article = new MV_SequencePage($title);
				
		//print "inline_seq:" .  $_POST['inline_seq'] . " wpbox: " . $_REQUEST['wpTextbox1'] . "\n";
		$editPageAjax = new MV_EditPageAjax( $article);
		$editPageAjax->mvd_id ='seq';
		$textbox1='<'.SEQUENCE_TAG.'>'.$_POST['inline_seq'] . '</'.SEQUENCE_TAG.'>' . "\n".$_REQUEST['wpTextbox1'];
		//if($wgTitle->exists()){
		//print "article existing content: " . $Article->getContent();
		//}
		
		if(isset($_POST['wpPreview'])){
			$sk =& $wgUser->getSkin();
			//$wgOut->addWikiText($_REQUEST['wpTextbox1']);
			//run via parser so we get categories:			
			$parserOptions = ParserOptions::newFromUser( $wgUser );
			$parserOptions->setEditSection( false );
			$parserOptions->setTidy(true);
			//just parse the non-seq portion: 
			$parserOutput = $wgParser->parse( $_REQUEST['wpTextbox1'] , $title, $parserOptions );
			$wgOut->addCategoryLinks( $parserOutput->getCategories() );
			$wgOut->addHTML( $parserOutput->mText );
			$wgOut->addHTML( $sk->getCategories() );
			//empty out the categories
			$wgOut->mCategoryLinks = array();
			//add horizontal rule:
			$wgOut->addHTML('<hr></hr>');
			//$wgOut->addWikiTextWithTitle( $curRevision->getText(), $wgTitle) ;
			return $wgOut->getHTML();
		}						
		if($editPageAjax->edit($textbox1)==false){
			return php2jsObj(array('status'=>'ok'));	
		}else{
			//error: retrun error msg and form: 
			return $wgOut->getHTML();
		}		
	}
 	function render_menu(){		
		return
			'<a title="'.wfMsg('mv_sequence_page_desc').'" href="javascript:mv_seqtool_disp(\'sequence_page\')">'.wfMsg('mv_save_sequence').'</a>' .
		' | ' .	'<a title="'.wfMsg('mv_sequence_add_manual_desc').'" href="javascript:mv_seqtool_disp(\'add_clips_manual\')">'.wfMsg('mv_sequence_add_manual').'</a>' .
		' | ' .	'<a title="'.wfMsg('mv_sequence_add_search_desc').'" href="javascript:mv_seqtool_disp(\'add_clips_search\')">'.wfMsg('mv_sequence_add_search').'</a>' ;		
	}
 }
?>
