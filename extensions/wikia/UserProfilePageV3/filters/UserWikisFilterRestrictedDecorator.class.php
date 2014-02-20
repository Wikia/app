<?php
class UserWikisFilterRestrictedDecorator extends UserWikisFilterDecorator {
	private $filter;

	public function __construct( UserWikisFilter $filter ) {
		$this->filter = $filter;
	}

	public function getFiltered() {
		$filtered = $this->filter->getFiltered();
		$restrictedWikis = $this->getRestrictedWikis();

		foreach( $filtered as $key => $wikiData ) {
			$wikiId = (int) $wikiData['id'];

			if( in_array( $wikiId, $restrictedWikis ) ) {
				unset( $filtered[$key] );
			}
		}

		return $filtered;
	}

	/**
	 * @desc Helper method which can be mocked in unit tests
	 *
	 * @return Array
	 */
	public function getRestrictedWikis() {
		return UserProfilePageHelper::getRestrictedWikisIds();
	}

}
