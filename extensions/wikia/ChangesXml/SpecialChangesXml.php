<?php
/**
 * This extension will keep trak of all changes over N characters in MAIN_NS
 * This data creates changes.xml file
 * Author Andrew Yasinky andrewy at wikia.com
 */

if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/wikia/ChangesXml/SpecialChangesXml.php" );
EOT;
    exit( 1 );
}

$wgExtensionFunctions[] = 'wfSpecialChangesXml';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ChangesXml',
	'author' => 'Andrew Yasinsky',
	'description' => 'ChagesXml feed',
);

function wfSpecialChangesXml() {
  //init
}

function wfChangesXml( $rc ) {

	//get old/new sizes
	extract($rc->mExtra);

	if ( isset( $oldSize ) && isset( $newSize ) ) {
	 //we only look at certain size in main namespace
	  if( abs( $newSize - $oldSize ) < 100 ){
	  	return true;
	  }
	}

	$titleObj = $rc->getTitle();
	if(	$titleObj->getNamespace() != NS_MAIN ){
 	 //we only want content
	 return;
	}	

	$title = $titleObj->getText();
	$title = str_replace(array("\n", "\r", '_'), array("", "",""), $title);
	$url = $titleObj->getFullURL();

	//store change
	$dbw = wfGetDBExt(DB_MASTER) ;
	
	$sql = "CREATE TABLE IF NOT EXISTS `_ext_changes_xml` ( " .           
                   " `id` bigint(20) NOT NULL auto_increment, " . 
                   " `title` varchar(100) default NULL, " .       
                   " `url` varchar(200) default NULL, " .         
                   " `timestamp` bigint(20) default NULL, " .      
                   " PRIMARY KEY  (`id`) " .                      
                 " ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ";
	
	$dbw->query( $sql );
	
	$res = $dbw->insert(
			'_ext_changes_xml',
			array(
				'title'		=> $title,
				'url'		=> $url,
				'timestamp'	=> time(),
			),
			__METHOD__
		);

	if ($dbw->getFlag(DBO_TRX)) {
		$dbw->commit();
	}
	
  return true;	
}

if( !empty( $wgEnableSpecialChangesXml ) ){
	$wgHooks['RecentChange_save'][] = 'wfChangesXml';
}
