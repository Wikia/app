<?php
class TaxonomyCategoryListingApiController extends WikiaApiController {
	public function listCategories() {
		$categories = (new TaxonomyCategoryListing())->getCategoryListing();

		$this->response->setFormat(WikiaResponse::FORMAT_JSON);
		$this->response->setValues($categories);
	}
}
