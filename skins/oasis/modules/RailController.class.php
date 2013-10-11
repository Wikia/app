<?php

/* This module encapsulates the right rail.  BodyModule handles the business logic for turning modules on or off */

class RailController extends WikiaController {

	const LAZY_LOADING_BEAKPOINT = 1440; // TOP_RIGHT_BOXAD
	const FILTER_LAZY_MODULES = true;
	const FILTER_NON_LAZY_MODULES = false;

	public function executeIndex($params) {
		wfProfileIn(__METHOD__);

		$railModules = isset($params['railModuleList']) ? $params['railModuleList'] : [];

		$this->railModuleList = $this->filterModules($railModules, self::FILTER_NON_LAZY_MODULES);
		$this->isGridLayoutEnabled = BodyController::isGridLayoutEnabled();
		$this->isAside = $this->wg->RailInAside;
		$this->loadLazyRail = $railModules > $this->railModuleList;

		wfProfileOut(__METHOD__);
	}

	/**
	 * Entry point for lazy loading right rail for anon users
	 */
	public function executeLazyForAnons() {
		wfProfileIn(__METHOD__);

		$this->getLazyRail();

		$this->response->setCacheValidity(
			86400 /* 24h */,
			86400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Entry point for lazy loading right rail for logged in users
	 */
	public function executeLazy() {
		wfProfileIn(__METHOD__);

		$this->getLazyRail();

		$this->response->setCacheValidity(null, null, []);

		wfProfileOut(__METHOD__);
	}

	/**
	 *
	 */
	protected function getLazyRail() {
		wfProfileIn(__METHOD__);
		global $wgUseSiteJs, $wgAllowUserJs;

		$railModules = $this->filterModules((new BodyController)->getRailModuleList(), self::FILTER_LAZY_MODULES);
		$this->railLazyContent = '';
		krsort($railModules);
		foreach ($railModules as $railModule) {
			$this->railLazyContent .= $this->app->renderView(
				$railModule[0], /* Controller */
				$railModule[1], /* Method */
				$railModule[2] /* array of params */
			);
		}

		$this->railLazyContent .= Html::element('div', ['id' => 'WikiaAdInContentPlaceHolder']);

		$this->css = array_keys($this->app->wg->Out->styles);

		// Do not load user and site jses as they are already loaded and can break page
		$oldWgUseSiteJs = $wgUseSiteJs;
		$oldWgAllowUserJs = $wgAllowUserJs;
		$wgUseSiteJs = false;
		$wgAllowUserJs = false;

		$this->js = $this->app->wg->Out->getBottomScripts();

		$wgUseSiteJs = $oldWgUseSiteJs;
		$wgAllowUserJs = $oldWgAllowUserJs;


		wfProfileOut(__METHOD__);
	}

	/**
	 * Method that filters array of right rail modules into array of only lazy module or non lazy modules
	 *
	 * @param $moduleList
	 * @param $lazy
	 * @return array
	 */
	private function filterModules($moduleList, $lazy) {
		$lazyChecker = ($lazy == self::FILTER_LAZY_MODULES) ? [$this, 'modulesLazyCheck'] : [$this, 'modulesNotLazyCheck'];
		$out = [];
		foreach ($moduleList as $key => $val) {
			if ($lazyChecker($key)) {
				$out[$key] = $val;
			}
		}

		return $out;
	}
	private function modulesNotLazyCheck($moduleKey) {
		return $moduleKey >= self::LAZY_LOADING_BEAKPOINT;
	}
	private function modulesLazyCheck($moduleKey) {
		return $moduleKey < self::LAZY_LOADING_BEAKPOINT;
	}
}
