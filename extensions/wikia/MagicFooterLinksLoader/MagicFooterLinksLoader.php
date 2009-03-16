<?php
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
				$this->downloadData();
				$out = $this->deleteAndInsertData();
				$wgMemc->set('MagicFooterLinksHash', md5(serialize($this->results)));
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

	private function deleteAndInsertData() {
		$dbw = wfGetDB(DB_MASTER);
		$dbw->delete(wfSharedTable('magic_footer_links'), '*', 'MagicFooterLinksLoader->deleteAndInsertData');

		$deleted = $dbw->affectedRows();
		$inserted = 0;

		foreach($this->results as $row => $result) {
			if(count($result) == 3 && $dbw->insert(wfSharedTable('magic_footer_links'), array('dbname' => strtolower($result['dbname']), 'page' => str_replace('_', ' ', $result['page']), 'links' => join(' | ', $result['links'])), 'MagicFooterLinksLoader->deleteAndInsertData')) {
				$inserted++;
			} else {
				$this->badRows[] = $row;
			}
		}

		$this->badRows = array_unique($this->badRows);

		return "{$deleted} old record(s) deleted <br /><br />{$inserted} new record(s) inserted".(count($this->badRows) >0 ? '<br /><br />row(s): '.implode(', ', $this->badRows).' not inserted due to missing or incorrect data' : '');
	}
}

function MagicFooterLinks_getLinks() {
	wfProfileIn(__METHOD__);
	global $wgMemc;

	$links = false;

	wfProfileIn(__METHOD__.'-fromlocal');
	$hash = $wgMemc->get('MagicFooterLinksHash');
	if(!$hash) {
		return false;
	}
	if($links) {
		$links = MagicFooterLinks_loadFromLocal($hash);
	}
	wfProfileOut(__METHOD__.'-fromlocal');

	if(!$links) {
		wfProfileIn(__METHOD__.'-fromDB');
		$links = MagicFooterLinks_loadFromDB();
		MagicFooterLinks_saveToLocal($hash, $links);
		wfProfileOut(__METHOD__.'-fromDB');
	}
	wfProfileOut(__METHOD__);
	return $links;
}

function MagicFooterLinks_loadFromLocal($hash) {
	wfProfileIn(__METHOD__);
	global $wgLocalMessageCache;

	$dirname = $wgLocalMessageCache . '/' . substr( wfWikiID(), 0, 1 ) . '/' . wfWikiID();
	$filename = "$dirname/magic_footer_links";
	$file = fopen($filename, 'r');

	$localHash = fread($file, 32);
	if($hash === $localHash) {
		$serialized = '';
		while(!feof($file)) {
			$serialized .= fread($file, 100000);
		}
		fclose($file);
		$result = unserialize($serialized);
		wfProfileOut(__METHOD__);
		return $result;
	} else {
		fclose($file);
		wfProfileOut(__METHOD__);
		return false;
	}
}

function MagicFooterLinks_loadFromDB() {
	wfProfileIn(__METHOD__);
	global $wgMemc, $wgDBname, $wgTitle;
	$result = array();
	$tmpParser = null;
	$tmpParserOptions = null;
	$dbw = null;
	$dbr =& wfGetDB(DB_SLAVE);
	$res = $dbr->select(wfSharedTable('magic_footer_links'), 'page, links, parsed_links', array('dbname' => $wgDBname), __METHOD__);
	while($row = $dbr->fetchObject($res)) {
		if(empty($row->parsed_links)) {
			if(empty($tmpParser) && empty($tmpParserOptions) && empty($dbw)) {
				$tmpParser = new Parser();
				$tmpParser->setOutputType(OT_HTML);
				$tmpParserOptions = new ParserOptions();
				$dbw = wfGetDB(DB_MASTER);
			}
			$row->parsed_links = $tmpParser->parse($row->links, $wgTitle, $tmpParserOptions, false)->getText();
			$dbw->update(wfSharedTable('magic_footer_links'), array('parsed_links' => $row->parsed_links), array('dbname' => $wgDBname, 'page' => $row->page), __METHOD__);
		}
		$result[$row->page] = $row->parsed_links;
	}
	$dbr->freeResult($res);
	if(!empty($dbw)) {
		$dbw->commit();
	}
	wfProfileOut(__METHOD__);
	return $result;
}

function MagicFooterLinks_saveToLocal($hash, $result) {
	wfProfileIn(__METHOD__);
	global $wgLocalMessageCache;

	$dirname = $wgLocalMessageCache . '/' . substr( wfWikiID(), 0, 1 ) . '/' . wfWikiID();
	$filename = "$dirname/magic_footer_links";
	wfMkdirParents($dirname, 0777);

	wfSuppressWarnings();
	$file = fopen($filename, 'w');
	wfRestoreWarnings();

	if(!$file) {
		return;
	}

	fwrite($file, $hash . serialize($result));
	fclose($file);
	@chmod($filename, 0666);
	wfProfileOut(__METHOD__);
}