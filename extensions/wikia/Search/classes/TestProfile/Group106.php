<?php
/**
 * Class definition for Wikia\Search\TestProfile\Base
 */
namespace Wikia\Search\TestProfile;
/**
 * As a "lettered" group, this group represents an experimental group.
 * @author relwell
 */
class Group106 extends Base
{
	/**
	 * Used to be in the config.
	 * Allows us to configure boosts for the provided fields.
	 * Use the non-translated version.
	 * @var array
	 */
	protected $defaultQueryFields = [
			'title'             => 100,
			'html'              => 5,
			'redirect_titles'   => 50,
			'categories'        => 25,
			'nolang_txt'        => 10,
			'headings'          => 50
			];
}