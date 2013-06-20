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
	 * Used to be in the config.
	 * Allows us to configure boosts for the provided fields.
	 * Use the non-translated version.
	 * @var array
	 */
	protected $queryFieldsToBoosts = [
			'title'             => 100,
			'html'              => 5,
			'redirect_titles'   => 50,
			'categories'        => 25,
			'nolang_txt'        => 10,
			'backlinks_txt'     => 25,
			];
	
	/**
	 * Returns query fields to be injected into the config.
	 * @return array
	 */
	public function getQueryFieldsToBoosts() {
		return $this->queryFieldsToBoosts;
	}
	
}