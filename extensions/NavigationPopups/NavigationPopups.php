<?php

$wgExtensionCredits['other'][] = array( 
	'name'           => 'Navigation popups',
	'version'        => '0.1',
	'author'         => 'sanbeg',
	'description'    => 'Loads Lupin’s navigation popups in mediawiki',
	'descriptionmsg' => 'navigationpopups-desc',
	'url'            => 'http://en.wikipedia.org/wiki/Wikipedia:Tools/Navigation_popups',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['NavigationPopups'] = $dir . 'NavigationPopups.i18n.php';

$wgHooks['OutputPageParserOutput'][] = 'efInstallPopups';

function efInstallPopups( &$outputPage, $parserOutput) 
{
  global $wgJsMimeType, $wgScriptPath, $wgArticlePath;
  global $wgRequest;

  if ($wgRequest->getVal('popup') == 'no') return true;

  $thispath = $wgScriptPath . '/extensions/NavigationPopups';
  
  #we need article path to be of the from /APATH$1, to get the APATH we need.
  if (preg_match(':/(.+)/\$1$:', $wgArticlePath, $m)) {
    $apath = $m[1];
  }
  if (preg_match(':/(.+)$:', $wgScriptPath, $m)) {
    $bpath = $m[1];
  }
  
  #add the stylesheet
  $outputPage->addLink( 
		       array( 
			     'rel' => 'stylesheet', 
			     'type' => 'text/css', 
			     'href' => $thispath . '/navpop.css' 
			     ) 
		       );
  #add the javascript functions
  $outputPage->addScript( 
			 "<script type=\"{$wgJsMimeType}\" src=\"{$thispath}/popups.js\">" .
			 "</script>\n" 
			 );
  #local overrides
  $outputPage->addScript(
			 "<script type=\"{$wgJsMimeType}\">".
			 "function siteArticlePath(){ return '$apath'; }".
			 "function siteBotInterfacePath(){ return '$bpath'; }".
			 "popupImages=false;".
			 "</script>");
  return true;
}
