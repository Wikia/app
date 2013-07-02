<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Lucene
 */
namespace Wikia\Search\QueryService\Select;
use Wikia\Search\Config;
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
		if ( $this->getCore() == AbstractSelect::SOLR_CORE_CROSSWIKI ) {
			$this->getConfig()->setRequestedFields( Config::REQUESTED_FIELDS_INTERWIKI );
		}
		$this->registerQueryParams( $select );
		return $this;
	}
	
	/**
	 * This obviously violates the LSP -- @todo create a parent to abstractselect
	 * @return string
	 */
	protected function getQueryFieldsString() {
		return '';
	}
}