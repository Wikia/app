<?php

/**
* Extension that makes an additional set of buttons on top of the edit page
*
* @package MediaWiki
* @subpackage Extensions
*
* @author Bartek Łapiński <bartek@wikia.com>
* @copyright Copyright (C) 2008, Wikia Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/

if ( defined( 'MEDIAWIKI' ) ) {

global $wgExtensionFunctions ;

$wgExtensionFunctions [] = 'wfTopEditButtonsSetup' ;

$wgExtensionCredits['other'][] = array(
        'name' => 'TopEditButtons',
        'version' => 0.25 ,
        'author' => 'Bartek Łapiński',
        'url' => 'http://www.wikia.com',
        'description' => 'Speeds up editing process by providing an additional set of edit buttons on top of the edit page',
);

function wfTopEditButtonsSetup () {
	global $wgHooks ;
	$wgHooks['EditPage::showEditForm:fields'][] = 'wfTopEditButtonsAdd' ;
	$wgHooks['SkinAfterBottomScripts'][] = 'wfTopEditButtonsIncludeJS' ;
	$wgHooks['EditPage::showEditForm:toolbar'][] = 'wfTopEditButtonsEraseStandardToolbar' ;
}

function wfTopEditButtonsEraseStandardToolbar ($editform, $out, $toolbar) {
	$toolbar = '' ;
	return true ;
}

function wfTopEditButtonsIncludeJS ($skin, $bottomScripts) {	
	global $wgExtensionsPath, $wgStyleVersion ;
        $bottomScripts .= "<script type=\"text/javascript\" src=\"$wgExtensionsPath/wikia/TopEditButtons/js/topeditbuttons.js?$wgStyleVersion\"></script>" ;
        return true ; 
}

function wfTopEditButtonsAdd ($editform) {
	global $wgOut, $wgUser ;
	$editbuttons = $editform->getEditButtons () ;
	// quick hack to give each button a unique id (remember, those buttons down there collide with them)
	foreach ($editbuttons as $name => $editbutton) {
		$editbuttons [$name] = str_replace ('id="wp' . ucfirst ($name) . '"', 'id="wp' . ucfirst ($name) . 'Upper"', $editbutton) ;
	}
	$sk = $wgUser->getSkin();

        $buttonshtml = implode( $editbuttons, "\n" );
	$cancel = $sk->makeKnownLink( $editform->mTitle->getPrefixedText(),
			wfMsgExt('cancel', array('parseinline')),
			'', '', '',
			'id="wpCancelUpper"');	

	$edithelpurl = Skin::makeInternalOrExternalUrl( wfMsgForContent( 'edithelppage' ));
	$edithelp = '<a target="helpwindow" href="'.$edithelpurl.'" id="wpEdithelpUpper">'.
		htmlspecialchars( wfMsg( 'edithelp' ) ).'</a> '.
		htmlspecialchars( wfMsg( 'newwindow' ) );

        $wgOut->addHTML ("
        	<style type=\"text/css\">
                	#wpSaveUpper, #wpDiffUpper {
				margin-right:0.33em;				
                        }
			#wpSaveUpper {
				font-weight: bold ;
			}
			.editButtonsUpper {
				margin-bottom: 0.66em;
			}
                </style>
        ") ;

	$toolbar = $editform->getEditToolbar () ;

	$wgOut->addHTML (
		"<div id='editButtonsUpper' class='editButtonsUpper'>
		{$buttonshtml}
	        <span class='editHelp'>{$cancel} | {$edithelp}</span>
		</div>
		{$toolbar}
	") ;
	return true ;
}

}

?>
