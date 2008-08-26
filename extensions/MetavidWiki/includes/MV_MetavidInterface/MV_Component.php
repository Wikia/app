<?php
if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
/*
 * Created on Jun 28, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * the base component class
 */
 class MV_Component{
 	var $name = 'MV_Component';
 	var $mv_interface=null;
 	//default values: 
 	var $status='ok';
 	var $innerHTML ='';
 	var $js_eval=false;  	 	
 	var $req = '';
 	var $mvd_tracks=array();
 	
 	function __construct($init=array()){
 		foreach($init as $k=>$v){
 			$this->$k=$v;
 		}
 	} 	
 	//process the request set (load from settings if not set in url 
	//@@todo would be good to allow user-set preference in the future)
	function procMVDReqSet($only_requested=false){
		global $wgRequest;
		global $mvMVDTypeDefaultDisp, $mvMVDTypeAllAvailable;
		//if already computed return: 
		if(count($this->mvd_tracks)!=0)return $this->mvd_tracks;
		$user_tracks = $wgRequest->getVal('tracks');
		//print "USER TRACKS: " . $user_tracks;
		if($user_tracks!=''){
			$user_set = explode(',',$user_tracks);			
			foreach($user_set as $tk){
				if(in_array($tk, $mvMVDTypeAllAvailable)){
					$this->mvd_tracks[]= $tk;	
				}	
			}
		}else{		
			if(!$only_requested){	
				//set the default tracks (if not restricted to requested tracks)  
				foreach($mvMVDTypeDefaultDisp as $tk){
					if(!in_array($tk, $mvMVDTypeAllAvailable)){
						global $wgOut;
						$wgOut->errorPage('mvd_default_mismatch','mvd_default_mismatch_text');
					}	
				}
				//just set to global default: 
				$this->mvd_tracks = $mvMVDTypeDefaultDisp;		
			}
		}
	}
	function getStateReq(){
		global $wgRequest, $mvMVDTypeDefaultDisp;
		$req='';
		$this->procMVDReqSet();
		$and='';
		if(count($this->mvd_tracks)!=0){
			//don't include request if identical to default: '
			if($this->mvd_tracks!=$mvMVDTypeDefaultDisp){
				$req.='tracks='.$this->getMVDReqString();
				$and='&';
			}
		}
		//save tool_disp: 
		if($wgRequest->getVal('tool_disp')!=''){
			$req.=$and.'tool_disp='.$wgRequest->getVal('tool_disp');
		}
		return $req;
	}
	function getMVDReqString(){
		if(count($this->mvd_tracks)==0)$this->procMVDReqSet();
		return implode(',',$this->mvd_tracks);
	}
 	function getReqStreamName(){ 
 		if(isset($this->mv_interface->article))
 			return $this->mv_interface->article->mvTitle->getStreamName();
 		return null;
 	} 	
 	function setReq($req, $q=''){ 		
 		$this->req=$req; 	
 		if($q!=''){
 			$this->q=$q;
 		}
 	}
 	/* to be overwritten by class */
	function getHTML(){
		global $wgOut;
		$wgOut->addHTML( get_class($this) . ' component html');
	}
	function render_menu(){
		return get_class($this) . ' component menu';
	}
	function getStyleOverride(){
		return '';
	} 
 	function render_full(){
 		global $wgOut;
 		//"<div >" . 		 		
 		$wgOut->addHTML("<fieldset ".$this->getStyleOverride()." id=\"".get_class($this)."\" >\n" .
 					"<legend id=\"mv_leg_".get_class($this)."\">".$this->render_menu()."</legend>\n"); 				
 		//do the implemented html 
 		$this->getHTML(); 
 		$wgOut->addHTML("</fieldset>\n");
	}
 }
?>
