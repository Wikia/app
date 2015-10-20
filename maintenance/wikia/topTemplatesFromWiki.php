<?php

/**
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '../../Maintenance.php' );

class topTemplatesFromWiki extends Maintenance {
	const TEMPLATE_MESSAGE_PREFIX = 'articledi';
	/** @var PipelineConnectionBase */
	protected static $pipe;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'topTemplatesFromWiki';
	}

	public function execute() {
		$data = $this->getTemplatesFromWiki();
		$this->pushDataToRabbit( $data );

		$this->output( "\nDone!\n" );
		$this->output($data);
	}

	protected function getTemplatesFromWiki() {
		$db = wfGetDB( DB_SLAVE );
		$pages = ( new \WikiaSQL() )
			->SELECT( 'tl_namespace AS namespace', 'tl_title AS title', 'COUNT(*) AS value' )
			->FROM( 'templatelinks' )
			->WHERE( 'tl_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->GROUP_BY( 'tl_namespace', 'tl_title' )
			->HAVING( 'COUNT(*)' )->GREATER_THAN( 0 )
			->ORDER_BY( 'COUNT(*)' )->DESC()
			->runLoop( $db, function ( &$pages, $row ) {
				global $wgCityId;
				$pages[] = [
					'wiki_id' => $wgCityId,
					'page_id' => $row->value,
					'title' => $row->title
				];
			} );

		return $pages;
	}

	protected function pushDataToRabbit( $data ) {
		global $wgCityId;
		$msg = new stdClass();
		$msg->cityId = $wgCityId;
		$msg->args = new stdClass();
		foreach ( $data as $template ) {
			$msg->pageId = (int)$template[ 'page_id' ];

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

	/** @return PipelineConnectionBase */
	protected static function getPipeline() {
		if ( !isset( self::$pipe ) ) {
			self::$pipe = new PipelineConnectionBase();
		}
		return self::$pipe;
	}
}

$maintClass = 'topTemplatesFromWiki';
require_once( RUN_MAINTENANCE_IF_MAIN );
