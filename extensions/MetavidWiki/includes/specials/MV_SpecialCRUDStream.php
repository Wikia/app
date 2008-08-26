<?php
/*
 * MV_SepcialAddStream.php Created on Apr 25, 2007
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 * 
 */
 
if (!defined('MEDIAWIKI')) die();
 
global $IP;
require_once( "$IP/includes/SpecialPage.php" );

function doSpecialAddStream() {
	$MV_SpecialAddStream = new MV_SpecialCRUDStream('add');
	$MV_SpecialAddStream->execute();
}
function doSpecialEditStream(){
	$MV_SpecialAddStream = new MV_SpecialCRUDStream('edit');
	$MV_SpecialAddStream->execute();
}

SpecialPage::addPage( new SpecialPage('Mv_Add_Stream','',true,'doSpecialAddStream',false) );
SpecialPage::addPage( new SpecialPage('Mv_Edit_Stream','',true,'doSpecialEditStream',false) );

class MV_SpecialCRUDStream {
	function __construct($mode){	
		$this->mode = $mode;
	}
	function execute() {
		global $wgRequest, $wgOut, $wgUser, $mvStream_name, $mvgIP;   
		#init html output var:
		$html='';                   

        # Get request data from, e.g.
        $title_str = $wgRequest->getVal('title');
                      
        //get Mv_Title to normalize the stream name:       
        $this->stream_name = ($wgRequest->getVal( 'stream_name')=='')?'':
        	 MV_Title::normalizeTitle( $wgRequest->getVal( 'stream_name') );
        	 
        $this->stream_type = 	$wgRequest->getVal('stream_type');                
        $this->wpEditToken =	$wgRequest->getVal( 'wpEditToken');
		$this->stream_desc  = 	$wgRequest->getVal( 'stream_desc');
		//grab the desc from the wiki page if not in the POST req
		if($this->stream_desc==''){			
			$desTitle = Title::makeTitle(MV_NS_STREAM, $this->stream_name );		
			//grab the article text:
			$curRevision = Revision::newFromTitle($desTitle);
			if($curRevision)
				$this->stream_desc = $curRevision->getText();
		}		
		
        if($this->stream_name==''){     
        	//default page request           	                
    		$parts = split('/',$title_str);
    		if(count($parts)>=2){
    			//means we can use part 1 as a stream name:
    			$this->stream_name =$parts[1]; 
    		}
		}else{
			if($this->mode=='add'){			
				//output add_ status to html
				$html.=$this->add_stream();
			}else{
				//possible edit
			}						
		}
					
		//if edit check for stream name:
    	if($this->mode=='edit' && $this->stream_name==''){
    		$html.=wfMsg('edit_stream_missing');	
			$wgOut->addHTML( $html );
    		return ;
    	}
    	
    	
    	$this->check_permissions();
    	
    	if(count($this->_allowedStreamTypeArray)==0){
    		//break out user lacks permissions to add anything
			$html.=wfMsg('add_stream_permission');	
			$wgOut->addHTML( $html );	
			return ;				        	
    	}	   
    	//output the stream form
    	//output the add stream form	
			$spectitle = Title::makeTitle( NS_SPECIAL, 'Mv_Add_stream' );		
			$docutitle = Title::newFromText(wfMsg('mv_add_stream'), NS_HELP);
			if($this->mode=='edit'){
				$mvStreamTitle = Title::makeTitle(MV_NS_STREAM,  $this->stream_name);
				if($mvStreamTitle->exists() ){
					$sk = $wgUser->getSkin();			
					$streamLink = $sk->makeLinkObj( $mvStreamTitle,  $this->stream_name );
					$html.=wfMsg('mv_edit_strea_docu', $streamLink);
				}
			}else{
				$html.= wfMsg('mv_add_stream_docu', $docutitle->getFullURL()) . "\n";
			}
			$html.= '<form name="add_stream" action="' . $spectitle->escapeLocalURL() . '" method="post" enctype="multipart/form-data">';
			$html.= '<fieldset><legend>'.wfMsg('mv_add_stream').'</legend>' . "\n" .
			         '<input type="hidden" name="title" value="' . $spectitle->getPrefixedText() . '"/>' ;
			$html.= '<table width="600" border="0">'.
					'<tr>';
					
			$html.= '<td  width="140">';		
			//output the stream type pulldown	
			$html.= '<i>'.wfMsg('mv_label_stream_name')."</i>:";
			$html.= '</td><td>';			
			$html.= '<input type="text" name="stream_name" value="'. htmlspecialchars( MV_Title::getStreamNameText($this->stream_name) ) .'" size="30" maxlength="1024"><br />' . "\n";				
			$html.= '</td>';
			$html.='<td><tr><td><i>'.wfMsg('mv_label_stream_type').'</i></td><td>';
			$html.='<select name="stream_type">'.
					'<option value="">Select Stream Type</option>'. "\n";				
			foreach($this->_allowedStreamTypeArray as $type=>$na){
				$sel= ($type==$this->stream_type)?'selected':'';
				$html.='<option value="'.$type.'" ' .$sel . '>'.wfMsg('mv_'.$type).'</option>'."\n";
			}					
			$html.=	'</select></tr>'."\n";
			$html.=		'<tr><td valign="top"><i>' .wfMsg('mv_label_stream_desc') .'</i>:</td><td>';
			//add an edit token (for the stream description)
			if ( $wgUser->isLoggedIn() ){
				$token = htmlspecialchars( $wgUser->editToken() );
			}else{
				$token = EDIT_TOKEN_SUFFIX;
			}
			$html .= "\n<input type='hidden' value=\"$token\"$docutitle name=\"wpEditToken\" />\n";
			//output the text area: 
			$html .= '<textarea tabindex="1" accesskey="," name="stream_desc" id="stream_desc" rows=6 cols=5>'.$this->stream_desc .'</textarea>' . "\n";
			$html .= '<br /><input type="submit" value="' . wfMsg('mv_add_stream_submit') . "\"/>\n</form>";
			
			$html .= '</td></tr></table>';
    		$html .='</fieldset>';
		  	# Output menu items 
			# @@todo link with language file                
            $wgOut->addHTML( $html );
            
            
            //output the stream files list (if in edit mode)
            if($this->mode=='edit')
    			$this->list_stream_files();  	            
	}
	/* for now its just a list no edit allowed 
	 * (all file management done via maintenance scripts )
	 */
	function list_stream_files(){
		global $wgOut;
		$html='';
		$stream =& mvGetMVStream(array('name'=>$this->stream_name));		
		$stream->db_load_stream();
		$stream_files = $stream->getFileList();
		
		if(count($stream_files)==0){
			$html.=wfMsg('mv_no_stream_files');	
			$wgOut->addHTML( $html );
			return ;
		}
		//output filedset container: 
		$html.= '<fieldset><legend>'.wfMsg('mv_file_list').'</legend>' . "\n";	
		$html.= '<table width="600" border="0">';	
		foreach($stream_files as $sf){
				$html.='<tr>';
					$html.='<td width="150">'.$sf->getFullURL().'</td>';
					$html.='<td>'.$sf->get_desc().'</td>';											
				$html.='</tr>';
		}
		$html .='</table></fieldset>';
		$wgOut->addHTML( $html );
		return '';	
	}
	function add_stream(){	
		$out='';		
		$mvTitle = new MV_Title( $this->stream_name );
		 	
		//fist check if the given stream name already exists
		if($mvTitle->doesStreamExist()){
			$mv_page = Title::newFromText($this->stream_name, MV_NS_STREAM);
			return '<span class="error">'.
					wfMsg('mv_stream_already_exists', $this->stream_name, $mv_page->getFullURL()).
				   '</span> ';										
		}else{
			//get the stream pointer
			$stream =& mvGetMVStream(array('name'=>$this->stream_name));
			//if the stream is inserted procced with page insertion
			if($stream->insertStream($this->stream_type)){
				global $wgUser;
				$sk = $wgUser->getSkin();
				
				//insert page
				$streamTitle =Title::newFromText( $this->stream_name, MV_NS_STREAM  );
				$wgArticle = new Article( $streamTitle );
				$success = $wgArticle->doEdit( $this->stream_desc, wfMsg('mv_summary_add_stream') );
				if ( $success ) {
					//stream inserted succesfully report to output				
					$streamLink = $sk->makeLinkObj( $streamTitle,  $this->stream_name );		
					$out='stream '.$streamLink.' added';													
					 
				} else {
					$out=wfMsg('mv_error_stream_insert');
				}
							
			}else{
				//stream failed insert
			}
					
		}	
		return $out;
	}	
	/*
	 * Returns an array of stream types the current user can add
	 * @@todo we should just check the $mvStreamTypePermission directly if we can...
	 * @@todo deprecate this: use mediaWikis user system: 
	 * $wgUser->isAllowed( 'trackback' ) 
	 */
	function check_permissions(){
		global $mvStreamTypePermission, $wgUser;
		$this->_allowedStreamTypeArray = array();
		
		$user_groups = $wgUser->getGroups();
		if($wgUser->isLoggedIn()){
			array_push($user_groups, 'user');
		}
		foreach($mvStreamTypePermission as $type=>$allowed_group_list){
			if(is_array($allowed_group_list)){
				foreach($allowed_group_list as $allowed){
					if(in_array($allowed, $user_groups)){
						$this->_allowedStreamTypeArray[$type]=true;
					}
				}
				
			}			
		}
		return $this->_allowedStreamTypeArray;
	}	
	
}
?>
