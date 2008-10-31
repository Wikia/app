<?php

/**
 * AntiSpamInput extension
 *
 * A simple mechanism protecting from mindless spam bots,
 * inserts an input into various forms and prevents saving
 * if that input is filled.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Łukasz 'TOR' Garczewski <tor@wikia.com>
 * @copyright Copyright (C) 2008 Lucas Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo "Not a valid entry point";
        exit(1);
}

global $wgHooks;
# vanilla EditPage
$wgHooks['EditPage::showEditForm:initial'][] = 'wfAntiSpamInputBoxInclusion' ;
$wgHooks['EditPage::attemptSave'][] = 'wfAntiSpamInputCheck' ;

# Special:RequestWiki
$wgHooks['RequestWiki::showRequestForm:presubmit'][] = 'wfAntiSpamInputBoxInclusion' ;
$wgHooks['RequestWiki::processErrors'][] = 'wfAntiSpamInputCheck' ;

# Special:CreatePage
$wgHooks['CreatePageMultiEditor::GenerateForm:presubmit'][] = 'wfAntiSpamInputBoxInclusion' ;
# wfAntiSpamInputCheck for CreatePage is handled by EditPage::attemptSave hook above

$wgExtensionFunctions[] = 'wfAntiSpamInputInit';
$wgExtensionCredits['other'][] = array(
    'name' => 'AntiSpamInput' ,
    'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
    'version' => 0.3 ,
    'description' => 'Simple spambot blocking mechanism.'
);
function wfAntiSpamInputInit () {
	global $wgMessageCache;

	$wgMessageCache->addMessages( array(
		'antispam_label' => 'This field is a spam trap. <strong>DO NOT</strong> fill it in!'
	));
}


function wfAntiSpamInputBoxInclusion ( $form = false ) {

	$input = "\n<div id='antispam_container' style='display: none'>\n".
                 "<label for='antispam'>". wfMsg('antispam_label'). "</label>\n".
                 "<input type='text' value='' id='antispam' name='antispam' />\n".
                 "</div>";

	# check if we're using EditPage, wgOut or something else
	# FIXME: if possible all cases should be handled identically
	if (is_object($form) && property_exists($form, 'editFormTextBottom')) {
		$form->editFormTextBottom .= $input;
	} elseif (method_exists($form, 'addHTML')) {
		$form->addHTML($input);
	} else {
		echo $input;
	}
	return true;
}


function wfAntiSpamInputCheck () {
	if (!empty($_POST['antispam'])) {
		$title = new Title();
		$article = new Article( $title );
		$edit = new EditPage( $article );
		$edit->spamPage();
		return false;	
	}
	else return true;
}
