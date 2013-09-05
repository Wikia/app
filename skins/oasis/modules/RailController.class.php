<?php

/* This module encapsulates the right rail.  BodyModule handles the business logic for turning modules on or off */

class RailController extends WikiaController {

	const LAZY_LOADING_BEAKPOINT = 1440; // TOP_RIGHT_BOXAD

	public function executeIndex($params) {
		wfProfileIn(__METHOD__);

		$railModules = isset($params['railModuleList']) ? $params['railModuleList'] : [];

		$this->railModuleList = $this->filterModules($railModules);
		$this->isGridLayoutEnabled = BodyController::isGridLayoutEnabled();
		$this->isAside = $this->wg->RailInAside;
		$this->loadLazyRail = $railModules > $this->railModuleList;

		wfProfileOut(__METHOD__);
	}

	public function executeLazy() {
		wfProfileIn(__METHOD__);

		$railModules = $this->filterModules((new BodyController)->getRailModuleList(), true);
		$this->railLazyContent = '';
		krsort($railModules);
		foreach ($railModules as $railModule) {
			$this->railLazyContent .= $this->app->renderView($railModule[0], $railModule[1], $railModule[2]);
		}

		// TODO add <div id="WikiaAdInContentPlaceHolder"></div>

		$this->css = array_keys($this->app->wg->Out->styles);
		$this->js = $this->app->wg->Out->getBottomScripts();

		wfProfileOut(__METHOD__);
	}

	private function filterModules($moduleList, $lazy = false) {
		$lazyChecker = ($lazy) ? [$this, 'modulesLazyCheck'] : [$this, 'modulesNotLazyCheck'];
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
