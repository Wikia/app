<?php
/**
 * Class HiddenWikisFilter
 *
 * @desc Manages wikis array/collection and returns filtered version
 */
class HiddenWikisFilter extends UserWikisFilter {
	private $wikis = [];
	private $hiddenWikis = [];

	public function __construct( $wikis, $hiddenWikis ) {
		$this->wikis = $wikis;
		$this->hiddenWikis = $hiddenWikis;
	}

	public function getFiltered() {
		foreach( $this->wikis as $key => $wiki ) {
			$wikiId = (int) $wiki['id'];

			if( $this->isTopWikiHidden( $wikiId ) ) {
				unset( $this->wikis[$key] );
			}
		}

		return $this->wikis;
	}

	private function isTopWikiHidden( $wikiId ) {
		return in_array( $wikiId, $this->hiddenWikis );
	}

}
