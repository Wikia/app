<?php

$wgExtensionFunctions[] = 'wfSetupListIncludedFiles';
$wgGroupPermissions['staff']['listincludedfilesright'] = true;
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['listincludedfiles'] = $dir . 'Special_ListIncludedFiles.i18n.php';


function wfSetupListIncludedFiles(){
	global $IP;
	require_once($IP . '/includes/SpecialPage.php');
	wfLoadExtensionMessages('listincludedfiles');
	SpecialPage::addPage(new SpecialPage('ListIncludedFiles', 'listincludedfilesright', true, 'wfListIncludedFiles', false));
}

function wfListIncludedFiles(){
	global $wgOut;
	global $wgRequest, $wgUser;


	ob_start();
	
	$includedFiles = get_included_files();
	sort($includedFiles);

	print count($includedFiles)." Included files:<ul>\n";
	foreach($includedFiles as $fileName){
		print "<li>$fileName</li>\n";
	}
	print "</ul>\n";

	$html = ob_get_clean();
	$wgOut->addHTML($html);
}

?>
