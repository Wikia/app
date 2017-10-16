<?php
/**
 * Created by adam
 * Date: 29.01.14
 */

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class WIDlist extends Maintenance {

	private $CONFIG = [
		'adapter' => 'Solarium_Client_Adapter_Curl',
		'adapteroptions' => [
			'host' => 'search-master',
			'port' => 8983,
			'path' => '/solr/',
			'core' => 'main'
		]
	];

	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {
		$data = $this->getIds();
		sort( $data );
		echo implode( ',', $data );
	}

	protected function getIds() {
		$client = new Solarium_Client( $this->CONFIG );

		$select = $client->createSelect();

		$select->setRows( 20000 );

		$select->createFilterQuery( 'users' )->setQuery('activeusers:[0 TO *]');
		$select->createFilterQuery( 'pages' )->setQuery('wikipages:[500 TO *]');
		$select->createFilterQuery( 'words' )->setQuery('words:[10 TO *]');
		$select->createFilterQuery( 'ns' )->setQuery('ns:0');
		$select->createFilterQuery( 'wam' )->setQuery('-(wam:0)');
		$select->createFilterQuery( 'dis' )->setQuery('-(title_en:disambiguation)');
		$select->createFilterQuery( 'answer_host' )->setQuery('-(host:*answers.wikia.com)');
		$select->createFilterQuery( 'answer' )->setQuery('-(hub:Wikianswers)');
		//speedydeletion: 547090, scratchpad: 95, lyrics:43339, colors:32379
		$select->createFilterQuery( 'banned' )->setQuery('-(wid:547090) AND -(wid:95) AND -(wid:43339) AND -(wid:32379)');

        // faceting would be less expensive
		$select->addParam( 'group', 'true' );
		$select->addParam( 'group.field', 'wid' );
		$select->addParam( 'group.ngroups', 'true' );

		$result = $client->select( $select );

		$ids = [];
		if ( isset( $result->getData()['grouped']['wid']['groups'] ) ) {
			foreach( $result->getData()['grouped']['wid']['groups'] as $group ) {
				$ids[] = $group['groupValue'];
			}
		}
		return $ids;
	}
}

$maintClass = 'WIDlist';
require( RUN_MAINTENANCE_IF_MAIN );
