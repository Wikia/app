<?

if (!defined('MEDIAWIKI')) {
        // Eclipse helper - will be ignored in production
        require_once ('ApiQueryBase.php');
}

class ApiQueryWantedimages extends ApiQueryBase {

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'wi');
	}

	public function execute() {
		global $wgContentNamespaces;

		$db = $this->getDB();
		$params = $this->extractRequestParams();

                $this->addFields( array( 'page_title', 'page_namespace' ) );
                $this->addTables( 'querycache' );
                $this->addTables( 'page' );
                $this->addTables( 'imagelinks' );
		$this->addJoinConds( array(
			'page' => array( 'JOIN', array(
						'qc_title = page_title',
						'qc_namespace = page_namespace' ) ),
			'imagelinks' => array( 'LEFT JOIN', 'page_id = il_from' )
			) );
		$this->addWhere( array( 
			"qc_type = 'Mostlinked'",
			"il_to is NULL",
			"qc_namespace IN (" . implode( ",", $wgContentNamespaces ) . ")",
			"page_is_redirect = 0",
			) );
		$this->addOption( 'ORDER BY', 'qc_value DESC' );
                $this->addOption( 'LIMIT', $params['limit'] + 1 );

                $res = $this->select(__METHOD__);
                $count = 0;
                $result = $this->getResult();

                while( $row = $db->fetchObject( $res ) ) {
                        if (++$count > $params['limit']) {
                                // We've reached the one extra which shows that
                                // there are additional pages to be had. Stop here...
                                $this->setContinueEnumParameter('continue', $row->page_title );
                                break;
                        }

                        $title = Title::makeTitle($row->page_namespace, $row->page_title);
                        $vals['title'] = $row->page_title;
                        $vals['namespace'] = $row->page_namespace;

                        $fit = $this->getResult()->addValue(array('query', $this->getModuleName()), null, $vals);
                        if(!$fit) {
                                break;
                        }
                }
                $db->freeResult( $res );
                $this->getResult()->setIndexedTagName_internal(array('query', $this->getModuleName()), 'page');
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
					ApiBase :: PARAM_MAX => 50,
					ApiBase :: PARAM_MAX2 => 100
					),
			     );
	}

	protected function getExamples() {
		return 'api.php?action=query&list=wantedimages&wilimit=5';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryWantedimages.php overlordq$';
	}
}

