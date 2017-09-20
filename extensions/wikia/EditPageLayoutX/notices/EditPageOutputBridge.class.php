<?php

class EditPageOutputBridge {

	const ACTION_ADDHTML = 'addHTML';
	const ACTION_ADDWIKIMSG = 'addWikiMsg';
	const ACTION_WRAPWIKIMSG = 'wrapWikiMsg';

	static protected $methods = array(
		//'showErrorPage',
		//'addWikiText',
		self::ACTION_ADDWIKIMSG => '',
		self::ACTION_WRAPWIKIMSG => '$text',
		self::ACTION_ADDHTML => '$text',
	);

	protected $editPage = null;
	protected $notices = null;

	protected $outputPage = null;
	protected $outputPageMock = null;

	public function __construct( $editPage, $notices ) {
		$this->editPage = $editPage;
		$this->notices = $notices;

		$this->open();
	}

	public function open() {
		$this->notices->clear();

		$this->outputPage = F::app()->getGlobal('wgOut');
		$this->tracer = new ObjectTracer($this->outputPage,self::$methods);
		$this->outputPageMock = $this->tracer->begin();
		$this->editPage->customOutputPage = $this->outputPageMock;
	}

	public function close() {
		$this->editPage->customOutputPage = null;
		$this->outputPageMock = null;
		$callTrace = $this->tracer->getTracer()->get();
		$this->tracer->end();
		$this->tracer = null;

		$this->analyze($callTrace);
	}

	protected function analyze( $items ) {
		$this->notices->clear();
		$items2 = array();
		foreach ($items as $item) {
			$id = false;
			$html = $this->getTraceHtml($item);
			switch ($item[ObjectCallTrace::ACTION]) {
				case self::ACTION_ADDWIKIMSG:
					$id = $item[ObjectCallTrace::ARGUMENTS][0];
					break;
				case self::ACTION_WRAPWIKIMSG:
					$id = $item[ObjectCallTrace::ARGUMENTS][1];
					break;
			}
			$items2[] = array(
				'id' => $id,
				'html' => $html,
			);
		}

		$more = false;
		$html = '';
		foreach ($items2 as $k => $item) {
			if ($item['id']) {
				if ($html != '') {
					$this->analyzeHtml($html,$more);
					$html = '';
				}
				$this->notices->add($item['html'],$item['id']);
			} else {
				$html .= $item['html'];
			}
		}
		if ($html != '') {
			$this->analyzeHtml($html,$more);
		}
		//if ($more) {
		//	$this->notices->add(wfMsg('editpagelayout-more-notices'));
		//}
	}

	protected function analyzeHtml( $html, &$more = null ) {
		$pos = 0;
		$tags = array();
		preg_match_all("/<(\\/?)(div|table)[^>]*>/isU",$html,$tags,PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
		$depth = 0;

		$chunks = array();
		foreach ($tags as $tag) {
			$tagcontent = $tag[0][0];
			$tagstartpos = $tag[0][1];
			$tagendpos = $tagstartpos + strlen($tagcontent);
			$tagopening = empty($tag[1][0]);
			if ($tagopening) {
				if ($depth == 0) {
					$remnant = trim(substr($html,$pos,$tagstartpos-$pos));
					if (!empty($remnant)) {
						$chunks[] = array( $pos, $tagstartpos - $pos, $remnant, false );
					}
					$pos = $tagstartpos;
					$sectiontagstartpos = $tagstartpos;
					$sectiontagcontent = $tagcontent;
				}
				$depth++;
			} else {
				$depth--;
				if ($depth == 0) {
					$id = false;
					if (preg_match("/(?:id|class)=[\"']?([^\"'> ]+)[\"'>\t ]/isU",$sectiontagcontent,$matches)) {
						$id = $matches[1];
					}
					$content = trim(substr($html,$sectiontagstartpos,$tagendpos-$sectiontagstartpos));
					$chunks[] = array( $sectiontagstartpos, $tagendpos - $sectiontagstartpos, $content, $id );
					$pos = $tagendpos;
				}
				if ($depth < 0) {
					$depth = 0;
				}
			}
		}

		$remnant = trim(substr($html,$pos));
		if (!empty($remnant)) {
			$chunks[] = array( $pos, strlen($html) - $pos, $remnant, false );
		}


		$notices = array();
		foreach ($chunks as $chunk) {
			if ($chunk[3]) {
				$notice = new EditPageNotice($chunk[2],$chunk[3]);
				if ($notice->getSummary() != '') {
					$this->notices->add($notice);
					$notices[] = $notice;
				}
			}
		}

		if (count($notices) < count($chunks)) {
			$more = true;
		}

		return $notices;
	}

	protected function getTraceHtml( $item ) {
		if ($item[ObjectCallTrace::ACTION] == self::ACTION_ADDHTML)
			return (string)$item[ObjectCallTrace::ARGUMENTS][0];

		$result = '';
		foreach ($item[ObjectCallTrace::CHILDREN] as $child) {
			$result .= $this->getTraceHtml($child);
		}
		return $result;
	}


	/**
	 * @return OutputPage
	 */
	public function getMockObject() {
		return $this->outputPageMock;
	}

}
