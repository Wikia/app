<?php

$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'UserProfile_handler';

function UserProfile_handler(&$skin, &$tpl) {
	global $wgTitle,$wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;
	$wgOut->addStyle( "common/userpage_sidebar.css" );
	
	wfProfileIn(__METHOD__);
	if ( $wgTitle->getNamespace() != NS_USER) {
		return true;	
	};
	$html = '';

	wfRunHooks('AddToUserProfile', array(&$out));

	if(count($out) > 0) {
		$html .= '<aside id="profile-sidebar">';
		if(isset($out['UserProfile1'])) {
			$html .= $out['UserProfile1'];
		}
		if(isset($out['followedPages'])) {
			$html .= $out['followedPages'];
		}
		$html .= '</aside>';		

		$html .= "<div id='profile-content'>";
		$html .= $tpl->data['bodytext'];
		$html .= "</div>";
		
		$tpl->data['bodytext'] = $html;
	}	
	wfProfileOut(__METHOD__);
	return true;
}