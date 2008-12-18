<?
$EditEnhancementsButtons = array();
$EditEnhancementsCheckboxes = array();

if ($_GET['action'] == 'edit' || $_GET['action'] == 'submit') {
	if ($_GET['action'] == 'edit') {
		$wgHooks['GetHTMLAfterBody'][] = 'EditEnhancementsJS';
	} else if ($_GET['action'] == 'submit') {
		$wgHooks['GetHTMLAfterBody'][] = 'EditEnhancementsPreviewJS';
	}
	$wgHooks['EditForm::MultiEdit:Form'][] = 'EditEnhancementsToolbar';
	$wgHooks['EditPageBeforeEditButtons'][] = 'EditEnhancementsShowButtons';
	$wgHooks['EditPage::showEditForm:checkboxes'][] = 'EditEnhancementsShowCheckboxes';
	$wgHooks['EditPageSummaryBox'][] = 'something';
}

function something($summary) {
	global $EditEnhancementsSummaryBox;
	$EditEnhancementsSummaryBox = $summary;
	$summary = '<div>';
	return true;
}
function EditEnhancementsJS() {
	
	$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
	echo $tmpl->execute('EditEnhancementsJS'); 

	return true;
}
function EditEnhancementsPreviewJS() {
	
	$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
	echo $tmpl->execute('EditEnhancementsPreviewJS'); 

	return true;
}
function EditEnhancementsToolbar($a, $b, $c, $d) {
	global $wgOut;
	
	$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
	$wgOut->addHTML($tmpl->execute('EditEnhancementsToolbar'));
	
	return true;
}
function EditEnhancementsShowButtons($EditPage, &$buttons) {
	global $EditEnhancementsButtons;
	$EditEnhancementsButtons = $buttons;
	
	// Change it to hide
	$buttons['save'] = $buttons['preview'] = '';
	return true;
}
function EditEnhancementsShowCheckboxes($EditPage, &$checkboxes) {
	global $EditEnhancementsCheckboxes;
	$EditEnhancementsCheckboxes = $checkboxes;
	
	$checkboxes['minor'] = $checkboxes['watch'] = '';
	return true;
}
