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
		} else {
			$this->notices[] = WF::build('EditPageNotice',array($notice,$id));
		}
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
				$summary[] = $noticeSummary;
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

}