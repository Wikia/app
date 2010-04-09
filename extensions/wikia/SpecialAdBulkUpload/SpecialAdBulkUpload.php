<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
This file is not meant to be run by itself, but only as a part of MediaWiki
EOT;
        exit( 1 );
}
 
$wgExtensionCredits['SpecialAdBulkUpload'][] = array(
	'name' => 'SpecialAdBulkUpload',
	'author' => 'Aerik Sylvan',
	//'url' => 'http://www.mediawiki.org/wiki/Extension:MyExtension',
	'description' => 'Extension to allow users to buy sponsorships',
	//'descriptionmsg' => 'myextension-desc',
	'version' => '0.0.1',
);
 
$dir = dirname(__FILE__) . '/';
 
$wgAutoloadClasses['SpecialAdBulkUpload'] = $dir . 'SpecialAdBulkUpload_body.php'; 
$wgSpecialPages['AdBulkUpload'] = 'SpecialAdBulkUpload'; 

?>