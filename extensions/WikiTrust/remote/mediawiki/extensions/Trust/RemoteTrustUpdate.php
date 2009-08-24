<?php

class TextTrustUpdate{

  /**
   * Update the DB when MW is updated.
   * This assums that the db has permissions to create tables.
   */
  public static function updateDB(){
    
    require_once(dirname(__FILE__) . '/' . "TrustUpdateScripts.inc");
    $db =& wfGetDB( DB_MASTER );
    
    // First check to see what tables have already been created.
    $res = $db->query("show tables");
    while ($row = $db->fetchRow($res)){
      $db_tables[$row[0]] = True;
    }
  
    foreach ($create_scripts as $table => $scripts) {
      if (!$db_tables[$table]){
	foreach ($scripts as $script){
	  $db->query($script);
	}
      }
    }
  }
}
?>