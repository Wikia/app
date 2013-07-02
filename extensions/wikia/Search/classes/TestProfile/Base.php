<?php
/**
 * Class definition for Wikia\Search\TestProfile\Base
 */
namespace Wikia\Search\TestProfile;
/**
 * This class provides for default values for our search A/B testing platform.
 * The default values here allow us to treat all search requests identically, 
 * and to specify new test groups as extensions of this class.
 * The base profile is for users who do not belong to an A/B group.
 * In order to keep backend/front-end parity, we should create a TestProfile instance for 
 * each experimental group, extending from Base. This group does _not_ need any additional logic if,
 * for instance, we are only testing front-end changes.
 * @author relwell
 */
class Base
{
	/**
	 * Query fields to boosts for the main core
	 * @var array
	 */
	const QUERYFIELDS_DEFAULT = [
			'title'             => 100,
			'html'              => 5,
			'redirect_titles'   => 50,
			'categories'        => 25,
			'nolang_txt'        => 10,
			'backlinks_txt'     => 25,
			];
	
	/**
	 * Query fields to boost for the cross-wiki core
	 * @var unknown_type
	 */
	const QUERYFIELDS_INTERWIKI = [
			'headline_txt' => 300,
			'description' => 250,
			'categories' => 50,
			'articles' => 75,
			'top_categories' => 150,
			'top_articles' => 200,
			'sitename_txt' => 500
			];
	
	/**
	 * Used to be in the config.
	 * Allows us to configure boosts for the provided fields.
	 * Use the non-translated version.
	 * @var array
	 */
	protected $queryFieldsToBoostsSelector = [
			'default' => static::QUERYFIELDS_DEFAULT,
			'Wikia\\Search\\QueryService\\Select\\InterWiki' => static::QUERYFIELDS_INTERWIKI,
			];
	
	/**
	 * Returns query fields to be injected into the config.
	 * @return array
	 */
	public function getQueryFieldsToBoosts( $queryService = null ) {
		if ( $queryService !== null && isset( $this->queryFieldsToBoostsSelector[$queryService] ) ) {
			return $this->queryFieldsToBoostsSelector[$queryService];
		}
		return $this->queryFieldsToBoostsSelector['default'];
	}
	
}