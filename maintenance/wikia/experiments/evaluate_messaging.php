<?php

require_once( dirname(__FILE__) . '/../../commandLine.inc' );

class MessagingTransition {

	const CODE_MESSAGES_CACHE = '/tmp/all-messages-code.txt';
	const WIKI_MESSAGES_CACHE = '/tmp/all-messages-wiki.txt';
	const REPORT_CACHE = '/tmp/all-messages-report.txt';

	protected $codeMessages;
	protected $wikiMessages;
	protected $report;

	public function getCodeMessages() {
		if ( is_null( $this->codeMessages ) ) {
			$this->codeMessages = $this->loadFromFile(self::CODE_MESSAGES_CACHE);
		}
	    if ( is_null( $this->codeMessages ) ) {
			$this->loadCodeMessages();
		}
		return $this->codeMessages;
	}

	public function getWikiMessages() {
		if ( is_null( $this->wikiMessages ) ) {
			$this->wikiMessages = $this->loadFromFile(self::WIKI_MESSAGES_CACHE);
		}
		if ( is_null( $this->wikiMessages ) ) {
			$this->loadWikiMessages();
		}
		return $this->wikiMessages;
	}

	public function getReport() {
		if ( is_null( $this->report ) ) {
			$this->report = $this->loadFromFile(self::REPORT_CACHE);
		}
		if ( is_null( $this->report ) ) {
			$this->loadReport();
		}
		return $this->codeMessages;
	}

	protected function loadFromFile( $file ) {
		if ( is_readable( $file ) ) {
			$data = null;
			require ($file);
			echo "Read file $file (var_export size = ".strlen(var_export($data,true)).")\n";
			return $data;
		}
		return null;
	}

	protected function saveToFile( $file, $data ) {
		$dataCode = var_export($data,true);
		$code = "<?php\n\$data = ".$dataCode.";\n";
		file_put_contents($file,$code);
		echo "Read file $file (var_export size = ".strlen($dataCode).")\n";
	}

	protected function getCodeMessagesFiles() {
		global $IP, $wgExtensionMessagesFiles;
		$coreFiles = glob("$IP/languages/messages/Messages*.php");
		$wikiaFiles = glob("$IP/languages/messages/wikia/Messages*.php");

		$extraFiles = array(

		);

		$allFiles = array_merge(
			$coreFiles,
			$wikiaFiles,
			$wgExtensionMessagesFiles,
			$extraFiles
		);

		return $allFiles;
	}

	protected function loadMessagesFiles( $_fileName ) {
		$messages = array();
		require( $_fileName );
		return $messages;
	}

	protected function loadCodeMessages() {
		global $IP;
		$allFiles = $this->getCodeMessagesFiles();

		echo "Loading messages from files (".count($allFiles).")...\n";
		$i = 0;
		$messages = array();
		$cleanIP = realpath($IP);
		foreach ($allFiles as $file) {
			$cleanFile = realpath($file);
			if ( startsWith($cleanFile,$cleanIP) ) {
				$cleanFile = substr($cleanFile,strlen($cleanIP)+1);
			}

			$code = preg_match("/Messages([_a-zA-Z]+)\.php\$/",$file,$matches) ? strtolower($matches[1]) : false;
			$batch = $this->loadMessagesFiles($file);
			if ( $code ) {
				$batch = array( $code => $batch );
			}
			foreach ($batch as $lang => $batch2) {
				if ( !is_array( $batch2 ) ) {
					echo "Error#1: $code $file $lang\n";
					var_dump($batch2);
					die();
				}
				foreach ($batch2 as $key => $message) {
					$batch[$lang][$key] = array(
						'message' => $message,
						'source' => $cleanFile,
					);
				}
				if ( empty( $messages[$lang] ) ) {
					$messages[$lang] = array();
				}
				$messages[$lang] = array_merge( $messages[$lang], $batch[$lang] );
			}
			if ( ++$i % 10 == 0 ) {
				echo ".";
				flush();
			}
		}
		echo "\n";
		$this->codeMessages = $messages;

		$this->saveToFile(self::CODE_MESSAGES_CACHE,$messages);
	}

	protected function loadWikiMessages() {
		$dbr = wfGetDB(DB_SLAVE,array());

		echo "Loading page list...\n";
		$res = $dbr->select('page','*',array(
			'page_namespace' => NS_MEDIAWIKI,
		),'evaluate_messaging.php');
		$rows = array();
		$byRev = array();
		foreach ($res as $row) {
			$rows[] = $row;
			$byRev[$row->page_latest] = false;
		}
		$res->free();

		echo "Loading revisions...\n";
		$res = $dbr->select('revision','*',array(
			'rev_id' => array_keys($byRev),
		),'evaluate_messaging.php');
		foreach ($res as $row) {
			$byRev[$row->rev_id] = $row;
		}
		$res->free();

		echo "Loading contents...\n";
		$i = 0;
		$messages = array();
		foreach ($rows as $row) {
			list( $key, $langcode ) = MessageCache::singleton()->figureMessage( $row->page_title );
			$revision = Revision::newFromRow($byRev[$row->page_latest]);
			$content = $revision->getRawText();
			$messages[$langcode][lcfirst($key)] = $content;
			if ( ++$i % 100 == 0 ) {
				echo ".";
				flush();
			}
		}
		echo "\n";

		$this->wikiMessages = $messages;

		$this->saveToFile(self::WIKI_MESSAGES_CACHE,$messages);
	}

	public function loadReport() {
		$report = array(
			'new' => array(),
			'same' => array(),
			'core_overrides' => array(),
			'wikia_overrides' => array(),
			'core_lang_overrides' => array(),
			'wikia_lang_overrides' => array(),
		);

		$code = $this->getCodeMessages();
		$wiki = $this->getWikiMessages();

		foreach ($wiki as $lang => $batch) {
			foreach ($batch as $key => $wikiMessage) {
				$codeMessage = null;
				$codeSource = null;
				if ( isset( $code[$lang][$key] ) ) {
					$codeMessage = $code[$lang][$key]['message'];
					$codeSource = $code[$lang][$key]['source'];
				}
				if ( isset( $code['en'][$key] ) ) {
					$codeSource = $code['en'][$key]['source'];
				}


				if ( $wikiMessage === $codeMessage ) {
					$type = 'same';
				} else {
					$isOverride = isset( $code['en'][$key] );
					$isFromCore = $isOverride && !preg_match('#/wikia/#',$codeSource);
					$corePrefix = $isFromCore ? 'core_' : 'wikia_';
					if ( $codeMessage === null ) {
						if ( !$isOverride ) {
							$type = 'new';
						} else {
							$type = $corePrefix . 'lang_overrides';
						}
					} else {
						$type = $corePrefix . 'overrides';
					}
				}

				$report[$type][$key] = array(
					'code' => $codeMessage,
					'wiki' => $wikiMessage,
					'lang' => $lang,
					'source' => $codeSource,
				);
			}
		}

		$this->report = $report;

		$this->saveToFile(self::REPORT_CACHE,$report);

	}


	protected function printSize( $label, $data ) {
		echo "$label: size = ".strlen(var_export($data,true))."\n";
	}

}

//var_dump(glob("$IP/languages/messages/Messages*.php"));
//var_dump(glob("$IP/languages/messages/wikia/Messages*.php"));
//die();
$t = new MessagingTransition();
$t->getReport();

