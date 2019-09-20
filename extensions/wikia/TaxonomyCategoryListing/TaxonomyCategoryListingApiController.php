<?php
class TaxonomyCategoryListingApiController extends WikiaApiController {

	const PARAM_MAX_RESULTS = "maxResults";
	const PARAM_MIN_REQ_PAGES = "minPages";

	private $categoryListing;

	public function __construct($categoryListing = null) {
		parent::__construct();
		$this->categoryListing = $categoryListing ?: new TaxonomyCategoryListing();
	}

	public function listCategories() {
		$categories = $this->categoryListing->getCategoryListing(
			$this->request->getInt(self::PARAM_MIN_REQ_PAGES),
			$this->request->getInt(self::PARAM_MAX_RESULTS)
		);

		$this->response->setFormat(WikiaResponse::FORMAT_JSON);
		$this->response->setValues($categories);
	}
}
