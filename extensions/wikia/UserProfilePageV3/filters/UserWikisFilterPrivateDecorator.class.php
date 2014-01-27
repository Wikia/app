<?php
class UserWikisFilterPrivateDecorator extends UserWikisFilterDecorator {
	private $privateWikis;
	private $filter;

	public function __construct( UserWikisFilter $filter ) {
		$this->filter = $filter;
		$this->privateWikis = UserProfilePageHelper::getHiddenWikiIds();
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
