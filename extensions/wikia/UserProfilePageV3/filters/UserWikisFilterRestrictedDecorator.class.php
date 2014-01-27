<?php
class UserWikisFilterRestrictedDecorator extends UserWikisFilterDecorator {
	private $privateWikis;
	private $filter;

	public function __construct( UserWikisFilter $filter ) {
		$this->filter = $filter;
		$this->privateWikis = UserProfilePageHelper::getRestrictedWikisIds();
	}

	public function getFiltered() {
		$filtered = $this->filter->getFiltered();

		foreach( $filtered as $key => $wikiData ) {
			$wikiId = (int) $wikiData['id'];

			if( in_array( $wikiId, $this->privateWikis ) ) {
				unset( $filtered[$key] );
			}
		}

		return $filtered;
	}

}
