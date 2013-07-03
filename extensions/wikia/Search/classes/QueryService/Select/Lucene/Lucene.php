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
	 * (non-PHPdoc)
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::getQueryClausesString()
	 */
	protected function getQuery() {
		return $this->config->getQuery()->getSanitizedQuery();
	}
}