<?php


$wgExtensionFunctions[] = "wfPrototype";


function wfPrototype() {
        global $wgOut;
	$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Prototype/prototype.js\"></script>\n");
}



?>