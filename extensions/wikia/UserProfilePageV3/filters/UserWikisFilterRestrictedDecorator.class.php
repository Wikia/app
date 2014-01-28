<?php
class UserWikisFilterRestrictedDecorator extends UserWikisFilterDecorator {
	private $filter;

	public function __construct( UserWikisFilter $filter ) {
		$this->filter = $filter;
	}

	public function getFiltered() {
		$filtered = $this->filter->getFiltered();
		$privateWikis = $this->getRestrictedWikis();

		foreach( $filtered as $key => $wikiData ) {
			$wikiId = (int) $wikiData['id'];

			if( in_array( $wikiId, $privateWikis ) ) {
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
