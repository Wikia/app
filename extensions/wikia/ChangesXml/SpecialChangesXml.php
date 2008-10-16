<?php
/**
 * This extension will keep trak of all changes over N characters in MAIN_NS
 * This data creates changes.xml file
 * Author Andrew Yasinky andrewy at wikia.com
 * enbaling parameter $wgEnableSpecialChangesXmlToFeedUrl is url of where to put data
 */

if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/wikia/ChangesXml/SpecialChangesXml.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
		'name' => 'ChangesXml',
		'author' => 'Andrew Yasinsky',
		'description' => 'ChagesXml feed',
);

function wfChangesXml( $rc ) {
	global $wgEnableSpecialChangesXmlToFeedUrl, $wgContLang, $wgUser, $wgServer, $wgArticlePath;

	//get old/new sizes
	extract( $rc->mExtra );
	extract( $rc->mAttribs ); //only to get user text
	
	if( isset( $oldSize ) && isset( $newSize ) ) {
		//we only look at certain size in main namespace
		if( abs( $newSize - $oldSize ) < 100 ) {
			return true;
		}
	}

	$titleObj = $rc->getTitle();

	if( $titleObj->getNamespace() != NS_MAIN ) {
		//we only want content
		return true;
	}	

	$title = $titleObj->getText();
	$title = str_replace( array( "\n", "\r", '_' ), array( "", "","" ), $title );
	$url = $titleObj->getFullURL();
	$wiki_atom = str_replace('$1', 'Special:Atom', $wgServer.$wgArticlePath);	
	$categories = $titleObj->getParentCategories();
	$category_string = $wgContLang->getNSText( NS_CATEGORY ) . ':';
	
	//see if user anon or not by ip
	
	$ut = explode('.',$rc_user_text);

	if ( count($ut) == 4 ) {		//ip;
	
		//ip;
		$uurl = '';
	} else {
		//username;
		$uurl = '<uri>' . str_replace('$1' , 'User:'. $rc_user_text, $wgServer.$wgArticlePath) . '</uri>';
	} 

	//PUT feed
	if( !empty( $wgEnableSpecialChangesXmlToFeedUrl ) ) {
		$a_data =  '<feed xmlns="http://www.w3.org/2005/Atom" >' . "\n";
		$a_data .= '  <title type="text">'. $title .'</title>' . "\n";
		$a_data .= '  <link href="' . $wgServer .'/" />' . "\n";
		$a_data .= '  <link rel="self" type="application/atom+xml" href="' . $wiki_atom .'" />' . "\n" ;
		$a_data .= "  <entry>" . "\n";
		$a_data .= "    <title>" . $title . "</title>" . "\n";
		$a_data .= '    <link href="' . $url . '" />' . "\n";
		$a_data .= "    <published>" . date( DATE_ATOM ) . "</published>" . "\n";
		$a_data .= "    <updated>" . date( DATE_ATOM ) . "</updated>" . "\n";
		$a_data .= "  	<author><name>" . $rc_user_text . "</name>".$uurl."</author>" . "\n";
			
		foreach( $categories as $key=>$value ) {
			$a_data .= '    <category term="' . str_replace( '_', ' ', str_replace( $category_string, '', $key) ) . '" />' . "\n";
		}
		$a_data .= "  </entry>" . "\n";
		$a_data .= "</feed>" . "\n";

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
		curl_setopt( $ch, CURLOPT_URL, $wgEnableSpecialChangesXmlToFeedUrl );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( "Content-Length: " . strlen( $a_data ) ) );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $a_data);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$r = curl_exec( $ch );

	}

	return true;
}

if( !empty( $wgEnableSpecialChangesXmlToFeedUrl ) ) {
	$wgHooks['RecentChange_save'][] = 'wfChangesXml';
}
