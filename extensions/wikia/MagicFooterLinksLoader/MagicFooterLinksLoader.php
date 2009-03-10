<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['MagicFooterLinksLoader'] = $dir . 'MagicFooterLinksLoader.i18n.php';
$wgSpecialPages['MagicFooterLinksLoader'] = 'MagicFooterLinksLoader';

class MagicFooterLinksLoader extends SpecialPage {

	private $results = array();

	private $badRows = array();

	public function __construct() {
		global $wgMessageCache;

		parent::__construct('MagicFooterLinksLoader', 'wikifactory');

		$messages = array(
			'magicfooterlinksloader' => 'MagicFooterLinksLoader',
		);

		$wgMessageCache->addMessages($messages);
	}

	public function execute($par) {
		global $wgUser, $wgRequest, $wgOut;

		if(!$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();

		if($wgRequest->wasPosted()) {
			try {
				$this->downloadData();
				$out = $this->deleteAndInsertData();
			} catch (Exception $e) {
				$out = 'Error: '.$e->getMessage();
			}
		} else {
			$out = <<<EOD
<form method="POST">
Press the button to delete current magic footer links and load new from Google Spreadsheet.
<br />
<br />
<input type="submit" value="Go"/>
</form>
EOD;
		}

		$wgOut->addHTML($out);
	}

	private function downloadData() {
		global $wgWikiaWebUser, $wgWikiaWebPassword;

		// Login to Google Spreadsheet API
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/accounts/ClientLogin');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('accountType' => 'GOOGLE', 'Email' => $wgWikiaWebUser, 'Passwd' => $wgWikiaWebPassword, 'service' => 'wise', 'source' => 'MW'));
 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$res = curl_exec($ch);

		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			throw new Exception('Can\'t login to Google Spreadsheet API');
		}

		// Extract authorization token from login request response
		$authKey = substr($res, strpos($res, 'Auth=') + 5);

		if(!is_string($authKey)) {
			throw new Exception('Problem with authorization token');
		}

		// Download Google Spreadsheet document
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://spreadsheets.google.com/feeds/cells/pP2oaI2sziL-rCgc8a6ChPw/1/private/values');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: GoogleLogin auth='.$authKey));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$res = curl_exec($ch);

		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			throw new Exception('Can\'t download  Google Spreadsheet document');
		}

		// Process Google Spreadsheet document as a XML
		$doc = new DOMDocument();
		$doc->loadXML($res);

		$results = array();
		$badRows = array();

		$nodes = $doc->getElementsByTagName('cell');
		foreach($nodes as $node) {
			$row = $node->getAttribute('row');
			$col = $node->getAttribute('col');
			$val = $node->textContent;

			if($row == 1) continue; // Ommit first row
			if(trim($val) == '') continue; // Ommit empty cells

			if($col == 1) {
				$this->results[$row] = array('dbname' => $val);
			} else if($col == 2) {
				if(!empty($this->results[$row])) {
					$this->results[$row]['pagename'] = $val;
				} else {
					$this->badRows[] = $row;
				}
			} else {
				if(!empty($this->results[$row]) && count($this->results[$row]) >= 2) {
					$this->results[$row]['links'][] = $val;
				} else {
					$this->badRows[] = $row;
				}
			}
		}
	}

	private function deleteAndInsertData() {
		return '';
	}
}
