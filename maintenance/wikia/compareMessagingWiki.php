<?php

require_once( __DIR__ . '/../Maintenance.php' );

class CompareMessagingWiki extends Maintenance {

	const MESSAGING_WIKI_DB = 'messaging';

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Compares i18n messages in the code and customized on messaging.wikia.com";

		$this->addOption( 'messages', 'Pipe separated list of messages to check', true, true );
	}

	/**
	 * @return array
	 */
	private function getMessagesFiles() {
		global $wgExtensionMessagesFiles;

		return array_values(array_unique(
			array_merge(
				GlobalMessagesService::getInstance()->getCoreMessageFiles(),
				GlobalMessagesService::getInstance()->getExtensionMessageFiles(),
				$wgExtensionMessagesFiles
			)
		));
	}

	public function getMessageFromCode($msg) {
		$files = $this->getMessagesFiles();
		$ret = [];

		foreach($files as $file) {
			include $file;

			foreach($messages as $lang => $langMessages) {
				if (!empty($langMessages[$msg])) {
					$ret[ $lang ] = $langMessages[$msg];
				}
			}

			# leave here, as we have all the results
			if (!empty($ret)) {
				$this->output( sprintf( "Found %s in %s\n", $msg, $file ) );
				break;
			}
		}

		return $ret;
	}

	public function getMessageFromMessagingWiki($msg) {
		$db = $this->getDB( DB_SLAVE, [], self::MESSAGING_WIKI_DB );

		$res = $db->select( array( "page", "revision", "text" ),
			array( '*' ),
			array(
				'page_namespace' => NS_MEDIAWIKI,
				'page_title ' . $db->buildLike( [ ucfirst( $msg ), '/', $db->anyString() ] ),
				'page_latest = rev_id',
				'old_id = rev_text_id'
			),
			__METHOD__ );

		$ret = [];

		foreach ($res as $row) {
			$lang = explode('/', $row->page_title)[1];

			$message = Revision::getRevisionText($row);
			#var_dump($row, $message);
			#var_dump($row->page_title);

			$ret[ $lang ] = $message;
		}

		ksort( $ret );
		return $ret;
	}

	public function execute() {
		$messages = explode( '|', $this->getOption( 'messages' ) );
		# var_dump( $messages );

		foreach($messages as $msg) {
			$fromWiki = $this->getMessageFromMessagingWiki( $msg );
			$fromCode = $this->getMessageFromCode( $msg );

			# var_dump( $msg, $fromWiki, $fromCode );

			$diff = [];
			foreach ($fromCode as $lang => $fromCodeMessage ) {
				if (isset($fromWiki[$lang]) && $fromCodeMessage != $fromWiki[$lang]) {
					$diff[$lang] = $fromWiki[$lang];
				}
			}

			print_r($diff);
		}
	}

}

$maintClass = CompareMessagingWiki::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
