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

		$this->response->setCacheValidity(WikiaResponse::CACHE_STANDARD);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Entry point for lazy loading right rail for logged in users
	 */
	public function lazy() {
		wfProfileIn(__METHOD__);

		$railModules = $this->getLazyRail();
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		// SUS-770: Only cache valid output
		if ( $railModules !== false ) {
			$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
			$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
			$this->wg->Out->tagWithSurrogateKeys(
				$this->getSurrogateKeys( $railModules )
			);
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Get lazy right rail modules
	 * @return bool|array Array of lazy-loaded rail modules, or false if the request was invalid
	 */
	protected function getLazyRail() {
		wfProfileIn(__METHOD__);
		global $wgUseSiteJs, $wgAllowUserJs, $wgTitle, $wgAllInOne;
		//$title = Title::newFromText($this->request->getVal('articleTitle', null), $this->request->getInt('namespace', null));
		$title = call_user_func_array( 'Title::newFromText', explode( ':', $this->wg->Request->getHeader( 'WikiaTitle' ) ) );

		// SUS-770: Return valid JSON if the request was invalid to avoid JS errors
		if ( !( $title instanceof Title ) ) {
			$this->response->setData( [
				'railLazyContent' => '',
				'css' => [],
				'js' => []
			] );
			return false;
		}

		// override original wgTitle from title given in parameters
		// we cannot use wgTitle that is created on by API because it's broken on wikis without '/wiki' in URL
		// https://wikia-inc.atlassian.net/browse/BAC-906
		$oldWgTitle = $wgTitle;
		$wgTitle = $title;
		$assetManager = AssetsManager::getInstance();
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

		$this->css = $sassFiles = [];
		foreach (array_keys($this->app->wg->Out->styles) as $style) {
			if ($wgAllInOne && $assetManager->isSassUrl($style)) {
				$sassFiles[] = $style;
			} else {
				$this->css[] = $style;
			}
		}

		if ( !empty( $sassFiles ) ) {
			$sassFilePath = (array)$assetManager->getSassFilePath( $sassFiles );

			if ( !empty( $sassFilePath ) ) {
				$this->css[] = $assetManager->getSassesUrl( $sassFilePath );
			}
		}

		// Do not load user and site jses as they are already loaded and can break page
		$oldWgUseSiteJs = $wgUseSiteJs;
		$oldWgAllowUserJs = $wgAllowUserJs;
		$wgUseSiteJs = false;
		$wgAllowUserJs = false;

		$this->js = $this->app->wg->Out->getBottomScripts();

		$wgUseSiteJs = $oldWgUseSiteJs;
		$wgAllowUserJs = $oldWgAllowUserJs;

		wfProfileOut(__METHOD__);
		return $railModules;
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

	/**
	 * Return surrogate keys for this rail configuration
	 * @param array $moduleList List of lazy-loaded rail modules as returned by RailController::getLazyRail
	 * @return array Array of surrogate keys
	 */
	private function getSurrogateKeys( array $moduleList ) {
		$keys = [];
		foreach ( $moduleList as $module ) {
			$keys[] = static::getSurrogateKeyForModule( $module[0] /* controller */, $module[1] /* name */ );
		}

		$keys[] = static::getSurrogateKeyForTitle( $this->wg->Title );
		return $keys;
	}

	/**
	 * Given a rail module's controller and render method name, return the surrogate key that can be used to purge it.
	 * @param string $moduleControllerName Module controller name (without 'Controller')
	 * @param string $moduleMethodName Method name used to render module
	 * @return string Surrogate key
	 */
	public static function getSurrogateKeyForModule( $moduleControllerName, $moduleMethodName ) {
		return Wikia::surrogateKey( $moduleControllerName, $moduleMethodName );
	}

	/**
	 * Given a page title, return the surrogate key that can be used to purge the lazy rail on this page
	 * @param Title $title Title object
	 * @return string Surrogate key
	 */
	public static function getSurrogateKeyForTitle( Title $title ) {
		return Wikia::surrogateKey( RailController::class, $title->getPrefixedText() );
	}
}
