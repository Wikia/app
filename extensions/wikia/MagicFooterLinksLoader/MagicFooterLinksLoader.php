<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['MagicFooterLinksLoader'] = $dir . 'MagicFooterLinksLoader.i18n.php';
$wgSpecialPages['MagicFooterLinksLoader'] = 'MagicFooterLinksLoader';

class MagicFooterLinksLoader extends SpecialPage {

	function __construct() {
		global $wgMessageCache;

		parent::__construct('MagicFooterLinksLoader', 'wikifactory');

		$messages = array(
			'magicfooterlinksloader' => 'MagicFooterLinksLoader',
		);

		$wgMessageCache->addMessages($messages);
	}

	function execute($par) {
		global $wgUser, $wgRequest, $wgOut;

		if(!$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();

		if(!$wgRequest->wasPosted()) {
			$out = <<<EOD
<form method="POST">
Press the button to delete current magic footer links and load new from Google Spreadsheet.
<br />
<br />
<input type="submit" value="Go"/>
</form>
EOD;
		} else {

		}

		$wgOut->addHTML($out);
	}
}
