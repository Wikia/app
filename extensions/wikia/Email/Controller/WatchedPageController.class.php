<?php

namespace Email\Controller;

use Email\EmailController;

class WatchedPageController extends EmailController {

	// TODO update this to use wfMessage and plugin in proper page and editor info
	protected function getSubject()	{
		return "See the latest changes on a page you're watching";
	}

	/**
	 * @template watchedPage
	 */
	public function body() {
		$this->response->setData( $this->request->getParams() );
	}
}