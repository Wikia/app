<?php
$wgExtensionFunctions[] = 'wfSpecialSiteScoutPage';

function wfSpecialSiteScoutPage(){
  global $wgUser,$IP;
  global $wgArticle;
  $title = Title::newFromText("whatever");
  $wgArticle = new Article($title);
  if(!is_object($wgArticle)){
    print "gah!";
  }
  include_once("includes/SpecialPage.php");

	class SiteScoutPage  extends SpecialPage {
	
	  function SiteScoutPage(){
	    UnlistedSpecialPage::UnlistedSpecialPage("SiteScout");
	  }
	  
	    function execute(){
			global $wgSiteView, $wgOut, $wgParser;

			require_once ('extensions/SiteScout/SiteScoutClass.php');
			require_once ('extensions/Avatar/AvatarClass.php');
		 
			$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/SiteScout/SiteScout.js\"></script>\n");
			$wgOut->setOnloadHandler( "start_scout()" );
			$output = '';
		
			$Scout = new SiteScoutHTML;
			$output .= $Scout->getControls();
			$output .=  $Scout->getHeader() . $Scout->displayItems();
			
			$output .= '<script language="javascript">itemMax = 30;timestamp = ' .  time() . ';</script>';
			$wgOut->addHtml($output);
		}
	}
	
	SpecialPage::addPage( new SiteScoutPage );
 	global $wgMessageCache,$wgOut;
 	$wgMessageCache->addMessage( 'sitescout', 'just a test extension' );
}
 
?>
