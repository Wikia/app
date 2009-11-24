<?

if (!defined('MEDIAWIKI')) {
        // Eclipse helper - will be ignored in production
        require_once ('ApiQueryBase.php');
}

class ApiQueryWantedpages extends ApiQueryGeneratorBase {

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'wn');
	}

	public function execute() {
		$this->run();
	}

	public function executeGenerator($resultPageSet) {
		$this->run($resultPageSet);
	}
	
	protected function prepareQuery( $limit, &$resultPageSet ) {

		$this->resetQueryParams();
		$this->addTables( 'querycache' );
		$this->addOption( 'LIMIT', $limit );		
		$this->addWhereFld( 'qc_type', 'Wantedpages' );

	}

	protected function runQuery(&$resultPageSet) {
		$db = $this->getDB();
		$res = $this->select(__METHOD__);
		$count = 0;

	}

	private function run( $resultPageSet = null ) {

		$this->prepareQuery();	
		$count = $this->runQuery($resultPageSet);

	}

	public function getParamDescription() {
		return array(
				'limit' => 'Limit how many random pages will be returned'
			    );
	}


	public function getDescription() {
		return "Returns given number of Wantedpages";
	}

	public function getAllowedParams() {
		return array (
				'limit' => array (
					ApiBase :: PARAM_TYPE => 'limit',
					ApiBase :: PARAM_DFLT => 5,
					ApiBase :: PARAM_MIN => 1,
					ApiBase :: PARAM_MAX => 10,
					ApiBase :: PARAM_MAX2 => 20
					),
			     );
	}

	protected function getExamples() {
		return 'api.php?action=query&list=wantedpages&wnlimit=5';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryWantedpages.php overlordq$';
	}
}

