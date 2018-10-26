<?php

use Wikia\FeedsAndPosts\JustUpdatedAPIProxy;

class FeedsAndPostsController extends WikiaController {
	public function getJustUpdated() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues( ( new JustUpdatedAPIProxy() )->get() );
	}
}
