<?php
class UserWikisFilterUniqueDecorator extends UserWikisFilterDecorator {
	private $filter;

	public function __construct( UserWikisFilter $filter ) {
		$this->filter = $filter;
	}

	public function getFiltered() {
		$filtered = $this->filter->getFiltered();
		$ids = [];

		foreach( $filtered as $key => $wikiData ) {
			$wikiId = (int) $wikiData['id'];

			if( in_array( $wikiId, $ids ) ) {
				unset( $filtered[$key] );
			}

			$ids[] = $wikiId;
		}

		return $filtered;
	}

}
