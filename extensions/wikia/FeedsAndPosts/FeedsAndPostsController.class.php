<?php

use Wikia\FeedsAndPosts\WikiRecentChangesAPIProxy;

class FeedsAndPostsController extends WikiaController {
	public function getWikiRecentChanges() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues( ( new WikiRecentChangesAPIProxy() )->get() );
	}
}
