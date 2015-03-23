<?php

namespace Email\Controller;

use Email\EmailController;

/**
 * Class LayoutController
 * @package Email\Controller
 */
class LayoutController extends EmailController {

	/**
	 * @template Layout_body
	 */
	public function body() {
		$this->response->setVal( 'content', $this->getVal( 'content' ) );
	}

	protected function getSubject() {
		// todo: this is hacky
	}

}