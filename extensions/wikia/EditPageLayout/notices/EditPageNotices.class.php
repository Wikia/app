<?php

class EditPageNotices implements IteratorAggregate {

	protected $notices = array();

	public function clear() {
		$this->notices = array();
	}

	public function isEmpty() {
		return empty($this->notices);
	}

	public function add( $notice, $id = false ) {
		if ($notice instanceof EditPageNotice) {
			$this->notices[] = $notice;
			$this->log(__METHOD__, $notice->getHtml());
		} else {
			$this->notices[] = WF::build('EditPageNotice',array($notice,$id));
			$this->log(__METHOD__, $id);
		}
	}

	public function remove( $messageId ) {
		foreach( $this->notices as $key => $notice ) {
			if( $notice->getMessageId() == $messageId ) {
				unset( $this->notices[ $key ] );
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
			$obj->add(WF::build('EditPageNotice',array($text)));
		return $obj;
	}

	private function log($method, $msg) {
		F::app()->wf->debug("{$method}: {$msg}\n");
	}
}