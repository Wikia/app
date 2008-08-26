<?php
/*
 * Created on Jun 28, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * 
 * The metavid interface class
 * provides the metavid interface for Metavid: requests
 * provides the base metadata
 * 
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );

 
 class MV_MetavidInterface{
 	var $components = array();
 	var $context=null;
 	var $page_title='';
 	var $page_header=''; 	
 	//list the properties we are intersted and there default values: 
 	var $smwProperties = array('playback_resolution'=>null);
 	function __construct($contextType, & $contextArticle=null ){
 		global $mv_default_view;
 		$this->context = $contextType;
 		if($contextArticle)
 			$this->article = & $contextArticle; 
		//set up base layout for each context:		
 		switch($contextType){
 			case 'special':
 				$this->setupSpecialView();
 			break;
 			case 'edit_sequence':
 				$this->setupEditSequenceView();
 			break;
 			case 'sequence': 				
 				$this->setupSequenceView();
 			break;
 			case 'stream': 				
 				$this->setupStreamView();
 			break; 		
 		}  	
 	}
 	/*function setupSequenceView(){
 		global $mvgIP;
 		//set up the base sequence: 
 		foreach(array('MV_VideoPlayer', ''
 		/*foreach(array('MV_VideoPlayer') as $cp_name){
			require_once($mvgIP . '/includes/MV_MetavidInterface/'.$cp_name.'.php');
			$this->components[$cp_name] = new $cp_name( 
				array('mv_interface'=>&$this)
			);				
		}
 	}*/
 	function setupEditSequenceView(){
 		global $mvgIP, $wgTitle;
 		foreach(array('MV_SequencePlayer', 'MV_SequenceTools', 'MV_SequenceTimeline') as $cp_name){			
			$this->components[$cp_name] = new $cp_name( 
				array('mv_interface'=>&$this)
			);				
		}
		//set up additonal pieces
		$this->page_title=wfMsg('mv_edit_sequence', $wgTitle->getText() );		
 	}
 	function setupStreamView(){
 		global $mvgIP, $mvDefaultStreamViewLength, $wgOut,$mvgScriptPath,$wgUser; 	 		
 			 	 	
 		//set default time range if null time range request
 		$this->article->mvTitle->setStartEndIfEmpty();
 		//grab relevent article semantic properties (so far playback_resolution) for user overwriting playback res
 		$this->grabSemanticProp();
 		
		//set up the interface objects:
		foreach(array('MV_VideoPlayer', 'MV_Overlay','MV_Tools') as $cp_name){
			$this->components[$cp_name] = new $cp_name( 
				array('mv_interface'=>&$this)
			);				
		}
		//process track request:
		$this->components['MV_Overlay']->procMVDReqSet();				
		//add in title & tracks var:
 		$wgOut->addScript('<script type="text/javascript">/*<![CDATA[*/'." 		
 		var mvTitle = '{$this->article->mvTitle->getWikiTitle()}'; 
 		var mvTracks = '".$this->components['MV_Overlay']->getMVDReqString(). '\';
 		/*]]>*/</script>'."\n");
		
		//also add prev next paging	 		
		$this->page_header ='<span class="mv_stream_title">'.
 			$this->article->mvTitle->getStreamNameText().
 			$this->components['MV_Tools']->stream_paging_links('prev') . 
				' <span id="mv_stream_time">'.$this->article->mvTitle->getTimeDesc() . '</span>'.
			$this->components['MV_Tools']->stream_paging_links('next') .
			wfMsg('mv_of') . seconds2ntp($this->article->mvTitle->getDuration()) .  			
		'</span>';	
		
		//add export cmml icon
		$this->page_header.='<span id="cmml_link"/>';
			$sTitle = Title::makeTitle(NS_SPECIAL, 'MvExportStream');	
			$sk = $wgUser->getSkin();
			$this->page_header.= $sk->makeKnownLinkObj($sTitle,
				'<img style="width:28px;height:28px;" src="'.$mvgScriptPath . '/skins/images/Feed-icon_cmml_28x28.png">',
				'feed_format=roe&stream_name='.$this->article->mvTitle->getStreamName().'&t='.$this->article->mvTitle->getTimeRequest(),
				'','','title="'.wfMsg('mv_export_cmml').'"');
		$this->page_header.='</span>';		
		$this->page_title = $this->article->mvTitle->getStreamNameText().' '.$this->article->mvTitle->getTimeDesc();
 	}
 	//grab semantic properties if availiable:  	
 	//@@todo we need to think this through a bit
 	function grabSemanticProp(){ 		
 		if(SMW_VERSION){
 			//global $smwgIP;
 			$smwStore =& smwfGetStore(); 			
 			foreach($this->smwProperties as $propKey=>$val){
 				$propTitle = Title::newFromText($propKey, SMW_NS_PROPERTY);
 				$smwProps = $smwStore->getPropertyValues($this->article->mTitle,$propTitle );
 				//just a temp hack .. we need to think about this abstraction a bit... 	
 				if(count($smwProps)!=0){			
 					$v = current($smwProps); 					
	 				$this->smwProperties[$propKey]=$v->getXSDValue(); 				
 				}
 			} 		 			
 		}
 	}
 	/*
 	 * renders the full page  to the wgOut object
 	 */
 	function render_full(){
 		global $wgOut; 	
 		//add some variables for the interface: 	 		
 		
 		//output title and header: 		
 		$wgOut->setHTMLTitle($this->page_title);
 		
 		if($this->page_header=='')$this->page_header = '<span style="position:relative;top:-12px;font-weight:bold">' . 
 			$this->page_title . '</span>';
 		$wgOut->addHTML($this->page_header); 		 		
 		
 		//@@todo dynamic re-size page_spacer:
 		$wgOut->addHTML('<div id="mv_page_spacer">');	 
 		foreach($this->components as $cpKey => &$component){ 			
 			$component->render_full(); 			
 		} 		 	
 		$wgOut->addHTML('</div>');
 		//for now output spacers 
		//@@todo output a dynamic spacer javascript layout		
		//$out='';  	
 		//for($i=0;$i<28;$i++)$out.="<br />";
 		//$wgOut->addHTML($out);
 		//} 		 		
 	} 	
 }
?>
