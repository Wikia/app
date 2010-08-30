<?php
/*
 * Author: David Pean
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ActionPanel',
	'author' => 'David Pean',
	'descriptionmsg' => 'actionpanel-desc',
);

$wgAvailableRights[] = 'actionpanel';
$wgGroupPermissions['staff']['actionpanel'] = true;
$wgGroupPermissions['actionpanel']['actionpanel'] = true;

$wgExtensionMessagesFiles['ActionPanel'] = dirname(__FILE__).'/'.'ActionPanel.i18n.php';
$wgHooks['MakeGlobalVariablesScript'][] = 'fnAddActionPanelJSGlobalVariables';
function fnAddActionPanelJSGlobalVariables(&$vars){
	global $wgTitle, $wgContLang;
	wfLoadExtensionMessages('ActionPanel');
	$vars['wgActionPanelTitleMsg'] = wfMsg("action_panel_title");
	$vars['wgActionPanelEditMsg'] = wfMsg("action_panel_edit_title");
	$vars['wgActionPanelRenameMsg'] = wfMsg("movepagebtn");
	$vars['wgActionPanelDeleteMsg'] = wfMsg("delete");
	$vars['wgActionPanelSaveMsg'] = wfMsg("save");
	$vars['wgActionPanelCategorizeMsg'] = wfMsg("action_panel_categorize");
	$vars['wgActionPanelCategorizeHelpMsg'] = wfMsg("action_panel_categorize_help");
	$vars['wgActionPanelAddCategoriesSummary'] = wfMsg("action_panel_categories_summary");
	
	$vars['wgActionPanelEditSuccessMsg'] = wfMsg("action_panel_save_success");
	$vars['wgActionPanelRenameSuccessMsg'] = wfMsg("action_panel_rename_success");
	$vars['wgActionPanelCategorizeSuccessMsg'] = wfMsg("action_panel_categorize_success");
	$vars['wgCategoryName'] = $wgContLang->getNsText( NS_CATEGORY );
	return true;
}

$wgHooks["GetHTMLAfterBody"][] = "wfAddActionPanel";
function wfAddActionPanel($tpl, &$html){
	global $wgUser;
	if (!$wgUser->isAllowed('actionpanel')) {
		return true;
	}

	global $wgStyleVersion, $wgExtensionsPath;
	
	$html .= '<link rel="stylesheet" type="text/css" href="'.$wgExtensionsPath.'/wikia/ActionPanel/ActionPanel.css?'.$wgStyleVersion.'"/>\n';
	$html .= '<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/ActionPanel/ActionPanel.js?'.$wgStyleVersion.'"></script>\n';
	
	return true;
}

$wgAjaxExportList [] = 'wfGetCategorySuggest';
function wfGetCategorySuggest( $query, $limit = 5 ){
	$dbr = wfGetDB( DB_SLAVE );

	$res = $dbr->select( "categorylinks", 
		array( 'cl_to', 'count(*) as cnt' ),
		array( "UPPER(cl_to) LIKE " . $dbr->addQuotes(strtoupper($query) . "%") ),	
		__METHOD__,
		array("ORDER BY" => "cl_to", "GROUP BY" => "cl_to", "LIMIT" => $limit )
		);
	while ($row = $dbr->fetchObject( $res ) ) {
		$title = Title::makeTitle(NS_CATEGORY, $row->cl_to);
		$out["ResultSet"]["Result"][] = array("category" => $title->getText(), "count" => $row->cnt );
	}
	return json_encode( $out );
	
	return true;
}
