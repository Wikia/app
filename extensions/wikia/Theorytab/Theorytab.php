<?php

if(!defined('MEDIAWIKI')) {
   header("HTTP/1.1 404 Not Found");
   die('<H1>404 Not found</H1>');
   }

/**
 * A hook that adds a theories tab to Lostpedia
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Justin Bremer - Lostpedia
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
$wgExtensionMessagesFiles['Theorytab'] = dirname( __FILE__ ) . '/Theorytab.i18n.php';
$wgExtensionCredits['other'][] = array(
    'name' => 'Theory Tab',
    'description' => 'Adds a theories tab to articles',
    'author' => array(
		'[http://lostpedia.com/wiki/User:jabrwocky7 Jabberwock]',
		'[http://www.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]'
	)
);

# Enable subpages in the main namespace
$wgNamespacesWithSubpages[NS_MAIN] = true;

//install extension hooks
$wgHooks['SkinTemplateTabs'][] = 'efTheoryTabHook';

// add a tab on the article page
function efTheoryTabHook(&$skin , &$content_actions ) {
	global $wgTitle;

	wfLoadExtensionMessages('Theorytab');

  	$tTheory =  wfMsg('theorytab-subpage');
  	$tTheoryTabName = wfMsg('theorytab-title');
  	$tParentTabName = wfMsg('theorytab-parent-title');

	// Common Variables
  	$tMain = $wgTitle->getLocalUrl('');
  	$tHREF = $tMain.$tTheory;


//create the theory tab for regular articles in NS_MAIN namespace
if ( $wgTitle->getNamespace() == NS_MAIN 
     && $wgTitle->getArticleId() !== Title::newMainPage()->getArticleId()
     && strstr($wgTitle->getLocalUrl(''),$tTheory) == FALSE ) {
  
  $content_actions['TheoryTab'] = array(
    'class' => "",
    'text'  => $tTheoryTabName,
    'href'  => $tHREF
    );

//If already on the theory page, make a tab for the parent article.
  } else if ( strstr($wgTitle->getLocalUrl(''),$tTheory) == TRUE
     && $wgTitle->getNamespace() == 0 
     && $wgTitle->getArticleId() !== Title::newMainPage()->getArticleId() ) {
  
  $tMain = substr_replace ($tMain, '', -(strlen($tTheory)));
  $content_actions['TheoryTab'] = array(
    'class' => "",
    'text'  => $tParentTabName,
    'href'  => $tMain
    );
  }

  	// Hook must return a value
	return(true);

}//endfunction efTheoryTabHook
