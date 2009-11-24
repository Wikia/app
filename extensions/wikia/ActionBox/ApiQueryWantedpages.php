<?

if (!defined('MEDIAWIKI')) {
        // Eclipse helper - will be ignored in production
        require_once ('ApiQueryBase.php');
}



class ApiQueryWantedpages extends ApiQueryGeneratorBase {


	public function __construct( $query ) {
		
	}


	private function run( $resultPageSet = null ) {

		$this->addTables( 'querycache' );
		

	}


	public function getParamDescription() {
		return array(
			'limit' => 'Limit how many random pages will be returned'
		);
	}


	public function getDescription() {
		return "Returns given number of Wantedpages";
	}





	//todo fill

}

