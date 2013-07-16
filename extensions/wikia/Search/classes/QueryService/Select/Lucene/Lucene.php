<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Lucene\Lucene
 */
namespace Wikia\Search\QueryService\Select\Lucene;
use Wikia\Search\QueryService\Select\AbstractSelect;
use Wikia\Search\TestProfile\Base as BaseProfile;
/**
 * This class is responsible for queries that use strict Lucene syntax (without DisMax)
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class Lucene extends AbstractSelect
{
	protected $core = 'main';
	
	/**
	 * Default requested fields for a main-core search service.
	 * We've added html here because we usually want it in a lucene query. 
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
				'html',
			];
	
	/**
	 * (non-PHPdoc)
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::getQueryClausesString()
	 */
	protected function getQuery() {
		return $this->config->getQuery()->getSanitizedQuery();
	}
}