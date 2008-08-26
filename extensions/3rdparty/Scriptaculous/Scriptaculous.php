<?php


$wgExtensionFunctions[] = "wfScriptaculous";


function wfScriptaculous() {
        global $wgOut;
	$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Scriptaculous/scriptaculous.js\"></script>\n");
}



?>