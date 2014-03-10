<?php
/**
 * Created by adam
 * Date: 13.02.14
 */

namespace Wikia\Search\TestProfile;

class GroupTvCrossWikiApi {

	protected $interWikiQueryFields = [
		'headline_txt' => 300,
		'description_txt' => 250,
		'categories_txt' => 50,
		'articles_i' => 75,
		'top_categories_txt' => 150,
		'top_articles_txt' => 200,
		'sitename_txt' => 500,
//		'series_txt' => 1000
	];

	protected $tieParams = [
		'default' => 0.01,
	];

	/**
	 * Returns query fields to be injected into the config.
	 * @return array
	 */
	public function getQueryFieldsToBoosts() {
		return $this->interWikiQueryFields;
	}

	/**
	 * Provides a tie param configured for the provided query service, with a default back-off
	 * @return int
	 */
	public function getTieParam( $queryService = null ) {
		$key = 'default';
		if ( ( $queryService !== null ) && isset( $this->tieParams[$queryService] ) ) {
			$key = $queryService;
		}
		return $this->tieParams[$key];
	}

}
