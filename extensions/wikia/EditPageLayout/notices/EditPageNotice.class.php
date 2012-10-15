<?php

class EditPageNotice {

	const SNIPPET_MAXIMUM_LENGTH = 200;

	static protected $messagesMap = array(
		'rev-deleted-text-permission' => 'rev-deleted-text',
		'rev-deleted-text-view' => 'rev-deleted-text',
		'protectedpagewarning' => 'protectedpagewarning',
		'cascadeprotectedwarning' => 'protectedpagewarning',
	);


	protected $messageId = false;
	protected $html = false;
	protected $summary = false;

	public function __construct( $html = false, $messageId = false ) {
		$this->html = $html;
		$this->messageId = $messageId;
	}

	public function setSummary( $summary ) {
		$this->summary = $summary;
	}

	public function getMessageId() {
		return (string)$this->messageId;
	}

	public function getHash() {
		return ( is_string($this->messageId) ? md5($this->messageId) : md5($this->getSummary()) );
	}

	public function getHtml() {
		return (string)$this->html;
	}

	public function getSummary() {
		if ($this->summary === false) {
			if ($this->messageId) {
				$id = $this->messageId;

				if (is_array($id)) {
					$id = array_shift($id);
				}

				if (substr($id,0,3) == 'mw-')
					$id = substr($id,3);
				if (isset(self::$messagesMap[$id]))
					$id = self::$messagesMap[$id];
				$messageId = $id . '-notice';
				$message = wfMsg($messageId);
				if (!wfEmptyMsg($messageId, $message)) {
					$this->summary = wfMsgExt($messageId,array('parseinline'));
				}
			}
			if ($this->summary === false) {
				$this->summary = $this->getHtmlSnippet();
			}
		}
		return (string)$this->summary;
	}

	public function getHtmlSnippet() {
		$snippet = strip_tags((string)$this->html);
		if (strlen($snippet) > self::SNIPPET_MAXIMUM_LENGTH) {
			$snippet = substr($snippet,0,self::SNIPPET_MAXIMUM_LENGTH-3) . "&hellip;";
		}
		return $snippet;
	}

}
