<?php

/**
 * LicensedVideoSwap Helper
 * @author Garth Webb
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class LicensedVideoSwapHelper extends WikiaModel {

	/**
	 * get sort options
	 * @return array $options
	 */
	public function getSortOption() {
		$options = array(
			'recent' => $this->wf->Message( 'specialvideos-sort-latest' ),
			'popular' => $this->wf->Message( 'specialvideos-sort-most-popular' ),
			'trend' => $this->wf->Message( 'specialvideos-sort-trending' ),
		);

		return $options;
	}

}