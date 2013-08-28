<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\VideoSearch
 */
namespace Wikia\Search\QueryService\Select\Dismax;
use Wikia\Search\Utilities;
/**
 * Class responsible for video search. Not totally sure we're using this for video search presently.
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class Video extends OnWiki
{
	/**
	 * This is the cityId value for the video wiki, used in video searches.
	 * @var int
	 */
	const VIDEO_WIKI_ID = 298117;
	
	/**
	 * Adding English title to requested fields for i18n 
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
	protected $boostFunctions = array();
}