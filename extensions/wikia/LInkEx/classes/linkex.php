<?php
require_once(dirname(__FILE__) . '/googpr.php');

class clsLinkEx {
  var $db;	//pointer to db connection
  var $conf;  
  var $pr;
	
 function __construct() {
	//init if anything
 }
 
 function init( &$conf, &$db = null ) {
 	$this->db = $db;
 	$this->conf = $conf;
	$this->pr = new GoogPr();
 	return true;
 }

 
 function initdb(){
	//class settings
	 $sql = "CREATE TABLE IF NOT EXISTS `" . $this->conf['BASE']['database'] . "`.`" . $this->conf['BASE']['table'] . "` (" .
							  "`id` int(11) NOT NULL auto_increment," .
							  "`source_id` varchar(22) NOT NULL default ''," .
							  "`site_title` varchar(50) NOT NULL default ''," .
							  "`site_url` varchar(255) NOT NULL default ''," .
							  "`site_host` varchar(100) NOT NULL default ''," .
							  "`referals` int(11) NOT NULL default '0'," .
							  "`site_email` varchar(255) NOT NULL default ''," .
							  "`site_receip` varchar(255) NOT NULL default ''," .
							  "`description` varchar(255) NOT NULL default ''," .
							  "`pub` smallint(6) NOT NULL default '0'," .
							  "`pub_guid` varchar(32) default NULL," .
							  "`ok_guid` varchar(32) default NULL," .
							  "`created_at` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP," .
							  "UNIQUE KEY `id` (`id`)," .
							  "UNIQUE KEY `source_host` (`source_id`,`site_host`)," .
							  "KEY `pub_guid` (`pub_guid`)," .
							  "KEY `ok_guid` (`pub_guid`)" . 
							") ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
     //return sql to execute
 	 $this->runsql( $sql, true );
	 return true;
 }  
  
 function getLinkList( $newlinkguid = "", $addpr = false ){
    //outputs list of links for given id, and that were verified active
	
	if( $newlinkguid == "" ){
  	$source_str = "";
	
		if( $this->conf['BASE']['source_id'] != "" ){
			$source_str = "source_id = '" . $this->conf['BASE']['source_id'] . "' AND";
		}
		
		$sql = "select * from `" . $this->conf['BASE']['database'] . '`.' . $this->conf['BASE']['table'] . " where " . $source_str . " pub = 1";	
	
	}else{
		
		$sql = "select * from `" . $this->conf['BASE']['database'] . '`.' . $this->conf['BASE']['table'] . " where pub_guid='" . $newlinkguid . "'";
	}
	
	$r = $this->runsql( $sql, false, true );

	
	foreach ($r as $key => $value ){
	  	if( $addpr ){
		 $r[$key]['pr'] = $this->pr->pagerank($value['site_url']);
		}else{
		 $r[$key]['pr'] = "";	
		}
	}
	
	return $r;
  }
  
 function approve( $guid ){
 	$sql = "update `" . $this->conf['BASE']['database'] . "`.`" . $this->conf['BASE']['table'] . "` set pub=1 where ok_guid='". $guid ."'";
	$this->runsql( $sql, true );
	return true;
 }
 
 function disapprove( $guid ){
 	$sql = "delete from `" . $this->conf['BASE']['database'] . "`.`" . $this->conf['BASE']['table'] . "` set pub=1 where ok_guid='". $guid ."'";
	$this->runsql( $sql, true );
	return true;
 }
  
 function runsql( $query, $master = false, $retresult = false ){
	
 	if( $this->conf['BASE']['port'] == "wiki" ) {
		//run  wiki port
	
	 	$r = array();
	  	//executes sql code, replace with platform specific
		
		if( $master ){
		    //write
			$db =& wfGetDB( DB_MASTER );
			$result = $db->query( $query ) ;
			
			if( $retresult == false ){
			  $db->close();	
			  return $r;	
			}else{

			  while( $row = $db->fetchObject( $result ) ) {
				$r[] =	get_object_vars( $row );
			  }
			}  
		
		}else{
			//read
			$db =& wfGetDB( DB_SLAVE );
			$result = $db->query( $query ) ;
	
			  while( $row = $db->fetchObject( $result ) ) {
				$r[] =	get_object_vars( $row );
			  }

			
		}
	}else{
	  //run wp port	
	}	 
	 return $r;
	
  }
  
  function addlink( $param ){
	  $ok_guid = $this->make_guid();
      $pub_guid = $this->make_guid();

	  $sql = "insert into `" . $this->conf['BASE']['database'] . "`.`" . $this->conf['BASE']['table'] . "` ( source_id, site_title, site_url, site_host, site_email, site_receip, description, pub_guid, ok_guid ) values ('" . $this->db_str( $this->conf['BASE']['source_id'] ) . "', '" . $this->db_str( $param['data.site_name'] ) . "', '" . $this->db_str( $param['data.site_url'] ) . "', '" . $this->db_str( $param['data.conflink'] ) . "', '" . $this->db_str( $param['data.site_email'] ) . "', '" . $this->db_str( $param['data.site_receip'] ) . "', '" . $this->db_str( strip_tags( $param['data.site_description'] ) ) . "','" . $pub_guid . "','" . $ok_guid . "') ON DUPLICATE KEY UPDATE ok_guid='" . $ok_guid . "',pub_guid='" . $pub_guid . "'";
	  
      $msg = "";
      $subj = "";
      $subj = "New new link is submitted to " . $param['data.homesite'] . " !";
	  $msg = $subj . "\n";
	  $msg .="Here is a link text \n";
	  $msg .= "\n\n";
	  $msg .= $param['data.site_name'];
      $msg .= "\n\n";
      $msg .= $param['data.site_url'];
      $msg .= "\n\n";
      $msg .= $param['data.site_description'];
      $msg .= "\n\n";
      $msg .="Here is Reciprocal Link location \n\n";
      $msg .= $param['data.site_receip'];
      $msg .= "\n\n";
      $msg .= "To Allow this link Click here: " . $param['extensionurl'] . '?ok=' . $ok_guid . "\n\n";
      $msg .= "To Delete this link Click here: " . $param['extensionurl'] . '?notok=' . $ok_guid . "\n\n";
	
	  $to =	new MailAddress( $this->conf['BASE']['wiki_email'] );
	  $from = new MailAddress( $this->conf['BASE']['wiki_email'] );
	  
	  $mailResult = UserMailer::send($to, $from, $subj, $msg);	

	  $msg = "";
      $subj = "Your link submitted to " . $param['data.homesite'] . " !";
  	  $msg .= "Thank you for link submission to " . $param["data.homesite"] ."\n\n";
  	  $msg .= "Your link is here: " . $param['extensionurl'] . "?newlink=" . $pub_guid ."\n\n";
	  $msg .= "In order for your link to visible on our link page you will also need to add the following link to your site.\n";
	  $msg .= "*************************\n\n";
	  $msg .= str_replace( array( '&lt;', '&gt;' ),array( '<', '>' ), $param['msg.homelink'] ) . "\n\n";
	  $msg .= "*************************\n"; 
	  $msg .= "Thereafter click on this link from your site.\n When visit to our site from your link is detected your link will become visible on our links page.\n\n";
	  $msg .= "Thank You!\n  " . $param["data.homesite"] . " team.\n\n";


   	  $to =	new MailAddress( $param['data.site_email'] );
	  $from = new MailAddress( $this->conf['BASE']['wiki_email'] );
	  
	  $mailResult = UserMailer::send($to, $from, $subj, $msg);			

	  $this->runsql( $sql, true );
  }
  
  function make_guid(){
	 srand((double)microtime()*1000000);
	 $r = rand() ;
	 $u = uniqid(getmypid() . $r . (double)microtime()*1000000,1);
	 $m = md5 ($u);
	 return($m);
  }
  
  function db_str( $string ) {

    if ( function_exists( 'mysql_real_escape_string' ) ) {
      return mysql_real_escape_string( $string );
    } elseif ( function_exists( 'mysql_escape_string' ) ) {
      return mysql_escape_string( $string );
    }

    return addslashes( $string );
  }
  

}//class end

?>