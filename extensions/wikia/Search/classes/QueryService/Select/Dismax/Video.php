<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\VideoSearch
 */
namespace Wikia\Search\QueryService\Select\Dismax;

/**
 * Class responsible for video search.
 *
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class Video extends OnWiki {
	/**
	 * Adding English title to requested fields for i18n
	 *
	 * @var array
	 */
	protected $requestedFields = [
		'id',
		'pageid',
		'wikiarticles',
		'wikititle',
		'url',
		'wid',
		'canonical',
		'host',
		'ns',
		'indexed',
		'backlinks',
		'title',
		'score',
		'created',
		'views',
		'categories',
		'hub',
		'lang',
		'title_en',
	];

	// skipping boost functions
	protected $boostFunctions = [];
}
