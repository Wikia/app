<?php

class PromoteImageReviewSpecialController extends ImageReviewSpecialController {
	const DEFAUL_IMAGE_SIZE = 320;

	public function __construct() {
		WikiaSpecialPageController::__construct('PromoteImageReview', 'promoteimagereview', false /* $listed */);
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
		return 'Admin Upload Review';
	}

	protected function getStatsPageTitle() {
		return 'Admin Upload Review tool statistics';
	}

	protected function parseImageData($data) {
		$images = array();

		foreach ($data as $name => $value) {
			if (preg_match('/img-(\d*)-(\d*)$/', $name, $matches)) {
				if (!empty($matches[1]) && !empty($matches[2])) {
					$key = $matches[1] . '-' . $matches[2];
					if (empty($images[$key])) {
						$images[$key] = array();
					}

					$images[$key]['wikiId'] = $matches[1];
					$images[$key]['pageId'] = $matches[2];
					$images[$key]['state'] = $value;
				}
			} elseif (preg_match('/img-(\d*)-(\d*)-([a-z]+)/', $name, $matches)) {
				if (!empty($matches[1]) && !empty($matches[2]) && !empty($matches[3])) {
					$key = $matches[1] . '-' . $matches[2];

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
