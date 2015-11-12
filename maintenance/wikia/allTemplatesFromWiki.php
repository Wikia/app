<?php

/**
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '../../Maintenance.php' );

class allTemplatesFromWiki extends Maintenance {
	const TEMPLATE_MESSAGE_PREFIX = 'initialClassification._namespace:template';
	/** @var PipelineConnectionBase */
	protected static $pipe;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'allTemplatesFromWiki';
	}

	public function execute() {
		$data = $this->getTemplatesFromWiki();
		$this->output( "\nFetching template IDs from DB done!\n" );

		$this->pushDataToRabbit( $data );
		$this->output( "\nPushing events done! \nBye\n" );
	}

	/**
	 * @desc Get from current DB all template IDs
	 *
	 * @return bool|mixed
	 * @throws \Exception
	 * @throws \FluentSql\Exception\SqlException
	 */
	protected function getTemplatesFromWiki() {
		$db = wfGetDB( DB_SLAVE );

		$pages = ( new \WikiaSQL() )
			->SELECT('page_id','page_title')
			->FROM('page')
			->WHERE('page_namespace')->EQUAL_TO( NS_TEMPLATE )
			->runLoop( $db, function ( &$pages, $row ) {
				$pages[] = [
					'page_id' => $row->page_id,
					'page_title' => $row->page_title
				];
			} );

		return $pages;
	}

	/**
	 * prepares appropriate format and sends data to pipeline
	 * @param $data
	 */
	protected function pushDataToRabbit( $data ) {
		global $wgCityId;
		$msg = new stdClass();
		$msg->cityId = $wgCityId;
		foreach ( $data as $template ) {
			$msg->pageId = $template[ 'page_id' ];

			try {
				self::getPipeline()
					->publish( implode( '.', [ self::TEMPLATE_MESSAGE_PREFIX ] ), $msg );
			} catch ( Exception $e ) {
				print( "Error while pushing template with ID:". $template[ 'page_id' ] );
				\Wikia\Logger\WikiaLogger::instance()->error( __METHOD__, [
					'exception' => $e,
					'event_name' => 'push templates to rabbit'
				] );
			}
		}
	}

	/**
	 * @return PipelineConnectionBase
	 */
	protected static function getPipeline() {
		if ( !isset( self::$pipe ) ) {
			self::$pipe = new PipelineConnectionBase();
		}
		return self::$pipe;
	}
}

$maintClass = 'allTemplatesFromWiki';
require_once( RUN_MAINTENANCE_IF_MAIN );
