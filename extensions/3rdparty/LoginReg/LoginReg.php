<?php


$wgExtensionFunctions[] = "wfLoginReg";


function wfLoginReg() {
        global $wgOut, $wgUser;
	if(!$wgUser->isLoggedIn()){
		$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/LoginReg/LoginReg.js\"></script>\n");
	}
}



?>