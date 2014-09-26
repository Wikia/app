<?php

class PromoteImageReviewSpecialController extends ImageReviewSpecialController {
	public function __construct() {
		WikiaSpecialPageController::__construct('PromoteImageReview', 'promoteimagereview', true /* $listed */);
	}

	protected function getPageTitle() {
		return 'Special:Promote Review tool';
	}

	public function index() {
		parent::index();
	}

	public function stats() {
		parent::stats();
		$this->response->getView()->setTemplate('ImageReviewSpecialController', 'stats');
	}

	protected function getHelper() {
		return new PromoteImageReviewHelper();
	}

	protected function getBaseUrl() {
		return Title::newFromText('PromoteImageReview', NS_SPECIAL)->getFullURL();
	}

	protected function getToolName() {
		return 'Special Promote Review';
	}

	protected function getStatsPageTitle() {
		return 'Special Promote Review tool statistics';
	}

	protected function parseImageData($data) {
		$images = array();

		foreach ($data as $name => $value) {


			if (preg_match('/img-(\d*)-([a-zA-Z0-9_\.]+)$/', $name, $matches)) {
				if (!empty($matches[1]) && !empty($matches[2])) {
					$key = $matches[2];
					if (empty($images[$key])) {
						$images[$key] = array();
					}

					$images[$key]['wikiId'] = $matches[1];
					$images[$key]['state'] = $value;
				}
			} elseif (preg_match('/img-(\d*)-([a-zA-Z0-9_\.]+)-([a-z]+)/', $name, $matches)) {
				if (!empty($matches[1]) && !empty($matches[2]) && !empty($matches[3])) {
					$key = $matches[2];

					if (empty($images[$key])) {
						$images[$key] = array();
					}
					$valname = $matches[3];

					switch ($valname) {
						case 'lang':
							$images[$key]['lang'] = $value;
							break;
						case 'file':
							$images[$key]['name'] = $value;
							break;
					}
				}
			}
		}

		return $images;
	}
}
