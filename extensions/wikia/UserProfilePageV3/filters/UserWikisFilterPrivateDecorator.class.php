<?php

/**
 * Filters private wikis from user favourite wikis list
 *
 * Class UserWikisFilterPrivateDecorator
 */
class UserWikisFilterPrivateDecorator extends UserWikisFilterDecorator {
	public function getFiltered() {
		$filtered = $this->filter->getFiltered();

		foreach ( $filtered as $key => $wikiData ) {
			$wikiId = ( int ) $wikiData['id'];

			if ( WikiFactory::getVarValueByName( 'wgIsPrivateWiki', $wikiId ) ) {
				unset( $filtered[$key] );
			}
		}

		return $filtered;
	}

}
