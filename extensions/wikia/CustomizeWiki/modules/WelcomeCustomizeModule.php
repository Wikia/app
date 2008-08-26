<?php

/**
 * @package MediaWiki
 * @subpackage CustomizeWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}


class WelcomeCustomizeModule extends CustomizeModule {

    public function getHTML( &$title )
    {
        global $wgCityId;

        $aWikiData = WikiFactory::GetWikiByID( $wgCityId );
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) );
        $oTmpl->set_vars( array(
            "wiki"  => $aWikiData,
            "next" => $this->getNext(),
            "title" => $title,
            "module" => $this,
            "breadCrumbs" =>  wfGetBreadCrumb( $wgCityId ),
            "postinfo" => $this->getPostInfo( true /*remove from $_SESSION */),            
            "customDescription" => $this->getCustomDescription( $aWikiData->description )
        ));
        return $oTmpl->execute( "WelcomeCustomizeModule" );
    }

    public function getLabel()
    {
        return "Description";
    }

    public function getName()
    {
        return "welcome";
    }

    public function submit( &$request )
    {
        global $wgCityId;

        $iWikiID = $request->getVal("wpWikiID");
        $sDescription = $request->getText("wpDescription");
        if ( $wgCityId == $iWikiID && ! is_null( $wgCityId ) && strlen(trim($sDescription)) ) {

                #--- change description in database
                $dbw = wfGetDB( DB_MASTER );
                $dbw->update(
                    wfSharedTable("city_list"),
                    array( "city_description" => $sDescription ),
                    array( "city_id" => $wgCityId ),
                    __METHOD__
                );
        }
        #--- now set this message as MediaWiki:CustomDescription
        $oTitle = Title::newFromText( "CustomDescription", NS_MEDIAWIKI );
        $oArticle = new Article( $oTitle );
        $oArticle->doEdit( $sDescription, "Set new default site description" );

        return new CustomizeModuleResponse( true, wfMsgForContent("customwelcome_success"));
    }

    /**
     * getCustomDescription
     *
     * get custom description from article or database.
     * order is:
     *
     * 1. Article MediaWiki:CustomDescription
     * 2. Description given as parameter (to avoid double checking database)
     * 3. From shared database city_list table
     *
     * @access private
     * @author eloy@wikia
     *
     * @param string $description default null: fallback description
     *
     * @return string: wiki description
     */
    private function getCustomDescription( $description = null )
    {
        global $wgCityId;

        #--- first try article
        $oTitle = Title::newFromText( "CustomDescription", NS_MEDIAWIKI );
        $oArticle = new Article( $oTitle );
        if ( $oArticle->getID() ) {
            return $oArticle->getContent();
        }

        #--- fallback
        if ( !is_null( $description) ) {
            return $description;
        }

        #--- usually the same as fallback
        $oWiki = WikiFactory::GetWikiByID( $wgCityId );
        return $oWiki->city_description;

        #--- second $aWikiData->description
    }
};

#--- Add messages
global $wgMessageCache, $wgWelcomeCustomizeModuleMsgs;

$wgWelcomeCustomizeModuleMsgs = array();
$wgWelcomeCustomizeModuleMsgs["en"] = array(
    "customwelcome_label" => "Wiki Description - introduce new users to this wiki",
    "customwelcome_welcomeinfo" => "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur in ligula in massa fermentum dictum. Sed porta adipiscing lorem. Morbi pellentesque nibh in ante. Duis laoreet lacus fermentum tortor. Vivamus mattis tortor. Quisque et ante. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur imperdiet dolor ac leo. Phasellus tincidunt. Proin diam justo, lobortis ut, volutpat sit amet, semper vel, massa. Proin blandit arcu eu dui porttitor ullamcorper. Integer velit. Nulla facilisi. Maecenas gravida neque.",
    "customwelcome_yourwikiname" => "Your Wiki name:",
    "customwelcome_yourwikiurl" => "Wiki URL:",
    "customwelcome_yourwikicategory" => "Wiki Category:",
    "customwelcome_success" => "Description saved"
);

foreach( $wgWelcomeCustomizeModuleMsgs as $key => $value ) {
    $wgMessageCache->addMessages( $wgWelcomeCustomizeModuleMsgs[$key], $key );
}
