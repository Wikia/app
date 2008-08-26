<?php
/*
 * Created on Jun 28, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * 
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
 global $mvgIP;
 require_once($mvgIP . '/includes/MV_MetavidInterface/MV_Component.php');
 class MV_Tools extends MV_Component{
 	var $mv_valid_tools = array(
		'mang_layers',
		//'search',
		'navigate',
		'export',
		//'embed',
		//'overlay'
	);
 	function getHTML(){
 		global $wgOut, $wgRequest;
 		//@@todo look at mv_interface context to get what to display in tool box:
 		$wgOut->addHTML('<div id="mv_tool_cont">');
 		$tool_req = $wgRequest->getVal('tool_disp');
 		if(in_array($tool_req, $this->mv_valid_tools)){
 			$this->get_tool_html($tool_req);
 			$wgOut->addHTML($this->innerHTML);
 		}else{
 			$this->get_tool_html('stream_page');
 		}
		$wgOut->addHTML('</div>');
	}
	/*function getStreamPage(){
		return ;		
	}*/	
	
	/* @@todo cache this */
	function get_tool_html($tool_id, $ns='', $title_str=''){		
		global $wgUser;
		if($title_str=='')$title_str = $this->mv_interface->article->mvTitle->getStreamName();
		if($ns=='')$ns = MV_NS_STREAM;
		switch($tool_id){
			case 'stream_page':
				global $wgOut, $wgParser;
				//render the wiki page for this stream				
				$title = Title::newFromText($title_str, $ns);			
				$curRevision = Revision::newFromTitle($title);
				
				//@@todo in the future a deleted Stream means 
				//remove stuff from stream table,mvd etc and return "missing Stream"
				
				if($curRevision==null){			
					$wgOut->addWikiText(wfMsg('noarticletext'));
					$this->innerHTML =  $wgOut->getHTML();
				}else{				
					$sk =& $wgUser->getSkin();
					//empty out the categories
					$wgOut->mCategoryLinks = array();
					//run via parser to add in Category info: 
					$parserOptions = ParserOptions::newFromUser( $wgUser );
					$parserOptions->setEditSection( false );
					$parserOptions->setTidy(true);
					$parserOutput = $wgParser->parse( $curRevision->getText() , $title, $parserOptions );
					$wgOut->addCategoryLinks( $parserOutput->getCategories() );
					$wgOut->addHTML( $parserOutput->mText );
					$wgOut->addHTML( $sk->getCategories() );
					//empty out the categories
					$wgOut->mCategoryLinks = array();
					
					//$wgOut->addWikiTextWithTitle( $curRevision->getText(), $tile) ;
					
					$this->innerHTML = $wgOut->getHTML();
				}
			break;			
			case 'mang_layers':
				$this->innerHTML = $this->get_mang_layers_page($title_str);
			break;
			case 'search':			
				$title = Title::newFromText($title_str, MV_NS_STREAM);
				//render search box
				$this->innerHTML = '<h3>Search Stream: '. $title_str . '</h3>';
				$MvSearch = new MV_SpecialMediaSearch();
				$MvSearch->setupFilters('stream', array('stream_name'=>$title->getDBkey() ));
				$this->innerHTML.= $MvSearch->dynamicSearchControl();
			break;	
			case 'navigate':
				//render full stream navigation
				$this->innerHTML = $this->get_nav_page($title_str);
			break;			
			case 'export':
				$this->innerHTML = $this->get_export_page($title_str);
			break;
			case 'embed':
				//display embed code:
				$this->innerHTML = 'embed page';
			break;
			case 'overlay':
				//display overlay options
				$this->innerHTML = 'overlay page';
			break;
			case 'menu':
				$this->innerHTML = $this->getToolsListing();
			break;
			default:
				$this->status='error';
				$this->innerHTML=wfMsg('mv_tool_missing', $tool_id);
			break;
		}
		return $this->return_obj();
	}	
	function return_obj(){	
		return php2jsObj(array( 'status'=>$this->status, 
							    'innerHTML'=>$this->innerHTML,
						    	'js_eval'=>$this->js_eval));
	}
	function render_menu(){
		return '<a href="javascript:mv_tool_disp(\'stream_page\')">'.wfMsg('mv_stream_meta').'</a>' .' | '. 
			'<a href="javascript:mv_tool_disp(\'menu\')">'.wfMsg('mv_stream_tool_heading').'</a>';
	}

	/* 
	 * outputs basic stream paging (this could be done client side)
	 *  
	 */
	function stream_paging_links($return_set='both'){
		global $wgUser, $mvDefaultStreamViewLength,$mvgScriptPath;
		$sk = $wgUser->getSkin();
		$prev_link=$next_link='';		
		//check if their is prev available:
		$mvTitle = $this->mv_interface->article->mvTitle;		
		if($return_set=='both'||$return_set=='prev'){
			if($mvTitle->getStartTimeSeconds()>0){			
				$prev_time_start = $mvTitle->getStartTimeSeconds()- $mvDefaultStreamViewLength;
				if($prev_time_start<0)$prev_time_start=0;
				$prev_time_end = $mvTitle->getEndTimeSeconds()- $mvDefaultStreamViewLength;
				if($prev_time_end < $mvDefaultStreamViewLength)$prev_time_end =$mvDefaultStreamViewLength;			
				$newTitle = Title::MakeTitle(MV_NS_STREAM, $mvTitle->getStreamName().'/'.seconds2ntp($prev_time_start).'/'.seconds2ntp($prev_time_end));
				$prev_link = $sk->makeKnownLinkObj($newTitle,
								 '<img style="index:5" border="0" src="'.$mvgScriptPath.'/skins/images/results_previous.png">',
								$this->getStateReq() );			
			}
		}
		if($return_set=='both'||$return_set=='next'){
			if($mvTitle->getDuration() != $mvTitle->getEndTimeSeconds()){
				$next_time_start = 	$mvTitle->getStartTimeSeconds()+$mvDefaultStreamViewLength;
				if($next_time_start > $mvTitle->getDuration()-$mvDefaultStreamViewLength)
					$next_time_start = $mvTitle->getDuration()-$mvDefaultStreamViewLength;
				$next_time_end = $mvTitle->getEndTimeSeconds()+$mvDefaultStreamViewLength;
				if($next_time_end >  $mvTitle->getDuration())$next_time_end=$mvTitle->getDuration();
				$newTitle =Title::MakeTitle(MV_NS_STREAM, $mvTitle->getStreamName().'/'.seconds2ntp($next_time_start).'/'.seconds2ntp($next_time_end));
				$next_link= $sk->makeKnownLinkObj($newTitle, 
									'<img style="index:5" border="0" src="'.$mvgScriptPath.'/skins/images/results_next.png">',
									$this->getStateReq() );
			}	
		}	
		if($return_set=='both')return $prev_link . ' ' . $next_link;
		if($return_set=='prev')return $prev_link;
		if($return_set=='next')return $next_link;
	}
	/*
	 * list all the available "tool" functions
	 * @@todo better integration with wiki 
	 * (ie tool listing should be a page like navigationBar or in our case MvStreamTools
	 */
	function getToolsListing(){		
		$out='';
		$heading=wfMsg('mv_stream_tool_heading') . ':';
		$out.='<ul>';
		foreach($this->mv_valid_tools as $tool_id){				 
			$out.='<li><a title="'.wfMsg('mv_tool_'.$tool_id.'_title').
			'" href="javascript:mv_tool_disp(\''.$tool_id.'\')">' .
			wfMsg('mv_tool_'.$tool_id) . '</li>'."\n";
		}		
		$out.='</ul>';
		return '<h3>'.$heading.'</h3>' . $out;			
	}
	//returns layers overview text 
	function get_mang_layers_page($stream_title){
		global $mvMVDTypeAllAvailable;
		$out='<h3>'.wfMsg('mv_tool_mang_layers').'</h3>';
		//grab the current track set: 	
		$this->procMVDReqSet();			
		foreach($mvMVDTypeAllAvailable as $type_key){
			//@@todo use something better than "title" for type_key description 
			$checked = (in_array($type_key, $this->mvd_tracks))?' checked':'';
			$out.='<input type="checkbox" name="option_'.$type_key.'"  id="option_'.$type_key.'" value="'.$type_key.'" '.$checked.'/> '.
				'<a class="mv_mang_layers" id="a_'.$type_key.'" title="'.wfMsg($type_key.'_desc').'" href="#">'.wfMsg($type_key).'</a><br />';
		}		
		$out.='<input id="submit_mang_layers" type="submit" value="'.wfMsg('mv_update_layers').'">';
		return $out;
	}
	function get_nav_page($stream_title){
		global $mvgIP;		
		//output sliders for stream navigation: 
		$out = '<h3>'.wfMsg('mv_tool_navigate').' '.ucfirst($stream_title).'</h3>';
		//normalize stream title: 
		$stream_title = str_replace(' ', '_', strtolower($stream_title));
		
		//get the total length of the stream: 		
		$stream =  new MV_Stream(array('name'=>$stream_title));
		//$out.= "sn: ". $stream->name . '<br />';
		$duration = $stream->getDuration();
		//$out.=" duration: $duration";			
		$MvOverlay = new MV_Overlay();					
		
		$titleKey = 'mvd_type:'.ucfirst($stream_title).'/'.$_REQUEST['time_range'];
		$out.= $MvOverlay->get_adjust_disp($titleKey, 'nav');
		$out.='<input type="button" id="mv_go_nav" value="Go">';		
		//set range: 
		$this->js_eval = "var end_time = {$duration};";
		return $out;
	}
	function get_export_page($stream_title){
		global $wgUser, $wgRequest;
		$req_time = ($wgRequest->getVal('time_range'))?'/'.$wgRequest->getVal('time_range'):'';
		$mvTitle = new MV_Title($stream_title. $req_time);		
		$sk = $wgUser->getSkin();
		$out = '<h3>'.wfMsg('mv_tool_export_title').'</h3>';
		$tr = $wgRequest->getVal('time_range');		
		//@@todo pull in metadata layer selector (populated by current selection set)
		//makeKnownLinkObj( $nt, $text = '', $query = '', $trail = '', $prefix = '' , $aprops = '', $style = '' ) 
		$sTitle = Title::makeTitle(NS_SPECIAL, 'MvExportStream');	
		$out.= $sk->makeKnownLinkObj($sTitle ,wfMsg('mv_export_cmml'),'feed_format=cmml&stream_name='.$stream_title.'&t='.$tr);
		$out.=' for '. $mvTitle->getTitleDesc();
		return $out;
	}
	function getStyleOverride(){
		if($this->mv_interface->smwProperties['playback_resolution']!=null){			
			@list($width,$height) = explode('x', $this->mv_interface->smwProperties['playback_resolution']);
			if(isset($width) && isset($height)){
				if(is_numeric($width) && is_numeric($height)){
					//offset in refrence to mv_custom.css 
					$width+=2;
					$height+=30;
					$top = $height+30+12;
					return "style=\"top:{$top}px;width:{$width}px;\"";
				}	
			}
		}
		return '';
	}
 }
?>
