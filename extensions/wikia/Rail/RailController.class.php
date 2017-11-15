<?php

/* This module encapsulates the right rail.  BodyModule handles the business logic for turning modules on or off */

use Wikia\Util\GlobalStateWrapper;

class RailController extends WikiaController {

	const LAZY_LOADING_BEAKPOINT = 1440; // TOP_RIGHT_BOXAD
	const FILTER_LAZY_MODULES = true;
	const FILTER_NON_LAZY_MODULES = false;

	public function index() {
		$railModules = $this->request->getArray( 'railModuleList' );
		$this->isEditPage = $this->request->getBool( 'isEditPage' );
		$this->railModuleList = $this->filterModules( $railModules, self::FILTER_NON_LAZY_MODULES );
		$this->isGridLayoutEnabled = BodyController::isGridLayoutEnabled();
		$this->loadLazyRail = $railModules > $this->railModuleList;
	}

	/**
	 * Entry point for lazy loading right rail for anon users
	 */
	public function executeLazyForAnons() {
		$this->getLazyRail();

		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	/**
	 * Entry point for lazy loading right rail for logged in users
	 */
	public function executeLazy() {
		$this->getLazyRail();
	}

	public function stickyModule() {
		// It loads Rail_stickyModule.php
	}

	/**
	 * Get lazy right rail modules
	 */
	protected function getLazyRail() {
		global $wgAllInOne;

		// override original wgTitle from title given in parameters
		// we cannot use wgTitle that is created on by API because it's broken on wikis without '/wiki' in URL
		// https://wikia-inc.atlassian.net/browse/BAC-906
		$title = Title::newFromText(
			$this->request->getVal( 'articleTitle', null ),
			$this->request->getInt( 'namespace', null )
		);

		if ( !( $title instanceof Title ) ) {
			return;
		}

		$wrapper = new GlobalStateWrapper( [
			'wgTitle' => $title,
		] );

		$context = new DerivativeContext( $this->getContext() );
		$context->setTitle( $title );

		$bodyController = new BodyController();
		$bodyController->setContext( $context );

		$railModuleListRaw = [];
		// XW-3476 wrap until refactor is complete
		$wrapper->wrap( function () use ( $bodyController, &$railModuleListRaw ) {
			$railModuleListRaw = $bodyController->getRailModuleList();
		} );

		$railModules = $this->filterModules(
			$railModuleListRaw,
			self::FILTER_LAZY_MODULES
		);
		$railLazyContent = '';

		krsort( $railModules );

		array_push( $railModules, [ 'Rail', 'stickyModule', [] ] );

		$wrapper->wrap( function () use ( $railModules, &$railLazyContent ) {
			foreach ( $railModules as $railModule ) {
				$railLazyContent .= F::app()->renderView(
					$railModule[0], /* Controller */
					$railModule[1], /* Method */
					$railModule[2] /* array of params */
				);
			}
		} );

		$this->railLazyContent = $railLazyContent;

		$assetManager = AssetsManager::getInstance();

		$this->css = $sassFiles = [];
		foreach ( array_keys( $context->getOutput()->styles ) as $style ) {
			if ( $wgAllInOne && $assetManager->isSassUrl( $style ) ) {
				$sassFiles[] = $style;
			} else {
				$this->css[] = $style;
			}
		}

		if ( !empty( $sassFiles ) ) {
			$excludeScss = (array) $this->getRequest()->getVal( 'excludeScss', [] );
			$sassFilePath = (array) $assetManager->getSassFilePath( $sassFiles );
			$includeScss = array_diff( $sassFilePath, $excludeScss );

			// SUS-771: Log any duplicate CSS that rail modules try to load but are already loaded by Oasis skin
			$duplicateScss = array_intersect( $sassFilePath, $excludeScss );
			if ( count( $duplicateScss ) ) {
				Wikia\Logger\WikiaLogger::instance()->info(
					'SUS-771',
					[
						'styles' => json_encode( $duplicateScss )
					]
				);
			}

			if ( !empty( $includeScss ) ) {
				$this->css[] = $assetManager->getSassesUrl( $includeScss );
			}
		}

		$wrapper = new GlobalStateWrapper( [
			// Do not load user and site jses as they are already loaded and can break page
			'wgAllowUserJs' => false,
			'wgUseSiteJs' => false,
		] );

		$this->js = $wrapper->wrap( function () use ( $context ) {
			return $context->getOutput()->getBottomScripts();
		} );
	}

	/**
	 * Method that filters array of right rail modules into array of only lazy module or non lazy modules
	 *
	 * @param $moduleList
	 * @param $lazy
	 *
	 * @return array
	 */
	private function filterModules( $moduleList, $lazy ) {
		/** @var callable $lazyChecker */
		$lazyChecker = ( $lazy == self::FILTER_LAZY_MODULES ) ?
			[ $this, 'modulesLazyCheck' ] :
			[ $this, 'modulesNotLazyCheck' ];
		$out = [];
		foreach ( $moduleList as $key => $val ) {
			if ( $lazyChecker( $key ) ) {
				$out[$key] = $val;
			}
		}

		return $out;
	}

	private function modulesNotLazyCheck( $moduleKey ) {
		return $moduleKey >= self::LAZY_LOADING_BEAKPOINT;
	}

	private function modulesLazyCheck( $moduleKey ) {
		return $moduleKey < self::LAZY_LOADING_BEAKPOINT;
	}
}
