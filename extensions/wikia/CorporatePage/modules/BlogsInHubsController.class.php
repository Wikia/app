<?php
/**
 * Provides Blogs in hubs functionality
 *
 * Rendered in AutoHubsPagesArticle class
 *
 * @author macbre
 */

class BlogsInHubsController extends WikiaController {

	/**
	 * Renders single content team selected blog post
	 */
	public function executeHotNews() {
		// get blog post chosen by content team
		$response = $this->app->sendRequest('BlogsInHubsService', 'getHotNews', array(
			'hubName' => $this->request->getVal('hubName'),
		));

		$blogPost = $response->getData();

		// no data - don't show anything
		if (empty($blogPost)) {
			return false;
		}

		$this->response->setVal('blogPost', $blogPost);
	}
}
