<?php
/**
 * Base class for skin templates based on QuickTemplate
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

abstract class WikiaBaseTemplate extends BaseTemplate {
	protected $app = null;
	protected $wg = null;
	protected $wf = null;

	function __construct() {
		$this->app = F::app();
		$this->wg = $this->app->wg;
		$this->wf = $this->app->wf;
	}

	/**
	 * QuickTemplate doesn't have a pure "get" method, only "set", this method will ensure
	 * access to the data without using directly the data member which could be re-declared as private
	 * in upcoming versions of MediaWiki
	 *
	 * @param string $name
	 */
	public function get( $name ) {
		return $this->data[$name];
	}
}
