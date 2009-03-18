<?php
/*
CREATE TABLE `magic_footer_links` (
  `dbname` varchar(31) NOT NULL,
  `page` varchar(255) NOT NULL,
  `links` mediumblob NOT NULL,
  KEY `dbname` (`dbname`,`page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

@author: Inez Korczyński
*/

if(!defined('MEDIAWIKI')) {
	exit(1);
}

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
		global $wgUser, $wgRequest, $wgOut, $wgMemc;

		if(!$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();

		if($wgRequest->wasPosted()) {
			try {

				// Populate $this->results and $this->badRows with data from Google Spreadsheet
				$this->downloadData();

				// Collect database names for all wikis which had some magic footer links before loading new configuration.
				$dbnames = array();
				$dbr =& wfGetDB(DB_SLAVE);
				$res = $dbr->select(wfSharedTable('magic_footer_links'), 'DISTINCT dbname');
				while($row = $dbr->fetchObject($res)) {
					$dbnames[] = $row->dbname;
				}
				$dbr->freeResult($res);

				// Delete current data from database
				$dbw = wfGetDB(DB_MASTER);
				$dbw->delete(wfSharedTable('magic_footer_links'), '*');
				$deleted = $dbw->affectedRows();

				// Insert data from Google Spreadsheet into database and into cache
				$inserted = 0;
				foreach($this->results as $row => $result) {
					if(count($result) == 3 && $dbw->insert(wfSharedTable('magic_footer_links'), array('dbname' => $result['dbname'], 'page' => str_replace('_', ' ', $result['page']), 'links' => join(' | ', $result['links'])))) {
						$dbnames[] = $result['dbname'];
						$inserted++;
					} else {
						$this->badRows[] = $row;
					}
				}

				// Invalidate cache data: <dbname>:MonacoDataOld
				$dbnames = array_unique($dbnames);
				foreach($dbnames as $dbname) {
					$wgMemc->delete($dbname.':MonacoDataOld');
				}

				$this->badRows = array_unique($this->badRows);
				sort($this->badRows);

				$out = "{$deleted} old record(s) deleted <br /><br />{$inserted} new record(s) inserted".(count($this->badRows) >0 ? '<br /><br />row(s): '.implode(', ', $this->badRows).' not inserted due to missing or incorrect data' : '');
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
					$this->results[$row]['page'] = $val;
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
}