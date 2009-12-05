<?

if (!defined('MEDIAWIKI')) {
        // Eclipse helper - will be ignored in production
        require_once ('ApiQueryBase.php');
}

class ApiQueryWantedimages extends ApiQueryBase {

	public function __construct($query, $moduleName) {
		parent::__construct($query, $moduleName, 'wi');
	}

	/*
	 * returns true if the given article contains less then $threshold articles
	 */
	private function hasImages( $page, $threshold ) {
		if( !isset( $this->has_images[$page] ) ) {
			global $wgMemc;
			$memcKey = wfMemcKey('ws_has_imags', $page);
			$this->has_images[$page] = $wgMemc->get( $memcKey );
			if( $this->has_images[$page] === null ) {
				$dbr = $this->getDB();
				$res = $dbr->select(
						'imagelinks',
						'il_to',
						array( 'il_from' => $page ),
						__METHOD__ );
				foreach( $res as $row ) {
					if( $this->getReferencesCount( $row->il_to ) < $threshold ) {
						$this->has_images[$page] = true;
						$wgMemc->set( $memcKey, $this->has_images[$page], 60*60*12 );
						return true;
					}	       
				}
				$this->has_images[$page] = false;
				$wgMemc->set( $memcKey, $this->has_images[$page], 60*60*12 );
			}
		}
		return $this->has_images[$page];
	}

	private function getReferencesCount( $imageName ) {
		if( !isset( $this->refs_cnt[$imageName] ) ) {
			global $wgMemc;
			$memcKey = wfMemcKey('ac_image_cnt', $imageName);
			$this->refs_cnt[$imageName] = $wgMemc->get( $memcKey );
			if( $this->refs_cnt[$imageName] === null ) {
				$dbr = $this->getDB();
				$this->refs_cnt[$imageName] = $dbr->selectField(
						'imagelinks',
						'count(*) as cnt',
						array('il_to' => $imageName),
						__METHOD__ );
				$wgMemc->set( $memcKey, $this->refs_cnt[$imageName], 60*60*12 );
			}
		}
		return $this->refs_cnt[$imageName];
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
			if( !$this->hasImages( $row->page_id, 20 ) ) {
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

