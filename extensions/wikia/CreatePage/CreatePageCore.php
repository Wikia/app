<?php
if ( ! defined( 'MEDIAWIKI' ) )
        die();

$wgHooks ['EditFilter'][] = 'wfCreatePageSanityCheck' ;

function wfCreatePageSanityCheck () {
	global $wgRequest, $wgOut ;

	$isCreatePage = $wgRequest->getBool ('wpCreatePage') ;

	if ($isCreatePage) {
		if ($wgRequest->getVal ('title') == '' ) {
                	/*	do not allow blanking Main Page each time non-js user hits 'Create Article'
				go back to SpecialCreatePage and display error
			*/
			$titleObj = Title::makeTitle (NS_SPECIAL, 'Createpage') ;
			$wgOut->redirect ( $titleObj->getFullURL ('action=failure')) ;
			return false ;
		}
	}
        return true ;
}

?>
