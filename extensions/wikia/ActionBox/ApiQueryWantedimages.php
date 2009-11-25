<?

if (!defined('MEDIAWIKI')) {
        // Eclipse helper - will be ignored in production
        require_once ('ApiQueryBase.php');
}

class ApiQueryWantedimages extends ApiQueryBase {

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'wn');
	}

	public function execute() {
		$db = $this->getDB();
		$params = $this->extractRequestParams();

	}

	public function getParamDescription() {
		return array(
				'limit' => 'Limit how many wanted pages will be returned'
			    );
	}


	public function getDescription() {
		return "Returns given number of Wanted (missing) images";
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
		return 'api.php?action=query&list=wantedimages&wnlimit=5';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryWantedimages.php overlordq$';
	}
}

