<?php


$wgExtensionFunctions[] = "wfSkinForce";


function wfSkinForce() {
        global $wgUser, $wgDefaultSkin, $wgSiteView, $wgValidSkinNames;
	if($wgSiteView->getDomainName()!=""){
		$wgValidSkinNames["CologneBlue_view"] = "CologneBlue_view";
		$wgDefaultSkin = "CologneBlue_view";
	}else{
		$wgValidSkinNames[$wgDefaultSkin] = $wgDefaultSkin;
	}
        $wgUser->setOption( 'skin', $wgDefaultSkin );

}



?>