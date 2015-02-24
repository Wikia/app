<?php
class UserWikisFilterUniqueDecorator extends UserWikisFilterDecorator {
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
