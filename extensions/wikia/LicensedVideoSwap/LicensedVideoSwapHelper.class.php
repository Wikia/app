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
	public function getSortOption($selected) {
		// Set it up this way for now so mustache can consume it
		// TODO: we will use a helper function in the future. Saipetch will set this up.
		$options = array(
			array(
				'sortBy' => 'recent',
				'option' => $this->wf->Message( 'specialvideos-sort-latest' ),
				'selected' => ($selected == 'recent'),
			),
			array(
				'sortBy' => 'popular',
				'option' => $this->wf->Message( 'specialvideos-sort-most-popular' ),
				'selected' => ($selected == 'popular'),
			),
			array(
				'sortBy' => 'trend',
				'option' => $this->wf->Message( 'specialvideos-sort-trending' ),
				'selected' => ($selected == 'trend'),
			)
		);

		return $options;
	}

}