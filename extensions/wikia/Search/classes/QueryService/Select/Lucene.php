<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Lucene
 */
namespace Wikia\Search\QueryService\Select;

class Lucene extends AbstractSelect
{
	/**
	 * (non-PHPdoc)
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::getQueryClausesString()
	 */
	protected function getFormulatedQuery() {
		return $this->config->getQuery( \Wikia\Search\Config::QUERY_RAW );
	}
}