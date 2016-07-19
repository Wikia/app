<?php

class CategoryUrlParams {
	private $display;
	private $sort;
	private $page;

	private $user;

	private $allowedSortOptions = array( 'mostvisited', 'alphabetical' );
	private $sortOption;

	private $allowedDisplayOptions = array( 'exhibition', 'page' );
	private $displayOption;

	public function __construct( WebRequest $request, User $user = null ) {
		$this->user = $user;
		$this->display = $request->getVal( 'display', null );
		$this->sort = $request->getVal( 'sort', null );
		$this->page = $request->getInt( 'page', 0 );

		$this->sortOption = $this->initOption( $this->sort, $this->allowedSortOptions, 'CategoryExhibitionSortType' );
		$this->displayOption = $this->initOption( $this->display, $this->allowedDisplayOptions, 'CategoryExhibitionDisplayType' );
	}

	/**
	 * Get the sort param as it appeared in URL. Useful for caching
	 * To get the computed sort type, call `getSortType`
	 * @return String
	 */
	public function getSortParam() {
		return $this->sort;
	}

	/**
	 * Get the display param as it appeared in URL. Useful for caching
	 * To get the computed display type, call `getDisplayType`
	 * @return String
	 */
	public function getDisplayParam() {
		return $this->display;
	}

	/**
	 * Get the page number from URL (guaranteed to be int and at least zero).
	 * Zero may be returned for incorrect page numbers.
	 * @return int
	 */
	public function getPage() {
		return $this->page;
	}

	public function getAllowedSortOptions() {
		return $this->allowedSortOptions;
	}

	public function getAllowedDisplayOptions() {
		return $this->allowedDisplayOptions;
	}

	/**
	 * Get the sort type requested by user either through the URL or the user preference.
	 * Defaults to the first of the available sort options. Always returns one of the
	 * available options (getAllowedSortOptions).
	 * @return string
	 */
	public function getSortType() {
		return $this->sortOption;
	}

	/**
	 * Get the display type requested by user either through the URL or the user preference.
	 * Defaults to the first of the available display options. Always returns one of the
	 * available options (getAllowedDisplayOptions).
	 * @return string
	 */
	public function getDisplayType() {
		return $this->displayOption;
	}

	/**
	 * Save the current sort and display values as user preference
	 * Don't save if it won't affect the getDisplayType/getSortType logic
	 */
	public function savePreference() {
		if ( !$this->user || $this->user->isAnon() ) {
			return;
		}

		if ( !$this->sort && !$this->display ) {
			return;
		}

		$userPrefSort = $this->user->getGlobalPreference( 'CategoryExhibitionSortType', $this->allowedSortOptions[0] );
		if ( $userPrefSort !== $this->sortType ) {
			$this->user->setGlobalPreference( 'CategoryExhibitionSortType', $this->sortType );
			$this->user->saveSettings();
		}

		$userPrefDisplay = $this->user->getGlobalPreference( 'CategoryExhibitionDisplayType', $this->allowedDisplayOptions[0] );
		if ( $userPrefDisplay !== $this->displayType ) {
			$this->user->setGlobalPreference( 'CategoryExhibitionDisplayType', $this->displayType );
			$this->user->saveSettings();
		}
	}

	private function initOption( $urlParam, $allowedOptions, $userPreferenceName ) {
		$defaultOption = $allowedOptions[0];

		if ( in_array( $urlParam, $allowedOptions ) ) {
			return $urlParam;
		}

		if ( $this->user && !$this->user->isAnon() ) {
			$userOption = $this->user->getGlobalPreference( $userPreferenceName, $defaultOption );
			if ( in_array( $userOption, $allowedOptions ) ) {
				return $userOption;
			}
		}

		return $defaultOption;
	}
}
