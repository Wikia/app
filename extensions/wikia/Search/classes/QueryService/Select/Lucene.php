<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Lucene
 */
namespace Wikia\Search\QueryService\Select;
/**
 * This class is responsible for queries that use strict Lucene syntax (without DisMax)
 * @todo this class should be the only instance in the Select namespace; the other classes should be in the Select\Dismax subnamespace.
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class Lucene extends AbstractSelect
{
	/**
	 * (non-PHPdoc)
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::getQueryClausesString()
	 */
	protected function getFormulatedQuery() {
		return $this->config->getQuery()->getSanitizedQuery();
	}
	
	protected function registerComponents( \Solarium_Query_Select $select ) {
		return $this->registerQueryParams( $select );
	}
	
	/**
	 * This obviously violates the LSP -- @todo create a parent to abstractselect
	 * @return string
	 */
	protected function getQueryFieldsString() {
		return '';
	}
}