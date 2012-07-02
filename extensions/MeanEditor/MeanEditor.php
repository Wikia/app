<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the skin file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

$meanEditorDir = dirname( __FILE__ );

$wgExtensionMessagesFiles['MeanEditor'] = $meanEditorDir . '/MeanEditor.i18n.php';
$wgExtensionCredits['other'][] = array(
	'name' => 'MeanEditor',
	'author' => 'Jacopo Corbetta and Alessandro Pignotti for Antonio Gulli',
	'descriptionmsg' => 'meaneditor_desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MeanEditor',
	'version' => '0.5.5'
);

$wgAutoloadClasses['MeanEditorEditPage'] = $meanEditorDir . '/MeanEditorEditPage.body.php';

$wgHooks['CustomEditor'][] = 'meaneditor_customeditor';
$wgHooks['EditPageBeforeEditChecks'][] = 'meaneditor_checkboxes';
$wgHooks['EditPageBeforeEditToolbar'][] = 'meaneditor_disabletoolbar';
$wgHooks['UserToggles'][] = 'toggle_visualeditor_preference';

$wgAjaxExportList[] = "recent_images";

function recent_images($rsargs) 
{
	global $wgUploadPath, $wgDBprefix;

	$u = User::newFromSession();
	$dbw =& wfGetDB( DB_MASTER );
	$res=$dbw->query('select img_name from '.$wgDBprefix.'image where img_user='.$u->getId().';');
	$return_text='';
	$return_empty = true;
	for($i=0;$i<$res->numRows();$i++)
	{
		$ret=$res->fetchRow();
		$return_text=$return_text.'<tr><td><img src="'.$wgUploadPath.'/'.$ret['img_name'].'" height="100px" width="100px" onclick="n=document.getElementById(\'image_name\'); n.value=\''.$ret['img_name'].'\';" /></td></tr><tr><td>'.$ret['img_name'].'</td></tr>';
		$return_empty = false;
	}
	if ($return_empty) {
		return '<tr><td colspan="2"><strong>' . wfMsgWikiHtml('no_recent_images') . '</strong>' . ($u->isLoggedIn() ? '' : wfMsgWikiHtml('try_login')) . '</td></tr>';
	} else return $return_text;
}

function toggle_visualeditor_preference(&$toggles)
{
	$toggles[] = 'prefer_traditional_editor';
	return false;
}

function meaneditor_customeditor($article, $user)
{
	$editor = new MeanEditorEditPage( $article );
	$editor->edit();
	
	return false;
}

# Regular Editpage hooks
function meaneditor_checkboxes(&$editpage, &$checkboxes, &$tabindex)
{
	$checkboxes['want_traditional_editor'] = '';
	$attribs = array(
		'tabindex'  => ++$tabindex,
		#TODO: 'accesskey' => wfMsg( 'accesskey-minoredit' ),
		'id'        => 'wpWantTraditionalEditor',
	);
	$checkboxes['want_traditional_editor'] =
		Xml::check( 'wpWantTraditionalEditor', $editpage->userWantsTraditionalEditor, $attribs ) .
		"&nbsp;<label for='wpWantTraditionalEditor'>" . wfMsg('checkbox_force_traditional') . "</label>";
	return true;
}

function meaneditor_disabletoolbar(&$toolbar)
{
	$toolbar = '';
	return false;
}
