<?php
/**
 * Nirvana Framework - WikiaObject class
 *
 * This is a minimalist class which defines $app $wf and $wg
 * Use this for anything that is NOT a controller but still needs framework vars
 * If you need DB access consider using WikiaModel which has some DB helpers
 *
 * @ingroup nirvana
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 */

abstract class WikiaObject {

	/**
	 * application object
	 * @var $app WikiaApp
	 */
	protected $app = null;

	/**
	 * global registry object
	 * @var $wg WikiaGlobalRegistry
	 */
	protected $wg = null;

	/**
	 * Constructor
	 */

	public function __construct() {
		$this->app = F::app();

		// setting helpers
		$this->wg = $this->app->wg;
	}

	/**
	 * get application
	 * @return WikiaApp
	 */
	public function getApp() {
		return $this->app;
	}

	/**
	 * set application
	 * @param WikiaApp $app
	 */
	public function setApp( WikiaApp $app ) {
		$this->app = $app;

		// setting helpers
		$this->wg = $app->wg;
	}
}
