<?

if (!defined('MEDIAWIKI')) {
        // Eclipse helper - will be ignored in production
        require_once ('ApiQueryBase.php');
}

class ApiQueryWantedimages extends ApiQueryBase {

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'wi');
	}

	/*
	 * returns true if the given article contains less then $threshold articles
	 */
	private function containsImages( $page, $threshold ) {
		return $this->getImageCount( $page ) > 0 && $this->getImageCount( $page ) < $threshold;
	}

	private function getImageCount( $page ) {
		if( isset( $this->image_cnt[$page]) ) {
			return $this->image_cnt[$page];
		}

		global $wgMemc;

		$memcKey = wfMemcKey( 'ws_image_cnt', $page );
		$this->image_cnt[$page] = $wgMemc->get( $memcKey );
		if( $this->image_cnt[$page] === null ) {
			$dbr = wfGetDB( DB_SLAVE, 'api' );
			$this->image_cnt[$page] = $dbr->selectField(
					'imagelinks',
					'count(*) as cnt',
					array( 'il_from' => $page ),
					__METHOD__ );
			$wgMemc->set( $memcKey, $this->image_cnt[$page], 60*60*12 );
		}
		return $this->image_cnt[$page];
	}

	public function execute() {
		global $wgContentNamespaces;

		$db = $this->getDB();
		$params = $this->extractRequestParams();

		$this->addFields( array( 'page_id', 'page_title', 'page_namespace' ) );
		$this->addTables( array( 'querycache', 'page' ) );
		$this->addJoinConds( array(
			'page' => array( 'JOIN', array(
						'qc_title = page_title',
						'qc_namespace = page_namespace' ) ),
			) );
		$this->addWhereFld( 'qc_type', 'Mostlinked' );
		$this->addWhereFld( 'page_namespace', $wgContentNamespaces );
		$this->addWhereFld( 'page_is_redirect', 0 );
		$this->addOption( 'ORDER BY', 'qc_value DESC' );

		$res = $this->select(__METHOD__);
		$count = 0;
		$result = $this->getResult();

		while( $row = $db->fetchObject( $res ) ) {
			if( !$this->containsImages( $row->page_id, 20 ) ) {
				if (++$count > $params['limit']) {
					// We've reached the one extra which shows that
					// there are additional pages to be had. Stop here...
					$this->setContinueEnumParameter('continue', $row->page_title );
					break;
				}
				$vals['title'] = $row->page_title;
				$vals['namespace'] = $row->page_namespace;

				$fit = $this->getResult()->addValue(array('query', $this->getModuleName()), null, $vals);
				if(!$fit) {
					break;
				}
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

