<?php

/**
 * 
 */

class ArticlesAsResources {

	// application
	private $app;
	
	const TYPE_JS = "js";
	const TYPE_CSS = "css";
	
	// Different places the resource should be fetched from
	const ARTICLE_LOCAL = "localArticle"; // data is contained in an article on the same wiki
	const ARTICLE_REMOTE = "remoteArticle"; // data is contained in an article on another wikia wiki

	function __construct() {
		$this->app = WF::build('App');
	}

	/**
	 * Debug logging
	 *
	 * @param string $method - name of the method
	 * @param string $msg - log message to be added
	 */
	private function log($method, $msg) {
		$this->app->wf->debug($method  . ": {$msg}\n");
	}

	/*
	 * Returns a package as a JS tag
	 *
	 * @param array $packages - list packages names
	 *
	 * @return string A string containing the package as an inline-able tag to use in templates
	public function printPackages( Array $packages ) {
		$this->app->wf->ProfileIn(__METHOD__);

		// TODO: IMPLEMENT

		$this->app->wf->ProfileOut(__METHOD__);
		return $ret;
	}
	*/

}
