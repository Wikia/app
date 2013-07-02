<?php
/**
 * Class definition for Wikia\Search\TestProfile\Base
 */
namespace Wikia\Search\TestProfile;
/**
 * As a "lettered" group, this group represents an experimental group.
 * @author relwell
 */
class GroupA extends Base
{
	/**
	 * Used to be in the config.
	 * Allows us to configure boosts for the provided fields.
	 * Use the non-translated version.
	 * @var array
	 */
	protected $defaultQueryFields = [
			'title'             => 100,
			'html'              => 80,
			'redirect_titles'   => 50,
			'nolang_txt'        => 10,
			'backlinks_txt'     => 120,
			];
}