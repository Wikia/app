<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 */

#--- Add messages
global $wgMessageCache, $wgCustomizeWikiMessages;
foreach( $wgCustomizeWikiMessages as $key => $value ) {
    $wgMessageCache->addMessages( $wgCustomizeWikiMessages[$key], $key );
}

/**
 * @addtogroup SpecialPage
 */
class CustomizeWikiPage extends SpecialPage {

    private $mTitle;
    private $mAction;
    private $mSubpage;
    private $mModule;
    private $mPosted = false;

    public static $mModuleList;

    /**
     * constructor
     *
     * @access public
     * @author eloy@wikia
     */
    public function __construct()
    {
        global $wgWikiaCustomizeModules;

        parent::__construct( "CustomizeWiki"  /*class*/, 'customizewiki' /*restriction*/);
        self::$mModuleList = $wgWikiaCustomizeModules;
    }

    /**
     * execute
     *
     * @access public
     * @author eloy@wikia
     */

    public function execute($subpage)
    {
        global $wgUser, $wgOut, $wgRequest;

        if ( $wgUser->isBlocked() ) {
            $wgOut->blockedPage();
            return;
        }
        if ( wfReadOnly() ) {
            $wgOut->readOnlyPage();
            return;
        }
        if ( !$wgUser->isAllowed( 'customizewiki' ) ) {
            $this->displayRestrictionError();
            return;
        }

        $wgOut->setPageTitle( wfMsg('customizewiki_title') );
        $wgOut->setRobotpolicy( 'noindex,nofollow' );
        $wgOut->setArticleRelated( false );
        
        // macbre: load CSS created by Christian
        global $wgStylePath;
        
        $wgOut->addScript("\n\n".'<link rel="stylesheet" type="text/css" href="'.$wgStylePath.'/../extensions/wikia/CustomizeWiki/css/main.css" />');
        //$wgOut->addScript('<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="'.$wgStylePath.'/../extensions/wikia/CustomizeWiki/css/main_ie.css" /><![endif]-->');


        $this->mTitle = Title::makeTitle( NS_SPECIAL, "CustomizeWiki" );
        $this->mSubpage = $subpage;
        if ( $subpage == "tabview") {
            return $wgOut->addHTML( $this->allTogetherNow() );
        }
        $sModule = $wgRequest->getVal("module", null); #--- from url
        if ( is_null($sModule) ) {
            $sModule = $wgRequest->getVal("wpModule", null); #--- from submit
        }
        $this->mModule = self::ModuleByName( $sModule );

        if ($wgRequest->wasPosted()) {

            #--- submit data
            #--- if submit was successfull we go to next module
            $oResponse = $this->mModule->submit( $wgRequest );
            $_SESSION["customizewiki_message"] = $oResponse;
            if ( $oResponse->status === true ) {

                #--- redirect to next step
                $oNext = self::nextModule( $this->mModule );
                if ( is_null( $oNext ) ) {
                    #--- last module, redirect to main page
                    $wgOut->redirect("/?action=purge");
                    return;
                }
                else {
                    $sNextName = $oNext->getName();
                    $oNextTitle = Title::makeTitle( NS_SPECIAL, "CustomizeWiki" );
                    $wgOut->redirect( $oNextTitle->getFullUrl( "module={$sNextName}" ) );
                    return;
                }
            }
        }

        $wgOut->addHTML( $this->mModule->getHTML( $this->mTitle ) );
    }


    /**
     * nextModule
     *
     * next module to current
     *
     * @author eloy@wikia
     * @access public
     * @static
     *
     * @return array: return next value of self::$mModuleList or null
     *  if already on last value
     */
    public static function nextModule( $current )
    {
        $iModules = sizeof(self::$mModuleList) - 1;
        $iNextID = 0;

        foreach ( self::$mModuleList as $id => $module ) {
            if ($module["name"] === $current->getName()) {
                $iNextID = $id + 1;
            }
        }
        if ( $iNextID <= $iModules) {
            $sClass = self::$mModuleList[$iNextID]["class"];
            $oNext = new $sClass;
            return $oNext;
        }
        return null;
    }

    /**
     * ModuleByName
     *
     * next module to current
     *
     * @author eloy@wikia
     * @access public
     * @static
     *
     * @param string $name: name of module
     *
     * @return array: return module from self::$mModuleList or return
     *  _FIRST/ZERO_INDEX_ module if not match or return null if any module
     *  is defined
     */
    public static function ModuleByName( $name )
    {
        $aClass = null;
        if (is_array(self::$mModuleList)) {
            foreach( self::$mModuleList as $module) {
                if ( $module["name"] === $name ) {
                    $aClass = $module;
                }
            }
            if ( is_null($aClass) && isset(self::$mModuleList[0]) ) {
                $aClass = self::$mModuleList[0];
            }
            if ( isset($aClass["class"]) ) {
                return new $aClass["class"];
            }
        }
        return null;
    }

    /**
     * show all modules on one page
     *
     * @access public
     * @author eloy@wikia
     *
     * @param string $default default null: mark module as default
     *
     * @return HTML page with all modules
     */
    public function allTogetherNow( $default = null )
    {
        $aPages = array();
        $aNames = array();
        $aLabels = array();

        #--- first take HTML pages for all modules
        if (is_array(self::$mModuleList)) {
            $counter = 0;
            foreach ( self::$mModuleList as $module ) {
                $oModule = self::ModuleByName( $module["name"] );

                #--- we are on the same page?
                $aPages[ $counter ] = $oModule->getHTML( $this->mTitle );
                $aNames[ $counter ] = $module["name"];
                $aLabels[ $counter ] = $oModule->getLabel();

                $counter++;
            }
        }

        $oTmpl = new EasyTemplate( dirname( __FILE__ )."/templates/" );
        $oTmpl->set_vars( array(
            "title" => $title,
            "pages" => $aPages,
            "names" => $aNames,
            "labels" => $aLabels
        ));
        return $oTmpl->execute( "tabview" );

    }
}
