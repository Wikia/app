<?php
if( !defined( 'MEDIAWIKI' ) ) {
  die();
}

$wgExtensionFunctions[] = 'setupAOIcon';

function AOiconQuery($aoid) {
	/*
		CREATE TABLE `aodb` (
		  `aoid` varchar(20) default NULL,
		  `name` varchar(250) default NULL,
		  `ql` char(3) default NULL,
		  `itemtype` varchar(10) default NULL,
		  `icon` varchar(10) default NULL
		); 
	 */
	
	$dbw =& wfGetDB( DB_SLAVE );
	$obj = $dbw->selectRow( 'aodb',
            array( 'icon','name','itemtype','ql'),
            array( 'aoid' => $aoid),
            $fname);
	return $obj;

}

function setupAOIcon() {
  global $wgParser;
  $wgParser->setHook( 'aoicon', 'AIIconHandler' );
}

function AIIconHandler( $data ) {
	global $wgUploadPath;
	
	if(preg_match("/^([0-9]*)$/is",$data,$out)) {
		$res['AOIDloc'] = "AUNO";
		$res['AOID'] = $data;
		unset($data);
	}
	
	if($data) {
		$data = explode( '|', $data );
	
		if(preg_match("/^([0-9]*)$/is",$data[0],$out)) {
			$res['ICONID'] = $out[1];
			$data = $data[1];
		} else {
			$data = $data[0];
		}
		$data = explode(':',$data);
	   	$i = "0";
	
	    if(preg_match("/(AUNO|AODB|-)/is",$data[0],$out)) {
	    	$res['AOIDloc'] = $out[1];
	    	$i++;
	    } else {
	    	$res['AOIDloc'] = "AUNO";
	    }
	
		$res['AOID'] = $data[$i];$i++;
		$res['QL'] = $data[$i];$i++;
		$res['TEXT'] = $data[$i];$i++;
	}
	
	if(strlen($res['AOID']) > 0) {
		$obj = AOiconQuery($res['AOID']);
    	if(!$res['ICONID']) $res['ICONID'] = $obj->icon;
   		if(!$res['QL']) if($res['QL']) $obj->ql = $res['QL'];
   		$res['TITLE'] = $obj->name.' ('.$obj->ql.')'.' ('.$obj->itemtype.')';
	}

    if(preg_match("/([0-9]*)(px|%)/is",$res['TEXT'],$out)) {
    	if($out[2] == "%") $del = "%";
    	$res['SIZE'] = ' width="'.$out[1].$del.'"';
    	unset($res['TEXT']);
    }

	if($res['TEXT']) {
		$image = $res['TEXT'];
	}elseif ($res['ICONID']) {
  		$image = '<img src="'.$wgUploadPath.'/items/'.$res['ICONID'].'.png"'.$res['SIZE'].' />';
  	} else {
  		$image = 'n/a';
  	}  
 	
  	if($res['AOIDloc']== "AUNO" AND strlen($res['AOID']) > 0) {
  		if($res['QL']) $res['QLURL'] = '&ql='.$res['QL'];
  		$url = '<a href="http://auno.org/ao/db.php?id='.$res['AOID'].$res['QLURL'].'" target="_blank" title="'.$res['TITLE'].'">'.$image.'</a>';
  	} elseif($res['AOIDloc'] == "AODB" AND strlen($res['AOID']) > 0) {
		$url = '<a href="http://www.aomainframe.info/showitem.aspx?AOID='.$res['AOID'].'" target="_blank" title="'.$res['TITLE'].'">'.$image.'</a>';
  	} else {
  		$url = $image;
  	}
  
  return $url;
}


?>
