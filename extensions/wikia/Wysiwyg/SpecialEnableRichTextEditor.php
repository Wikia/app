<?php

$dir = dirname(__FILE__).'/';
$wgExtensionMessagesFiles['Wysiwyg'] = $dir.'i18n/Wysiwyg.i18n.php';

/*
 * Special page to enable rich text editor
*/
$wgSpecialPages['EnableRichTextEditor'] = 'EnableRichTextEditor';
class EnableRichTextEditor extends SpecialPage {
	function __construct() {
		parent::__construct('EnableRichTextEditor');
		wfLoadExtensionMessages('Wysiwyg');
	}

	function execute( $par ) {
		global $wgOut, $wgUser;

		$this->setHeaders();

		if ($wgUser->isAnon()) {
			$this->displayRestrictionError();
			return;
		}

		$wgOut->setPageTitle(wfMsg("enablerichtexteditor"));

		// set user option
		$wgUser->setOption('enablerichtext', true);
		$wgUser->saveSettings();

		// commit
		$dbw = wfGetDB( DB_MASTER );
		$dbw->commit();

		// show message
		$wgOut->addWikiText( wfMsg('wysiwyg-enablerichtexteditormessage') );
	}
}
