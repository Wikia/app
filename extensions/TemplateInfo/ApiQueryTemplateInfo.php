<?php
/**
 * Adds the 'templateinfo' action to the MediaWiki API.
 *
 * @author Yaron Koren
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if (!defined('MEDIAWIKI')) die();

/**
 * @ingroup API
 */
class APIQueryTemplateInfo extends ApiQueryBase {

	public function __construct( $query, $moduleName ) {
		parent :: __construct( $query, $moduleName, 'ti' );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		$titles = $this->getPageSet()->getGoodTitles();
		if (count($titles) == 0)
			return;

		$this->addTables( 'page_props' );
		$this->addFields( array( 'pp_page', 'pp_value' ) );
		$this->addWhere( array(
			'pp_page' => array_keys( $titles ),
			'pp_propname' => 'templateinfo'
		) );
		if ( !is_null( $params['continue'] ) )
		{
			$fromid = intval( $params['continue'] );
			$this->addWhere( "pp_page >= $fromid" );
		}
		$this->addOption( 'ORDER BY', 'pp_page' );

		$res = $this->select(__METHOD__);
		while ( $row = $this->getDB()->fetchObject( $res ) ) {
			$vals = array( );
			$template_info = $row->pp_value;
			// determine whether this is actual XML or an error
			// message by checking whether the first character
			// is '<' - this is an interim solution until there's
			// a better storage format in place
			if (substr($template_info, 0, 1) == '<')
				ApiResult::setContent( $vals, $row->pp_value );
			else
				// add error message as an "error=" attribute
				$vals['error'] = $row->pp_value;
			$fit = $this->addPageSubItems( $row->pp_page, $vals );
			if( !$fit ) {
				$this->setContinueEnumParameter( 'continue', $row->pp_page );
				break;
			}
		}
	}
	
	public function getAllowedParams() {
		return array (
			'continue' => null,
		);
	}

	public function getParamDescription() {
		return array (
			'continue' => 'When more results are available, use this to continue',
		);
	}

	public function getDescription() {
		return 'Template information, defined by the Template Info extension (http://www.mediawiki.org/Extension:Template_Info)';
	}

	public function getExamples() {
		return array (
			'api.php?action=query&prop=templateinfo&titles=Template:Foo|Template:Bar',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryTemplateInfo.php 67467 2010-06-06 15:12:22Z ialex $';
	}

}
