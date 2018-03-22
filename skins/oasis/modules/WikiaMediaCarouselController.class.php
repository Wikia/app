<?php
class WikiaMediaCarouselController extends WikiaService {
	const DEFAULT_SCROLL_LIMIT = 3;

	/**
	 * @requestParam array data
	 * @requestParam int scrollLimit (optional)
	 */
	public function renderSlider() {
		$data = $this->request->getVal('data', array());
		$dataCount = count($data);

		$scrollLimit = $this->request->getVal('scrollLimit', null);
		if( !is_null($scrollLimit) ) {
			$this->setScrollLimit($scrollLimit);
		} else {
			$this->setScrollLimit(self::DEFAULT_SCROLL_LIMIT);
		}

		$this->total = $dataCount;
		$this->thumbUrls = $data;
		$this->enableEmptyGallery = ($dataCount > 0) ? false : true;
		$this->enableScroll = ($dataCount <= $this->scrollLimit) ? false : true;
	}

	private function setScrollLimit( $scrollLimit ) {
		$scrollLimit = intval($scrollLimit);
		$this->scrollLimit = ($scrollLimit <= 0) ? 0 : $scrollLimit;
	}

}
