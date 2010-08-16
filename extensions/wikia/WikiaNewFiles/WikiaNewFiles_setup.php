<?php
/**
 * @file
 * @ingroup SpecialPage
 * Extends the IncludeableSpecialPage to override some of the header formatting
 *
 */


$dir = dirname( __FILE__ );

// Translations
$wgExtensionMessagesFiles["WikiaNewFiles"] =  $dir . '/SpecialNewFiles.i18n.php';

// Autoloaded classes
$wgAutoloadClasses['WikiaNewFiles'] = "$dir/WikiaNewFiles.class.php";

require_once($dir . '/SpecialNewFiles.php');

//echo '<pre>'.print_r($wgSpecialPages, true).'</pre>';
$wgSpecialPages['NewFiles'] = array( 'WikiaNewFiles', 'NewFiles' );