<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}


/**
 * @addtogroup SpecialPage
 */
class WikiFactoryPage extends SpecialPage {

	private $mWiki, $mTitle, $mDomain, $mTab;
	public $mStatuses = array( "disabled", "enabled", "redirected" );

	/**
	 * constructor
	 */
	function  __construct() {
		wfLoadExtensionMessages("WikiFactory");
		parent::__construct( "WikiFactory"  /*class*/, 'wikifactory' /*restriction*/);
	}

	/**
	 * execute
	 *
	 * main entry point
	 *
	 * @author eloy@wikia.com
	 * @access public
	 *
	 * @param string $subpage: subpage of Title
	 *
	 * @return nothing
	 */
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;
		wfLoadExtensionMessages("WikiFactory");

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( !$wgUser->isAllowed( 'wikifactory' ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'WikiFactory' );
		$this->mDomain = null;

		/**
		 * initial output
		 */
		$wgOut->setPageTitle( wfMsg('wikifactorypagetitle') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		#--- handle chagelog
		if ( $subpage === "change.log" ) {
			$oPager = new ChangeLogPager;

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"limit"     => $oPager->getForm(),
				"body"      => $oPager->getBody(),
				"nav"       => $oPager->getNavigationBar()
			));
			$wgOut->addHTML( $oTmpl->execute("changelog") );
		}
		else {
			$subpage = ( $subpage == "/" ) ? null : $subpage;
			$oWiki = $this->getWikiData( $subpage );

			if( !isset( $oWiki->city_id )) {
				$this->doWikiSelector();
			}
			else {
				$this->mWiki = $oWiki;
				$this->doWikiForm( );
			}
		}
	}

	/**
	 * getWikiData
	 *
	 * use subpage as param and try to find wiki which match criteria
	 *
	 * @access private
	 * @author eloy
	 *
	 * @param mixed $subpage:
	 *
	 * @return Database Row from city_list
	 */
	private function getWikiData( $subpage ) {
		global $wgRequest;

		$domain	=  $wgRequest->getVal( "wpCityDomain", null );
		$cityid	= $wgRequest->getVal( "cityid", null );
		$tab 	= "variables";
		if( is_null( $cityid ) && ( isset( $subpage ) || isset( $domain ) ) ) {

			/**
			 * if there is # in subpage we are switching tab
			 */
			if( strpos( $subpage, "/" ) ) {
				$parts = explode( "/", $subpage, 3 );
				if( is_array( $parts ) && sizeof( $parts ) >= 2 ) {
					$subpage = $parts[0];
					$tab = $parts[1];
				}
			}

			if( is_null( $domain ) ) {
				$domain = $subpage;
			}

			/**
			 * if there's no dot in cityname we add .wikia.com
			 * or if is only one dot (language.domain.wikia.com)
			 */
			if( sizeof(explode(".", $domain )) <= 2 && strlen( $domain ) > 0) {
				$domain = $domain.".wikia.com";
			}
			$this->mDomain = $domain;

			$cityid = WikiFactory::DomainToId( $domain );

			if( is_null( $cityid ) && is_numeric( $subpage ) ) {
				$cityid = $subpage;
			}
		}
		$this->mTab = $tab;
		if( !is_null( $cityid ) ) {
			$this->mTitle = Title::makeTitle( NS_SPECIAL, "WikiFactory/{$cityid}/{$tab}" );
		}
		return WikiFactory::getWikiByID( $cityid );
	}

	/**
	 * doWikiSelector
	 *
	 * Pager with all wikis
	 *
	 * @access private
	 * @author eloy
	 *
	 *
	 * @return nothing
	 */
	private function doWikiSelector() {
		global $wgOut;

		#--- init
		$citylist = array();
		$pager = new CityListPager;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"domain"    => $this->mDomain,
			"title"     => $this->mTitle,
			"limit"     => $pager->getForm(),
			"body"      => $pager->getBody(),
			"nav"       => $pager->getNavigationBar()
		));
		$wgOut->addHTML( $oTmpl->execute("selector") );
	}

	/**
	 * doCityForm
	 *
	 * show wiki data
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @return nothing
	 */
	public function doWikiForm() {
		global $wgOut, $wgRequest;

		$info = null;
		/**
		 * check maybe something was posted
		 */
		if( $wgRequest->wasPosted() ) {
			switch( $this->mTab ){
				case "hubs":
					$info = $this->doUpdateHubs( $wgRequest );
				break;
				case "domains":
					$info = $this->doUpdateDomains( $wgRequest );
				break;
			}
		}

		$oWikiRequest = null;
		if( class_exists( "CreateWikiForm" ) ) {
			preg_match('/http:\/\/(\w{1,})./i', $this->mWiki->city_url, $matches);
			$sRequestName = $matches[1];
			if(!empty($sRequestName)) {
				$oWikiRequest = CreateWikiForm::getRequestBy( 'request_name', $sRequestName );
				$oWikiRequest = is_object($oWikiRequest) ? $oWikiRequest : $sRequestName;
			}
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$vars = array(
			"tab"         => $this->mTab,
			"hub"         => WikiFactoryHub::getInstance(),
			"wiki"        => $this->mWiki,
			"info"        => $info,
			"title"       => $this->mTitle,
			"groups"      => WikiFactory::getGroups(),
			"domains"     => WikiFactory::getDomains( $this->mWiki->city_id ),
			"statuses" 	  => $this->mStatuses,
			"variables"   => WikiFactory::getVariables(),
			"wikiRequest" => $oWikiRequest
		);
		if( $this->mTab === "clog" ) {
			$pager = new ChangeLogPager( $this->mWiki->city_id );
			$vars[ "changelog" ] = array(
				"limit"     => $pager->getForm(),
				"body"      => $pager->getBody(),
				"nav"       => $pager->getNavigationBar()
			);
		}
		$oTmpl->set_vars( $vars );
		$wgOut->addHTML( $oTmpl->execute("form") );
	}

    /**
     * doUpdateHubs
     *
     * Store changes connected with hubs
     *
     * @access private
     * @author eloy@wikia
     *
     * @return mixed	info when change, null when not changed
     */
	private function doUpdateHubs( &$request ) {
		$cat_id = $request->getVal( "wpWikiCategory", null );
		if( !is_null( $cat_id ) ){
			$hub = WikiFactoryHub::getInstance();
			$hub->setCategory( $this->mWiki->city_id, $cat_id );

	                $categories = $hub->getCategories();

	                return Wikia::successmsg( "Hub is now set to: ". $categories[ $cat_id ] );
		} else {
			return Wikia::errormsg( "Hub was not changed.");
		}
	}

    /**
     * doUpdateDomains
     *
     * Store changes connected with domains
     *
     * @access private
     * @author eloy@wikia
     *
     * @return mixed	info when change, null when not changed
     */
	private function doUpdateDomains( &$request ) {
		$action = $request->getText( "wpAction", null );
		$message = "";
		switch( $action ) {
			case "status":
				$status = $request->getVal( "wpWikiStatus", 0 );
				WikiFactory::setPublicStatus( $status, $this->mWiki->city_id );
				$this->mWiki->city_public = $status;
				$message = "Status of this wiki was changed to " . $this->mStatuses[ $status ];
			break;
		}
		return Wikia::successmsg( $message );
	}

	/**
	 * showTab
	 *
	 * helper function, CSS/HTML code for tab
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 * @access public
	 * @static
	 *
	 * @param string	$tab		current tab
	 * @param string 	$active		active tab
	 * @param integer	$city_id	wiki id in city_list table
	 *
	 * @return string HTML/CSS code
	 */
	static public function showTab( $tab, $active, $city_id ) {

		$title = Title::makeTitle( NS_SPECIAL, "WikiFactory/{$city_id}/{$tab}" );

		if( $tab === $active ) {
			return wfMsg( "wikifactory-label-{$tab}" );
		}
		else {
			$attribs = array(
				"href" => $title->getFullUrl()
			);
			return wfElement( "a", $attribs, wfMsg( "wikifactory-label-{$tab}" ) );
		}
	}
}


class CityListPager extends TablePager {
    var $mFieldNames = null;
    var $mMessages = array();
    var $mQueryConds = array();

    #--- constructor
    function __construct() {
        global $wgRequest, $wgMiserMode;
        if ( $wgRequest->getText( 'sort', 'img_date' ) == 'img_date' ) {
            $this->mDefaultDirection = true;
        } else {
            $this->mDefaultDirection = false;
        }
        $search = $wgRequest->getText( 'ilsearch' );
        if ( $search != '' && !$wgMiserMode ) {
            $nt = Title::newFromUrl( $search );
            if( $nt ) {
                $dbr = wfGetDB( DB_SLAVE );
                $m = $dbr->strencode( strtolower( $nt->getDBkey() ) );
                $m = str_replace( "%", "\\%", $m );
                $m = str_replace( "_", "\\_", $m );
                $this->mQueryConds = "";
             }
        }
        parent::__construct();
    }

    function getFieldNames() {
        if ( !$this->mFieldNames ) {
            $this->mFieldNames = array(
                'city_id' => wfMsg( "wf_city_id" ),
                'city_url' => wfMsg( "wf_city_url" ),
                'city_lang' => wfMsg( "wf_city_lang" ),
					 'cat_name' => wfMsg( "wf_cat_name" ),
                'city_public' => wfMsg( "wf_city_public" ),
                'city_title' => wfMsg( "wf_city_title" ),
                'city_created' => wfMsg( "wf_city_created" ),
            );
        }
        return $this->mFieldNames;
    }

    function isFieldSortable( $field ) {
        static $sortable = array( "city_url", "city_public", "city_id", "city_lang", "cat_name" );
        return in_array( $field, $sortable );
    }

    function getDefaultSort() {
        return 'city_id';
    }

    function formatValue( $field, $value ) {
        global $wgLang;
        switch ( $field ) {
            case "city_url":
                $title = Title::makeTitle( NS_SPECIAL, 'WikiFactory' );
                preg_match("/http:\/\/([^\/]+)/", $value, $match );
                $link = sprintf("%s/%s", $title->getFullUrl(), $this->mCurrentRow->city_id);
                return sprintf("<a href=\"%s\">%s</a>", $link, $value);
                break;
            case "city_public":
                switch($value) {
                    case 0:
                        return "<span style=\"color:#fe0000;font-weight:bold;font-size:small;\">disabled</span>";
                        break;
                    case 1:
                        return "<span style=\"color:darkgreen;font-weight:bold;font-size:small;\">enabled</span>";
                        break;
                    case 2:
                        return "<span style=\"color: #0000fe;font-weight:bold;font-size:small\">redirected</span>";
                        break;
                }
                break;
            default: return $value;
        }
    }

    /**
     * getQueryInfo
     *
     * get data needed for creating query
     */
    function getQueryInfo()
    {
        $fields = $this->getFieldNames();
        unset( $fields['links'] );
        unset($fields['city_id']); // quick hack, city_cat* aint got unique column names )-:
        $fields = array_keys( $fields );
        $fields[] = wfSharedTable("city_list").".city_id"; // quick hack, city_cat* aint got unique column names )-:

			$query = array(
				"tables" => array(
					wfSharedTable("city_list"),
					wfSharedTable("city_cat_mapping"),
					wfSharedTable("city_cats"),
				),
				"fields" => $fields,
				"conds" => array(
					wfSharedTable("city_list").".city_id = ".
					wfSharedTable("city_cat_mapping").".city_id",
					wfSharedTable("city_cat_mapping").".cat_id = ".
					wfSharedTable("city_cats").".cat_id",
				)
			);

			return $query;
    }

    function getForm() {
        global $wgRequest, $wgMiserMode;
        $url = $this->getTitle()->escapeLocalURL();
        $search = $wgRequest->getText( 'ilsearch' );
        $s = "<form method=\"get\" action=\"$url\">\n" .
        wfMsgHtml( 'table_pager_limit', $this->getLimitSelect() );
        if ( !$wgMiserMode ) {
            $s .= "<br/>\n" .
            Xml::inputLabel( wfMsg( 'imagelist_search_for' ), 'ilsearch', 'mw-ilsearch', 20, $search );
        }
        $s .= " " . Xml::submitButton( wfMsg( 'table_pager_limit_submit' ) ) ." \n" .
            $this->getHiddenFields( array( 'limit', 'ilsearch' ) ) .
            "</form>\n";
        return $s;
    }
}

/**
 * Changelog Pager
 */
class ChangeLogPager extends TablePager {
	public $mFieldNames = null;
	public $mMessages = array();
	public $mQueryConds = array();
	public $mTitle;
	public $mWikiId;

	/**
	 * __construct
	 *
	 * Public constructor with standard initializations
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param integer $wiki_id	wiki identifier in wiki factory
	 *
	 */
	function __construct( $wiki_id = false ) {
		if( is_numeric( $wiki_id ) ) {
			$this->mTitle = Title::makeTitle( NS_SPECIAL, "WikiFactory/{$wiki_id}/clog" );
			$this->mWikiId = $wiki_id;
		}
		else {
			$this->mTitle = Title::makeTitle( NS_SPECIAL, "WikiFactory/change.log" );
			$this->mWikiId = false;
		}
		$this->mDefaultDirection = true;
		parent::__construct();
	}

	/**
	 * getTitle
	 *
	 * @author eloy@wikia.com
	 * @return Title object
     */
	function getTitle() {
		return $this->mTitle;
	}

	/**
	 * getFieldNames
	 *
	 * @author eloy@wikia.com
	 * @return Array with column names
	 */
	public function getFieldNames() {
		if( !$this->mFieldNames ) {
			$this->mFieldNames = array();
			if( ! $this->mWikiId ) {
				$this->mFieldNames["city_url"]      = "Wiki";
			}
			$this->mFieldNames["cv_name"]       = "Variable name";
			$this->mFieldNames["cv_value_old"]  = "Changed value";
			$this->mFieldNames["cv_timestamp"]  = "Changed";
			$this->mFieldNames["cv_user_id"]    = "Who";
		}

		return $this->mFieldNames;
	}

	/**
	 * isFieldSortable
	 *
	 * @author eloy@wikia.com
	 * @param string $field: field name
	 *
	 * @return boolean: flag if $field is sortable of not
     */
	public function isFieldSortable( $field ) {
		static $aSortable = array( "city_url", "cv_name", "cv_timestamp", "cv_user_id" );
		return in_array( $field, $aSortable );
	}

	/**
	 * formatValue
	 *
	 * field formatter
	 *
	 * @param string $field: field name
	 * @param mixed $value: field value
	 *
	 * @author eloy@wikia.com
	 *
	 * @return string: formated table field
	 */
	function formatValue( $field, $value ) {
		switch ($field) {
			case "city_url":
				preg_match("/http:\/\/([\w\.\-]+)\//", $value, $matches );
				$sRetval = str_ireplace(".wikia.com", "", $matches[1]);
				return $sRetval;
				break;

			case "cv_value_old":
				return var_export( unserialize( $value ), 1);
				break;

			case "cv_timestamp":
				return wfTimestamp( TS_EXIF, $value );
				break;

			case "cv_user_id":
				$oUser = User::newFromId( $value );
				$oUser->load();
				return sprintf("<a href=\"%s\">%s</a>", $oUser->getUserPage()->getLocalUrl(), $oUser->getName());
				break;

			default:
				return $value;
		}
	}

	/**
	 * getDefaultSort
	 *
	 * get default field for sorting
	 *
	 * @author eloy@wikia.com
	 *
	 * @return string: table field
	 */
	function getDefaultSort() {
		$this->mDefaultDirection = true;
		return "cv_timestamp";
	}

	/**
	 * getQueryInfo
	 *
	 * get default field for sorting
	 *
	 * @author eloy@wikia.com
	 *
	 * @return array: query info
	 */
	function getQueryInfo() {
		$query = array(
			"tables" => array(
				wfSharedTable("city_variables_log"),
				wfSharedTable("city_list"),
				wfSharedTable("city_variables_pool")
			),
			"fields" => array( "*" ),
			"conds" => array(
				wfSharedTable("city_variables_log").".cv_variable_id = ".
				wfSharedTable("city_variables_pool").".cv_id",
				wfSharedTable("city_list").".city_id = ".
				wfSharedTable("city_variables_log").".cv_city_id"
			)
		);

		if( $this->mWikiId ) {
			$query[ "conds" ][] = wfSharedTable("city_list").".city_id = " . $this->mWikiId;
		}
		return $query;
	}

	/**
	 * getForm
	 *
	 * get form definition
	 *
	 * @author eloy@wikia.com
	 *
	 * @return string: empty
	 */
	function getForm() {
		return "";
	}
}
