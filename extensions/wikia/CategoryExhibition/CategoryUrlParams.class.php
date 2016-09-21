<?php

class CategoryUrlParams {
	const ALLOWED_SORT_TYPES = [ 'mostvisited', 'alphabetical' ];
	const ALLOWED_DISPLAY_TYPES = [ 'exhibition', 'page' ];

	/**
	 * @var user passed through constructor. Used to read and save the preferences for sort and display types
	 */
	private $user;

	/**
	 * @var String display param value as appears in URL
	 */
	private $display;

	/**
	 * @var String sort param value as appears in URL
	 */
	private $sort;

	/**
	 * @var int page number as appears in URL, converted to int, 0 being the default value
	 */
	private $page;

	/**
	 * @var string the computed sort type. One of self::ALLOWED_SORT_TYPES
	 */
	private $sortType;

	/**
	 * @var string the computed display type. One of self::ALLOWED_DISPLAY_TYPES
	 */
	private $displayType;

	public function __construct( WebRequest $request, User $user = null ) {
		$this->user = $user;
		$this->display = $request->getVal( 'display', null );
		$this->sort = $request->getVal( 'sort', null );
		$this->page = $request->getInt( 'page', 0 );

		$this->sortType = $this->initType( $this->sort, self::ALLOWED_SORT_TYPES, 'CategoryExhibitionSortType' );
		$this->displayType = $this->initType( $this->display, self::ALLOWED_DISPLAY_TYPES, 'CategoryExhibitionDisplayType' );
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

	public function getAllowedSortTypes() {
		return self::ALLOWED_SORT_TYPES;
	}

	public function getAllowedDisplayTypes() {
		return self::ALLOWED_DISPLAY_TYPES;
	}

	/**
	 * Get the sort type requested by user either through the URL or the user preference.
	 * Defaults to the first of the available sort types. Always returns one of the
	 * allowed types (getAllowedSortTypes).
	 * @return string
	 */
	public function getSortType() {
		return $this->sortType;
	}

	/**
	 * Get the display type requested by user either through the URL or the user preference.
	 * Defaults to the first of the available display types. Always returns one of the
	 * allowed types (getAllowedDisplayTypes).
	 * @return string
	 */
	public function getDisplayType() {
		return $this->displayType;
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

		$userPrefSort = $this->user->getGlobalPreference( 'CategoryExhibitionSortType', self::ALLOWED_SORT_TYPES[0] );
		if ( $userPrefSort !== $this->sortType ) {
			$this->user->setGlobalPreference( 'CategoryExhibitionSortType', $this->sortType );
			$this->user->saveSettings();
		}

		$userPrefDisplay = $this->user->getGlobalPreference( 'CategoryExhibitionDisplayType', self::ALLOWED_DISPLAY_TYPES[0] );
		if ( $userPrefDisplay !== $this->displayType ) {
			$this->user->setGlobalPreference( 'CategoryExhibitionDisplayType', $this->displayType );
			$this->user->saveSettings();
		}
	}

	private function initType( $urlParam, $allowedTypes, $userPreferenceName ) {
		$defaultType = $allowedTypes[0];

		if ( in_array( $urlParam, $allowedTypes ) ) {
			return $urlParam;
		}

		if ( $this->user && !$this->user->isAnon() ) {
			$userType = $this->user->getGlobalPreference( $userPreferenceName, $defaultType );
			if ( in_array( $userType, $allowedTypes ) ) {
				return $userType;
			}
		}

		return $defaultType;
	}
}
