<?php

/**
 * WikiaApiQueryProblemReports
 *
 * API for ProblemReports extension
 * Lists, adds, updates and removes problem reports
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 *
 */

class WikiaApiQueryProblemReports extends WikiaApiQuery {

    /**
     * constructor
     */
    public function __construct($query, $moduleName) {
        parent :: __construct($query, $moduleName);
    }

    /**
     * main function
     */
    public function execute() {

		// route query to one of methods below
		switch ($this->getActionName())
		{
			case parent::INSERT:
				$this->executeInsert();
				break;

			case parent::UPDATE:
				$this->executeUpdate();
				break;

			case parent::DELETE:
				$this->executeDelete();
				break;

			default:
				$this->executeQuery();
				break;
		}
    }

    /**
     * Gets a default slave database connection object, override base function
     */
	public function getDB() {
		global  $wgExternalSharedDB;
		if (!isset ($this->mSlaveDB)) {
			$this->profileDBIn();
			$this->mSlaveDB = wfGetDB(DB_SLAVE,'api',  $wgExternalSharedDB );
			$this->profileDBOut();
		}
		return $this->mSlaveDB;
	}


    private function executeQuery() {

		wfProfileIn(__METHOD__);

		global $wgServerName, $wgExternalSharedDB;

 		$params  = $this->getInitialParams();

		// validate given token
		$isTokenValid = ( !empty($params['token']) && WikiaApiQueryProblemReports::getToken($wgServerName) == $params['token'] );

		// database instance
		$db = $this->getDB();

		// build query
		$this->addTables( array( 'problem_reports', 'city_list' ) );
		$this->addFields( array
			(
				'problem_reports.pr_id as id',
				'problem_reports.pr_city_id as city_id',
				'problem_reports.pr_title as title',
				'problem_reports.pr_ns as ns',
				'problem_reports.pr_server as server',
				'problem_reports.pr_anon_reporter as anon',
				'problem_reports.pr_reporter as reporter',
				'problem_reports.pr_email as email',
				'problem_reports.pr_browser as browser',
				'problem_reports.pr_summary as summary',
				'problem_reports.pr_ip as ip',
				'problem_reports.pr_cat as problem',
				'problem_reports.pr_status as status',
				'problem_reports.pr_date as date',

				'city_list.city_lang as lang',
				'city_list.city_dbname as db'
			)
		);

		// get info about wikis language
		$this->addWhere('problem_reports.pr_city_id = city_list.city_id');

		// just show one problem report (we have ID)
		if (intval($params['id'])) {
			$this->addWhereFld( 'pr_id',  $params['id'] );
			$this->addOption( 'LIMIT', 1 );
		}
		else {
			// select from given city only?
			if (intval($params['showall']) != 1) {
				$this->addWhereFld( 'pr_city_id',  !empty($params['wikia']) ? intval($params['wikia']) : self::getCityID()  );
			}

			// filter by language?
			if ( !empty($params['lang']) ) {
				$this->addWhereFld( 'city_lang', $params['lang'] );
			}

			// archived?
			if ($params['archived'] == 1) {
				$this->addWhere( 'pr_status in (1,2)' );
			}
			// staff?
			else if ($params['staff'] == 1) {
				$this->addWhereFld('pr_status', 3);
			}
			else {
				$this->addWhereFld('pr_status', 0);
			}

			// problem type
			if (isset($params['type']) && $params['type'] > -1) {
				$this->addWhereFld( 'pr_cat', (int) $params['type'] );
			}

			$this->addOption( 'LIMIT', is_numeric($params['limit']) ? $params['limit'] : 50 );

			$this->addOption( 'OFFSET', is_numeric($params['offset']) ? $params['offset'] : 0 );

			$this->addOption( 'ORDER BY', 'id DESC' );
		}

		// build results
		$data = array();
		$res = $this->select(__METHOD__);

		while ($row = $db->fetchObject($res))
		{
			$data[$row->id] = array
			(
				'id'		=> $row->id,
				'city'		=> $row->city_id,
				'lang'      => $row->lang,
				'server'	=> $row->server,
				'db'        => $row->db,
				'anon'		=> (int) ($row->anon == 1),
				'reporter' 	=> $row->reporter,
				'email' 	=> $isTokenValid ? $row->email : '',
				'ip'	 	=> $isTokenValid ? long2ip($row->ip) : '',
				'browser'       => $row->browser,

				'type'		=> $row->problem,
				'status'	=> $row->status,
				'staff'		=> (int) ($row->status == 3),
				'archived'  => (int) (($row->status == 1) || ($row->status == 2)),

				'date'		=> date('YmdHis', strtotime($row->date) - (int) date('Z') ), /* return UTC time (#2214) */
				'ns'        => $row->ns,
				'title'     => $row->title,
				'summary'   => $row->summary,
			);

			ApiResult :: setContent( $data[$row->id], "" );
		}

		$db->freeResult($res);

		// count all reports in current view
		$count = $this->countAllReports($params);

		$this->getResult()->setIndexedTagName($data, 'report');
		$this->getResult()->addValue('query', $this->getModuleName(), $data);
		$this->getResult()->addValue('query', 'reports', intval($count) );

		wfProfileOut(__METHOD__);
	}


    private function executeInsert() {

		wfProfileIn(__METHOD__);

		global $wgServer, $wgServerName, $wgExternalSharedDB;

		$params  = $this->getInitialParams();

		//print_pre($params);

		// check params list
		if ( !$this->isInt($params['type']) || !$this->isInt($params['ns']) || empty($params['summary']) || empty($params['title']) ) {
			wfProfileOut(__METHOD__);
			throw new WikiaApiQueryError(1, 'One of expected parameters is empty');
		}

		// validate given token
		$isTokenValid = ( !empty($params['token']) && self::getToken($params['title']) == $params['token'] );

		if (!$isTokenValid) {
			wfProfileOut(__METHOD__);
			throw new WikiaApiQueryError(2, 'Token is not valid');
		}

		// add row to problem_reports table (use DB_MASTER !!!)
		$dbw =& wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		$values = array(
			'pr_cat'     => $params['type'],
			'pr_summary' => $params['summary'],
			'pr_ns'      => $params['ns'],
			'pr_title'   => $params['title'],
			'pr_city_id' => self::getCityID(),
			'pr_server'  => $wgServer, 				// wikia hostname like 'muppet.wikia.com' or 'fp012.sjc.wikia-inc.com'
			'pr_anon_reporter' => $this->isUserAnon() ? 1 : 0, 	// is reporting user logged in
			'pr_reporter'=> $this->isUserAnon() ? $params['reporter'] : $this->getUser()->getName(),
			'pr_ip'      => ip2long(wfGetIP()), 		// save some bytes
			'pr_email'   => $params['email'],
			'pr_browser' => $params['browser'],
			'pr_date'    => date('Y-m-d H:i:s'),
			'pr_status'  => 0 					// initial status: awaits
		);

		//print_pre($values);

		$dbw->begin();
		$dbw->insert( 'problem_reports', $values, __METHOD__ );
		$insertId = (int) $dbw->insertId();
		$dbw->commit();

		// log if succesfull
		if ($insertId > 0)
		{
			// use local database for recentcnages (RT #21029)
			global $wgDBname;
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->selectDB($wgDBname);

			// add the log entry for problem reports
			$log = new LogPage('pr_rep_log', true); // true: also add entry to Special:Recentchanges

			$reportedTitle = Title::newFromText($params['title'], NS_MAIN);
			$desc = 'reported a problem';

			$log->addEntry('prl_rep', $reportedTitle, /*$data['summary']*/ '', array
			(
				$reportedTitle->getFullURL(),
				$insertId
			) );

			$dbw->commit();

			// ok!
			wfDebug('ProblemReports: report #'.$insertId." reported and log added to Special:Log...\n");
		}
		else
		{
			wfDebug('ProblemReports: report #'.$insertId." NOT reported!\n");

			wfProfileOut(__METHOD__);

			throw new WikiaApiQueryError(0);
		}

		// return added report ID
		$this->getResult()->addValue('results', 'report', array('id' => $insertId));

		wfProfileOut(__METHOD__);
    }







    private function executeUpdate() {

		wfProfileIn(__METHOD__);

		global $wgServer, $wgServerName, $wgDBname, $wgExternalSharedDB;

		$params  = $this->getInitialParams();

		//print_pre($params);

		// check user permission to update reports
		if ( !self::userCanDoActions() ) {
			wfProfileOut(__METHOD__);
			throw new WikiaApiQueryError(2, 'To update report status you need to be in sysop or staff group');
		}

		// check params list
		if ( !$this->isInt($params['report']) || (isset($params['status']) && isset($params['type'])) ) {
			wfProfileOut(__METHOD__);
			throw new WikiaApiQueryError(1, 'One of expected parameters is empty');
		}

		// validate given token
		$isTokenValid = ( !empty($params['token']) && self::getToken($params['report']) == $params['token'] );

		if (!$isTokenValid) {
			wfProfileOut(__METHOD__);
			throw new WikiaApiQueryError(2, 'Token is not valid');
		}


		// can you update cross-wiki reports?
		$sql_where = array();

		if ( self::userCanDoCrossWikiActions() ) {
			$sql_where['pr_id'] = intval($params['report']);	// yes, you can update all reports
		}
		else if ( self::userCanDoActions() ) {
			$sql_where['pr_id'] = intval($params['report']);
			$sql_where['pr_city_id'] = self::getCityId(); 	// no, you can only update reports from your wiki
		}
		else {
			wfProfileOut(__METHOD__);
			throw new WikiaApiQueryError(3, 'Action is not allowed');
		}

		// update row in problem_reports table (use DB_MASTER !!!)
		$dbw =& wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		// are we updating type of report?
		$updatingType = is_numeric($params['type']);

		if ( $updatingType ) {
			$dbw->update( 'problem_reports', array('pr_cat' => intval($params['type'])), $sql_where, __METHOD__);
		}
		else {
			$dbw->update( 'problem_reports', array('pr_status' => intval($params['status'])), $sql_where, __METHOD__);
		}


		$ret = $dbw->affectedRows() > 0; // did we actually update any row?
		$dbw->commit();


		if ($ret) {
			// create title object of reported page
			$report = self::getReportById($params['report']);
			$reportedTitle = Title::newFromText($report['title'], NS_MAIN);

			// add the log entry for problem reports
			$log = new LogPage('pr_rep_log', true); // true: also add entry to Special:Recentchanges

			// tricky part ;)
			//update recent changes and logger table of wiki report is coming from (#2466)
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->selectDB( $report['db'] );

			wfDebug('ProblemReports: selecting "'.$report['db']."\" DB...\n");

			$log->addEntry($updatingType ? 'prl_typ' : 'prl_chn', $reportedTitle, '', array
			(
				$reportedTitle, // dummy title
				$params['report'],
				$updatingType ? $params['type'] : $params['status']
			) );

			$dbw->immediateCommit(); // do commit (MW 'forgets' to do it)

			// return to DB of current wiki
			$dbw->selectDB( $wgDBname );

			// ok!
			wfDebug('ProblemReports: ' . ($updatingType ? 'type' : 'status') . ' of report #'.$params['report']." updated and log added to Special:Log...\n");
		}
		else {
			//throw new WikiaApiQueryError(0);
		}

		// return info
		$this->getResult()->addValue('results', 'report', array('id' => $params['report'], 'status' => $params['status'], 'type' => $params['type']));

		wfProfileOut(__METHOD__);
    }


    private function executeDelete() {

		wfProfileIn(__METHOD__);

		global $wgServer, $wgServerName, $wgDBname, $wgExternalSharedDB;

		$params  = $this->getInitialParams();

		// check user permissions
		if ( !self::userCanRemove() ) {
			wfProfileOut(__METHOD__);
			throw new WikiaApiQueryError(2, 'To remove report you need to be in staff group');
		}

		// check params list
		if ( !$this->isInt($params['report']) ) {
			wfProfileOut(__METHOD__);
			throw new WikiaApiQueryError(1, 'One of expected parameters is empty');
		}

		// validate given token
		$isTokenValid = ( !empty($params['token']) && self::getToken($params['report']) == $params['token'] );

		if (!$isTokenValid) {
			wfProfileOut(__METHOD__);
			throw new WikiaApiQueryError(2, 'Token is not valid');
		}

		// create title object of reported page
		$report = self::getReportById($params['report']);
		$reportedTitle = Title::newFromText($report['title'], NS_MAIN);

		// delete row from problem_reports table (use DB_MASTER !!!)
		$dbw =& wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		$dbw->begin();
		$dbw->delete( 'problem_reports', array('pr_id' => intval($params['report'])), __METHOD__);
		$dbw->commit();

		// tricky part ;)
		//update recent changes and logger table of wiki report is coming from (#2466)
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->selectDB( $report['db'] );

		wfDebug('ProblemReports: selecting "'.$report['db']."\" DB...\n");


		// add the log entry for problem reports
		$log = new LogPage('pr_rep_log', true); // true: also add entry to Special:Recentchanges

		$log->addEntry('prl_rem', $reportedTitle, '', array
		(
			$reportedTitle,
			$params['report']
		) );

		$dbw->commit();

		// return to DB of current wiki
		$dbw->selectDB( $wgDBname );

		// ok!
		wfDebug('ProblemReports: report #'.$params['report']." removed by staff member and log added to Special:Log...\n");

		// return info
		$this->getResult()->addValue('results', 'report', array('id' => $params['report']) );

		wfProfileOut(__METHOD__);
    }








    public function getVersion() {
        return __CLASS__ . ': $Id: ProblemReportsAPI.php Macbre $';
    }



    //
    // query
    //



    public function getQueryDescription() {
        return 'Get problem reports list';
    }

    public function getAllowedQueryParams() {
        return array (
            'wikia' => array (
                ApiBase :: PARAM_TYPE => 'integer'
            ),
			'showall' => array (
                ApiBase :: PARAM_TYPE => 'boolean'
            ),
            'limit' => array (
                ApiBase :: PARAM_TYPE => 'integer'
            ),
			'offset' => array (
                ApiBase :: PARAM_TYPE => 'integer'
            ),
    	    'type' => array (
                ApiBase :: PARAM_TYPE => 'integer'
            ),
			'lang' => array (
                ApiBase :: PARAM_TYPE => 'string'
            ),
			'staff' => array (
                ApiBase :: PARAM_TYPE => 'boolean'
            ),
			'archived' => array (
                ApiBase :: PARAM_TYPE => 'boolean'
            ),
			'id' => array (
                ApiBase :: PARAM_TYPE => 'integer'
            ),
			'token' => array (
                ApiBase :: PARAM_TYPE => 'string'
            ),
        );
    }

    public function getParamQueryDescription() {
        return array (
            'wikia'    => 'Wikia ID from which show problem reports (default 0 - shows from current wikia)',
			'showall'  => 'Shows reports from all wikis (default 0)',
            'limit'    => 'Limit of problem reports to show (default 50)',
			'offset'   => 'Offset of problem reports to show',
            'type'     => 'Type of problems to show (default -1 shows all)',
			'lang'     => 'Filter by language of wikis to get reports from',
			'staff'    => 'Show only problems which need staff help',
			'archived' => 'Show only archived problems',
			'id'       => 'Shows just problem report with given ID',
			'token'    => 'Used for internal communication'
        );
    }

    public function getQueryExamples() {
        return array (
            'api.php?action=query&list=problemreports',
            'api.php?action=query&list=problemreports&wklimit=100&wktype=1',
			'api.php?action=query&list=problemreports&wkstaff=1',
			'api.php?action=query&list=problemreports&wkshowall=1',
			'api.php?action=query&list=problemreports&wkshowall=1&wklang=pl'
		);
    }






    //
    // insert
    //

    public function getInsDescription() {
        return 'Adds problem report';
    }

    public function getAllowedInsParams() {
        return array (
			'type' => array (
                ApiBase :: PARAM_TYPE => 'integer'
            ),
    	    'ns' => array (
                ApiBase :: PARAM_TYPE => 'integer'
            ),
			'title' => array (
                ApiBase :: PARAM_TYPE => 'string'
            ),
			'summary' => array (
                ApiBase :: PARAM_TYPE => 'string'
            ),
			'reporter' => array (
                ApiBase :: PARAM_TYPE => 'string'
            ),
			'email' => array (
                ApiBase :: PARAM_TYPE => 'string'
			),
			'browser' => array (
                ApiBase :: PARAM_TYPE => 'string'
                        ),
			'token' => array (
                ApiBase :: PARAM_TYPE => 'string'
            ),
        );
    }

    public function getParamInsDescription() {
        return array (
            'type'     => 'Type of reported problem <0; 4>',
			'ns'       => 'Namespace of reported page',
			'title'    => 'Title of reported page',
			'summary'  => 'Reported problem short description',
			'reporter' => 'Name of user reporting problem',
			'email'    => 'Email (if given by reporter)',
			'browser'  => 'Browser used by reporter',
			'token'    => 'Used for query validation'
        );
    }

    public function getInsExamples() {
        return array (
            'api.php?action=insert&wklist=problemreports&wktype=1&wkns=0&wktitle=Main_Page&wksummary=foo%20bar&wkreporter=User123&wkemail=foo%40bar.pl&wktoken=xxxxx'
	    );
    }




    //
    // update
    //

    public function getUpdDescription() {
        return 'Updates problem report status or type (staff or sysop only)';
    }

    public function getAllowedUpdParams() {
        return array (
			'status'=>  array (
					ApiBase :: PARAM_TYPE => 'integer'
				),
			'type' =>  array (
					ApiBase :: PARAM_TYPE => 'integer'
				),
			'report' =>  array (
					ApiBase :: PARAM_TYPE => 'integer'
				),
			'token' => array (
					ApiBase :: PARAM_TYPE => 'string'
				),
        );
    }

    public function getParamUpdDescription() {
        return array (
			'report'   => 'Problem report id',
            'status'   => 'New problem status',
			'type'     => 'New problem type',
			'token'    => 'Used for query validation'
        );
    }

    public function getUpdExamples() {
        return array (
            'api.php?action=update&list=problemreports&wkreport=341&wkstatus=5&wktoken=xxxxx',
			'api.php?action=update&list=problemreports&wkreport=459&wktype=2&wktoken=xxxxx'
	    );
    }



    //
    // delete
    //

    public function getDelDescription() {
        return 'Removes problem report (staff only)';
    }

    public function getAllowedDelParams() {
        return array (
	    'report' =>  array (
                ApiBase :: PARAM_TYPE => 'integer'
            ),
	    'token' => array (
                ApiBase :: PARAM_TYPE => 'string'
            ),
        );
    }

    public function getParamDelDescription() {
        return array (
	    'report'   => 'Problem report id',
	    'token'    => 'Used for query validation'
        );
    }

    public function getDelExamples() {
        return array (
            'api.php?action=delete&wklist=problemreports&wkreport=341&wktoken=xxxxx'
	    );
    }





    // let's count all reports within given criteria
    private function countAllReports($params) {

		wfProfileIn(__METHOD__);

		global $wgExternalSharedDB;

		$db =& wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$tables = array('problem_reports');

		$sql_wheres = array();

		// select from given city only?
		if ( empty($params['showall']) ) {
			$sql_wheres ['pr_city_id'] = !empty($params['wikia']) ? (int) $params['wikia'] : self::getCityID();
		}

		// archived?
		if ( !empty($params['archived']) ) {
			$sql_wheres[] = 'pr_status in (1,2)';
		}
		// staff?
		else if ( !empty($params['staff']) ) {
			$sql_wheres['pr_status'] = 3;
		}
		else {
			$sql_wheres['pr_status'] = 0;
		}

		// problem type
		if (isset($params['type']) && $params['type'] > -1) {
			$sql_wheres['pr_cat'] = intval($params['type']);
		}

		// filter by language
		if ( !empty($params['lang']) ) {
			$tables[] = 'city_list';

			$sql_wheres[] = 'problem_reports.pr_city_id = city_list.city_id';
			$sql_wheres['city_lang'] = $params['lang'];
		}

		//print_pre($params);print_pre($sql_wheres);

		// make query
		$count = $db->selectField($tables, 'count(*) as cnt', $sql_wheres, __METHOD__);

		wfProfileOut(__METHOD__);

		return $count;
	}

	// check whether provided problem description contains spam
	static function checkForSpam($content)
	{
		// empty content cannot contain spam
		if ( empty($content) ) {
			return false;
		}

		// macbre: use dedicated hook for this check (change related to release of Phalanx)
		if ( !wfRunHooks('ProblemReportsContentCheck', array($content)) ) {
			wfDebug(__METHOD__ . ": spam found in report description\n");
			return true;
		}

		// TODO: temporary check for Phalanx (don't perform additional filtering when enabled)
		global $wgEnablePhalanxExt;
		if (!empty($wgEnablePhalanxExt)) {
			return false;
		}

		wfProfileIn(__METHOD__);

		$spamObj = wfSpamBlacklistObject();
		$title = new Title();

		$result = $spamObj->filter($title, $content, 0, false);

		wfProfileOut( __METHOD__ );

		return $result;
	}


    // returns token for internal extension communication
    static function getToken($param) {
		global $wgProblemReportsSecret;
		return substr( sha1($wgProblemReportsSecret . '::' . $param), 6, 10);
    }

    //
    // check user permissions (refs #1915, #1970)
    //

    // user can do actions: fix, reopen, close problem reports (only local wiki)
    static function userCanDoActions() {
        global $wgUser;

		return $wgUser->isAllowed('problemreports_action') || self::userCanDoCrossWikiActions();
    }

    // user is staff member
    static function isStaff() {
        global $wgUser;
		return in_array( 'staff', $wgUser->getEffectiveGroups() );
    }

    // user can do actions: fix, reopen, close problem reports (cross-wiki)
    static function userCanDoCrossWikiActions() {
		global $wgUser;

		return $wgUser->isAllowed('problemreports_global');
    }

    // use can remove problem reports
    static function userCanRemove() {
    	global $wgUser;
		return in_array( 'staff', $wgUser->getEffectiveGroups() );
    }

	// formatting of log messages
    static function makeActionText( $key, $title, $params, $skin )
    {
		global $wgLogActions, $wgOut, $wgTitle;

		wfProfileIn(__METHOD__);

		$problemTypes = array (
			wfMsg('pr_what_problem_spam_short'),
			wfMsg('pr_what_problem_vandalised_short'),
			wfMsg('pr_what_problem_incorrect_content_short'),
			wfMsg('pr_what_problem_software_bug_short'),
			wfMsg('pr_what_problem_other_short'),
		);

		// additional information
		switch($key) {
			// problem is reported
			case 'pr_rep_log/prl_rep':
				// dirty hack
				if (empty($params[1])) {
					$params = explode("\n", $params[0]);
				}

				$titleLink = '[['.$title->getPrefixedText().']]';

				$rt = wfMsg( $wgLogActions[$key], $titleLink, '[[Special:ProblemReports/'.$params[1].'|#'.$params[1].']]' );
				break;

			// problem reports status is changed
			case 'pr_rep_log/prl_chn':
				// dirty hack
				if (empty($params[1])) {
					$params = explode("\n", $params[0]);
				}

				$rt = wfMsg( $wgLogActions[$key], '[[Special:ProblemReports/'.$params[1].'|#'.$params[1].']]', ucfirst(wfMsg('pr_status_'.$params[2])) );
				break;

			// problem reports type is changed
			case 'pr_rep_log/prl_typ':
				$rt = wfMsg( $wgLogActions[$key], '[[Special:ProblemReports/'.$params[1].'|#'.$params[1].']]', $problemTypes[$params[2]] );
				break;

			// problem is removed
			case 'pr_rep_log/prl_rem':
				$rt = wfMsg( $wgLogActions[$key], '[[Special:ProblemReports/'.$params[1].'|#'.$params[1].']]' );
				break;

			// email is sent
			case 'pr_rep_log/prl_eml':
				$rt = wfMsg( $wgLogActions[$key], '[[User:'.$params[1].'|'.$params[1].']]', $params[2], '[[Special:ProblemReports/'.$params[3].'|#'.$params[3].']]' );
				break;
		}

		// parse text for pages using LogViewer class
		if ($skin != NULL) {
		    $rt = substr($wgOut->parse($rt), 3, -4);
		}

		wfProfileOut(__METHOD__);

		return $rt;
    }

    // get problem report data from API
    static function getReportById( $id ) {

		wfProfileIn(__METHOD__);

		global $wgServerName;

		$apiCall = array (
			'wkid'	 	=> $id,
			'wktoken'	=> WikiaApiQueryProblemReports::getToken($wgServerName),
			'action'  	=> 'query',
			'list'    	=> 'problemreports'
		);

		$FauxRequest = new FauxRequest($apiCall);
		$api = new ApiMain($FauxRequest);
		$api->execute();
		$data =& $api->GetResultData();

		$report = is_array($data['query']) ? $data['query']['problemreports'][$id] : false;

		wfProfileOut(__METHOD__);

		return $report;
    }

	// get cityID
	static function getCityID() {
		global $wgDBname, $wgCityId;

		return intval($wgCityId) ? $wgCityId : WikiFactory::DBtoID($wgDBname);
	}

	// get wiki URL by cityID
	static function getCityURL( $cityID ) {
		$data = WikiFactory::getWikiByID( $cityID );

		if ( !empty($data->city_url) ) {
			return substr($data->city_url, 0, -1);
		}
		else {
			return false;
		}
	}

	// get wiki sitename by cityID
	static function getCitySitename( $cityID ) {
		$data = WikiFactory::getWikiByID( $cityID );

                if ( !empty($data->city_title) ) {
                        return $data->city_title;
                }
                else {
                        return false;
                }
	}
};
