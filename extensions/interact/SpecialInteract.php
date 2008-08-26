<?php
if (!defined('MEDIAWIKI')) die();

/** Register the extension */
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Interact',
	'description' => 'Add Special:Interact that let you know who you talked with.',
	'author'	=> 'Ashar Voultoiz',
);

/** This is a querypage */
global $IP;
require_once($IP.'/includes/QueryPage.php');


/** The class itself, it inherits from QueryPage, less stuff to handle. */
class InteractPage extends QueryPage {
	function getName() {
		return 'InteractPage';
	}

	function isSyndicated() { return false; }

	function sortDescending() { return false; }

	function getSQL() {
		$db =& wfGetDB( DB_SLAVE );
		$page = $db->tableName( 'page' );
		$revision = $db->tableName( 'revision' );

$username = 'Hashar';
return "SELECT
'Interact' as type,
".NS_USER." as namespace,
rev_user_text as title,
page_title as value

FROM $page, $revision
WHERE page_namespace = ".NS_USER_TALK."
  AND page_title = '$username'
  AND rev_page = page_id
";
	}


	function formatResult( $skin, $result) {
		$title = Title::makeTitle( $result->namespace, $result->title );
		$link = $skin->makeKnownLinkObj( $title );
		return "$link";
	}
}

/** Entry point */
function wfSpecialInteract() {
	list($limit, $offset) = wfCheckLimits();
	$interactpage = new InteractPage();
	$interactpage->doQuery( $offset, $limit );
}

/** Register the special page as a querypage */
global $wgQueryPages;
$wgQueryPages[] = array('InteractPage', 'Interact');

require_once($IP.'/includes/SpecialPage.php');
SpecialPage::addPage( new SpecialPage('Interact') );

