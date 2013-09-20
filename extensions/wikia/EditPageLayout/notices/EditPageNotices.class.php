<?php

class EditPageNotices implements IteratorAggregate {

	protected $notices = array();

	// don't show notifications of the following types
	protected $blacklist = array(
		// BugId:7966
		'usercssyoucanpreview',
		'userjsyoucanpreview',
	);

	private function isBlacklisted($id) {
		return in_array($id, $this->blacklist);
	}

	public function clear() {
		$this->notices = array();
		$this->log(__METHOD__, 'cleared');
	}

	public function isEmpty() {
		return empty($this->notices);
	}

	public function add( $notice, $id = false ) {
		if (!($notice instanceof EditPageNotice)) {
			$notice = new EditPageNotice($notice,$id);
		}

		if ($this->isBlacklisted($notice->getMessageId())) {
			$this->log(__METHOD__ . ' - blacklisted', $notice->getMessageId());
		}
		else {
			$this->notices[] = $notice;
			$this->log(__METHOD__ . ' - added', $notice->getHtml());
		}
	}

	public function remove( $messageId ) {
		foreach( $this->notices as $key => $notice ) {
			if( $notice->getMessageId() == $messageId ) {
				unset( $this->notices[ $key ] );
				$this->log(__METHOD__, $messageId);
			}
		}
	}

	public function get( $messageId ) {
		foreach( $this->notices as $key => $notice ) {
			if( $notice->getMessageId() == $messageId ) {
				return $notice;
			}
		}
	}

	public function isExists( $messageId ) {
		foreach( $this->notices as $key => $notice ) {
			if( $notice->getMessageId() == $messageId ) {
				return true;
			}
		}
		return false;
	}

	public function getHtml() {
		$html = '';
		foreach ($this->notices as $notice) {
			$html .= $notice->getHtml();
		}
		return $html;
	}

	public function getSummary() {
		$summary = array();
		foreach ($this->notices as $notice) {
			$noticeSummary = $notice->getSummary();
			if (!empty($noticeSummary))
				$summary[$notice->getHash()] = $noticeSummary;
		}
		return $summary;
	}

	public function getIterator() {
		return new ArrayIterator($this->notices);
	}

	static public function newFromArray( $notices ) {
		$obj = new self();
		foreach ($notices as $text)
			$obj->add(new EditPageNotice($text));
		return $obj;
	}

	private function log($method, $msg) {
		wfDebug("{$method}: {$msg}\n");
	}
}
