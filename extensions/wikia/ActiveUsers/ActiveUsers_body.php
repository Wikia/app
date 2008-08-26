<?

class Activeusers extends SpecialPage {
	function Activeusers() {
		SpecialPage::SpecialPage("Activeusers");
		wfLoadExtensionMessages('Activeusers');
	}

	function execute($par) {
		global $wgServer, $wgArticlePath;

		header(str_replace('$1','Special:Listusers',"Location: {$wgServer}{$wgArticlePath}"));
		die();
	}
}
