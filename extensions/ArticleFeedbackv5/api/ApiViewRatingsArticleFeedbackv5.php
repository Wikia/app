<?php
/**
 * ApiViewRatingsArticleFeedbackv5 class
 *
 * @package    ArticleFeedback
 * @subpackage Api
 * @author     Greg Chiasson <greg@omniti.com>
 * @author     Reha Sterbin <reha@omniti.com>
 * @version    $Id: ApiViewRatingsArticleFeedbackv5.php 110950 2012-02-08 19:26:24Z gregchiasson $
 */

/**
 * This class pulls the aggregated ratings for display in Bucket #5
 *
 * @package    ArticleFeedback
 * @subpackage Api
 */
class ApiViewRatingsArticleFeedbackv5 extends ApiQueryBase {

	/**
	 * Constructor
	 */
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'af' );
	}

	/**
	 * Execute the API call: Pull the aggregated ratings
	 */
	public function execute() {
		$params = $this->extractRequestParams();
		global $wgArticleFeedbackv5RatingTypes;

		$params        = $this->extractRequestParams();
		$result        = $this->getResult();
		$result_path   = array( 'query', $this->getModuleName() );
		$pageId	       = $params['pageid'];
		$rollup        = $this->fetchRollup( $pageId );

		$result->addValue( $result_path, 'pageid', $params['pageid'] );
		$result->addValue( $result_path, 'status', 'current' );

		$info = array();
		foreach ( $rollup as $row ) {
			$info[$row->field_name] = array(
				'ratingdesc' => $row->field_name,
				'ratingid'   => (int) $row->field_id,
				'total'      => (int) $row->arr_total,
				'count'      => (int) $row->arr_count,
			);
		}
		$result->addValue( $result_path, 'rollup', $info );
	}

	/**
	 * Pulls a rollup row
	 *
	 * @param  $pageId int the page id
	 * @return array   the rollup rows
	 */
	private function fetchRollup( $pageId ) {
		$dbr     = wfGetDB( DB_SLAVE );
		$where   = array();
		$where[] = 'arr_field_id = afi_id';
		$where['arr_page_id'] = $pageId;

		$rows  = $dbr->select(
			array(
				'aft_article_feedback_ratings_rollup',
				'aft_article_field'
			),
			array(
				'afi_name AS field_name',
				'arr_field_id AS field_id',
				'arr_total',
				'arr_count',
			),
			$where,
			__METHOD__
		);

		return $rows;
	}

	/**
	 * Gets the allowed parameters
	 *
	 * @return array the params info, indexed by allowed key
	 */
	public function getAllowedParams() {
		return array(
			'pageid' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE     => 'integer',
			)
		);
	}

	/**
	 * Gets the parameter descriptions
	 *
	 * @return array the descriptions, indexed by allowed key
	 */
	public function getParamDescription() {
		return array(
			'pageid' => 'Page ID to get feedback ratings for',
		);
	}

	/**
	 * Gets the api descriptions
	 *
	 * @return array the description as the first element in an array
	 */
	public function getDescription() {
		return array(
			'List article feedback ratings for a specified page'
		);
	}

	/**
	 * Gets an example
	 *
	 * @return array the example as the first element in an array
	 */
	public function getExamples() {
		return array(
			'api.php?action=query&list=articlefeedbackv5-view-ratings&afpageid=1',
		);
	}

	/**
	 * Gets the version info
	 *
	 * @return string the SVN version info
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiViewRatingsArticleFeedbackv5.php 110950 2012-02-08 19:26:24Z gregchiasson $';
	}

}

