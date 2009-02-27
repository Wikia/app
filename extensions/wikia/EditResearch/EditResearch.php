<?php
/*
 * Author: David Pean
 */

$wgExtensionCredits['other'][] = array(
    'name' => 'EditResearch',
    'author' => 'David Pean',
);

$wgExtensionMessagesFiles['EditResearch'] = dirname(__FILE__).'/'.'EditResearch.i18n.php';

$wgHooks['EditForm:BeforeDisplayingTextbox'][] = 'AddEditResearch';
function AddEditResearch($o) {
	global $wgUser, $wgOut, $wgHooks, $wgTitle, $wgStylePath, $wgStyleVersion, $wgExtensionsPath, $wgEditResearchNamespaces ;
	
	if( ! empty($wgEditResearchNamespaces) ){
		if( $wgEditResearchNamespaces[ $wgTitle->getNamespace() ] != true ){
			return true;
		}
	}else{
		if( $wgTitle->getNamespace() != NS_MAIN ){
			return true;
		}
	}

	wfLoadExtensionMessages('EditResearch');
	
	$wgOut->addScript('<link rel="stylesheet" type="text/css" href="'.$wgExtensionsPath.'/wikia/EditResearch/EditResearch.css?'.$wgStyleVersion.'"/>');
	$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/EditResearch/EditResearch.js?'.$wgStyleVersion.'"></script>');

	$script = '
	<script type="text/javascript">
		var wgNextMsg = "' . wfMsg('next')  . '";
		var wgPrevMsg = "' . wfMsg('previous')  . '";
		var wgNoResultsMsg = "' . wfMsg('research_no_results')  . '";
	</script>';
	$wgOut->addHtml( $script );
	
	$wgOut->addHtml( "<div id='research-container'>");
	$wgOut->addHtml( "<h3>" . wfMsg("research_wikipedia_title") . "</h3>" );
	$wgOut->addHtml( "<div id='research-inner'>");
	$wgOut->addHtml( "<div id='research-search'>");					
	$wgOut->addHtml(wfMsg("search_wikipedia") . ' <input type="text" id="search_input"> <input id="search_button" type="button" value="' . wfMsg("go") . '" onclick="research()">');
	$wgOut->addHtml('</div>');
	$wgOut->addHtml('<div id="research_box" ></div></div></div>');
	
	return true;
}


