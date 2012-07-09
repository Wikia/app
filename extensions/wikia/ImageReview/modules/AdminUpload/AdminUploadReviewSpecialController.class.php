<?php

class AdminUploadReviewSpecialController extends ImageReviewSpecialController {
	const DEFAUL_IMAGE_SIZE = 320;

	public function __construct() {
		WikiaSpecialPageController::__construct('AdminUploadReview', 'adminuploaddirt', false /* $listed */);
	}

	protected function getPageTitle() {
		return 'Admin Upload Review tool';
	}

	public function index() {
		parent::index();
	}

	public function stats() {
		parent::stats();
		$this->response->getView()->setTemplate('ImageReviewSpecialController', 'stats');
	}

	protected function getHelper() {
		return F::build('AdminUploadReviewHelper');
	}

	protected function getBaseUrl() {
		return Title::newFromText('AdminUploadReview', NS_SPECIAL)->getFullURL();
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
